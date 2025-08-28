<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Stmt;

use Laravel\StaticAnalyzer\Debug\Debug;
use Laravel\StaticAnalyzer\Analysis\ReturnTypeAnalyzer;
use Laravel\StaticAnalyzer\Analysis\VariableAnalyzer;
use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Result\ClassMethodDeclaration;
use PhpParser\Node;

class ClassMethod extends AbstractResolver
{
    public function resolve(Node\Stmt\ClassMethod $node)
    {
        Debug::log('Resolving Method: ' . $node->name->toString());

        $this->scope = $this->scope->newChildScope();
        $this->scope->setMethodName($node->name->toString());

        $analyzer = new VariableAnalyzer(
            $this->resolver,
            $this->docBlockParser,
            $this->reflector,
            $this->scope,
        );

        $analyzer->analyze($node, $this->scope);

        return (new ClassMethodDeclaration(
            name: $node->name->toString(),
            parameters: $this->getAllParameters($node),
            returnTypes: $this->getAllReturnTypes($node),
        ))->fromNode($node);
    }

    protected function getAllParameters(Node\Stmt\ClassMethod $node)
    {
        return array_map(fn($n) => $this->from($n), $node->params);
    }

    protected function getAllReturnTypes(Node\Stmt\ClassMethod $node)
    {
        $analyzer = new ReturnTypeAnalyzer(
            $this->resolver,
            $this->docBlockParser,
            $this->reflector,
            $this->scope,
        );

        return $analyzer->analyze($node, $this->scope);
    }
}
