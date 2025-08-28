<?php

namespace Laravel\StaticAnalyzer\Reflector;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\StaticAnalyzer\Analysis\Scope;
use Laravel\StaticAnalyzer\Analyzer\Analyzer;
use Laravel\StaticAnalyzer\Parser\DocBlockParser;
use Laravel\StaticAnalyzer\Parser\Parser;
use Laravel\StaticAnalyzer\Resolvers\NodeResolver;
use Laravel\StaticAnalyzer\Types\ClassType;
use Laravel\StaticAnalyzer\Types\Contracts\Type as TypeContract;
use Laravel\StaticAnalyzer\Types\Type;
use PhpParser\Node;
use PhpParser\Node\Expr\CallLike;
use ReflectionClass;
use ReflectionFunction;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionUnionType;

class Reflector
{
    protected Scope $scope;

    public function __construct(
        protected DocBlockParser $docBlockParser,
    ) {
        //
    }

    public function setScope(Scope $scope)
    {
        $this->scope = $scope;
        $this->docBlockParser->setScope($scope);
    }

    public function functionReturnType(string $name, ?Node $node = null): array
    {
        $returnTypes = [];
        $reflection = new ReflectionFunction($name);

        $known = $this->tryKnownFunctions($name, $node);

        if ($known) {
            return $known;
        }

        if ($reflection->hasReturnType()) {
            $returnTypes[] = $this->returnType($reflection->getReturnType());
        }

        if ($reflection->getDocComment()) {
            array_push(
                $returnTypes,
                ...($this->docBlockParser->parseReturn($reflection->getDocComment(), $node) ?? []),
            );
        }

        return $returnTypes;
    }

    protected function tryKnownFunctions(string $name, ?CallLike $node = null): ?array
    {
        if ($name === 'compact') {
            $arr = collect($node->getArgs())->flatMap(function ($arg) use ($node) {
                if ($arg->value instanceof Node\Scalar\String_) {
                    return [
                        $arg->value->value => $this->scope->variableTracker()->getAtLine($arg->value->value, $node->getStartLine())['type'],
                    ];
                }

                dd('not a string for compact', $arg);
            });

            return [Type::array($arr->all())];
        }

        return null;
    }

    public function propertyType(string $name, ClassType|string $class, ?Node $node = null): ?TypeContract
    {
        $reflection = $this->reflectClass($class);

        if (! $reflection->hasProperty($name)) {
            if ($reflection->getDocComment()) {
                dd($reflection->getDocComment(), $class, $name, 'not a property but has a docblock??');
            }

            dd($reflection, $name, 'doesnt have property??');
        }

        $propertyReflection = $reflection->getProperty($name);

        if ($propertyReflection->getDocComment()) {
            $result = $this->docBlockParser->parseVar($propertyReflection->getDocComment());

            if ($result) {
                return $result;
            }
        }

        dd($propertyReflection);

        if ($propertyReflection->hasType()) {
        }
    }

    public function methodReturnType(ClassType|string $class, string $method, ?Node $node = null): array
    {
        $className = $class instanceof ClassType ? $class->value : $class;
        $reflection = $this->reflectClass($class);
        $returnTypes = [];

        if ($reflection->hasMethod($method)) {
            $methodReflection = $reflection->getMethod($method);

            if ($methodReflection->hasReturnType()) {
                $returnTypes[] = $this->returnType($methodReflection->getReturnType());
            }

            array_push(
                $returnTypes,
                ...$this->parseDocBlock($methodReflection->getDocComment(), $node)
            );
        }

        if ($reflection->getDocComment()) {
            array_push(
                $returnTypes,
                ...$this->parseDocBlock($reflection->getDocComment(), $node)
            );
        }

        if ($reflection->isSubclassOf(Model::class)) {
            array_push(
                $returnTypes,
                ...$this->methodReturnType(Builder::class, $method, $node),
            );
        }

        // if (method_exists($classType->value, $node->name->name)) {
        //     // We couldn't figure it out...
        //     return RangerType::mixed();
        // }

        // if (! method_exists($classType->value, 'hasMacro') || ! $classType->value::hasMacro($node->name->name)) {
        //     // If the method doesn't exist and the class doesn't have macros, we can't do anything
        //     return RangerType::mixed();
        // }

        if (count($returnTypes) === 0 && (method_exists($className, 'hasMacro') || $className::hasMacro($node->name->name))) {
            $reflectionProperty = $reflection->getProperty('macros');
            $reflectionProperty->setAccessible(true);
            $macros = $reflectionProperty->getValue($reflection);

            $funcReflection = new ReflectionFunction($macros[$node->name->name]);
            $parser = app(Parser::class);

            $parsed = $parser->parse($funcReflection);

            app(Analyzer::class)->analyze($funcReflection->getFilename());

            $funcNode = $parser->nodeFinder()->findFirst(
                $parsed,
                fn ($n) => ($n instanceof Node\Expr\Closure || $n instanceof Node\Expr\ArrowFunction)
                    && $n->getStartLine() === $funcReflection->getStartLine(),
            );

            $result = app(NodeResolver::class)->from($funcNode);

            if ($result) {
                $returnTypes[] = $result;
            }
        }

        return $returnTypes;
    }

    public function returnType(ReflectionNamedType|ReflectionUnionType|ReflectionIntersectionType $returnType): ?TypeContract
    {
        if ($returnType instanceof ReflectionNamedType) {
            return Type::from($returnType->getName());
        }

        if ($returnType instanceof ReflectionUnionType) {
            return Type::union(
                ...collect($returnType->getTypes())
                    ->map(fn ($t) => Type::from($t->getName())->nullable($t->allowsNull())),
            );
        }

        if ($returnType instanceof ReflectionIntersectionType) {
            return Type::intersection(
                ...collect($returnType->getTypes())
                    ->map(fn ($t) => $this->returnType($t)?->nullable($t->allowsNull())),
            );
        }

        return null;
    }

    protected function parseDocBlock(string $docBlock, ?Node $node = null): array
    {
        if (! $docBlock) {
            return [];
        }

        $result = $this->docBlockParser->parseReturn($docBlock, $node);

        if ($result) {
            return $result->toArray();
        }

        return [];
    }

    protected function reflectClass(ClassType|string $class): ReflectionClass
    {
        $className = $class instanceof ClassType ? $class->value : $class;

        return new ReflectionClass($className);
    }
}
