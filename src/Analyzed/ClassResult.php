<?php

namespace Laravel\Surveyor\Analyzed;

use Laravel\Surveyor\Analysis\EntityType;
use Laravel\Surveyor\Analysis\Scope;

class ClassResult
{
    /** @var array<string, PropertyResult> */
    protected array $properties = [];

    /** @var array<string, ConstantResult> */
    protected array $constants = [];

    /** @var list<string> */
    protected array $traits = [];

    /** @var array<string, MethodResult> */
    protected array $methods = [];

    /**
     * @param  list<string>  $extends
     * @param  list<string>  $implements
     * @param  array<string, string>  $uses
     */
    public function __construct(
        protected string $name,
        protected string $namespace,
        protected array $extends,
        protected array $implements,
        protected array $uses,
    ) {
        //
    }

    public function addMethod(MethodResult $method): void
    {
        $this->methods[$method->name] = $method;
    }

    /**
     * @param  array<Scope>  $children
     */
    protected static function mapMethods(array $children): array
    {
        $results = [];

        foreach ($children as $child) {
            if ($child->entityType() === EntityType::METHOD_TYPE) {
                $results[$child->methodName()] = MethodResult::fromScope($child);
            }
        }

        return $results;
    }

    protected static function mapConstants(array $constants): array
    {
        $results = [];

        foreach ($constants as $name => $constant) {
            $results[$name] = new ConstantResult(
                name: $name,
                type: $constant,
            );
        }

        return $results;
    }

    protected static function mapProperties(array $properties): array
    {
        $results = [];

        foreach ($properties as $name => $propertyStates) {
            $results[$name] = new PropertyResult(
                name: $name,
                type: $propertyStates[0]->type(),
                fromDocBlock: $propertyStates[0]->isFromDocBlock(),
            );
        }

        return $results;
    }

    public function extends(...$extends): array|bool
    {
        if (empty($extends)) {
            return $this->extends;
        }

        return in_array($extends, $this->extends);
    }

    public function implements(...$implements): array|bool
    {
        if (empty($implements)) {
            return $this->implements;
        }

        return in_array($implements, $this->implements);
    }

    public function hasMethod(string $name): bool
    {
        return isset($this->methods[$name]);
    }

    public function getMethod(string $name): MethodResult
    {
        return $this->methods[$name];
    }

    public function hasProperty(string $name): bool
    {
        return isset($this->properties[$name]);
    }

    public function getProperty(string $name): PropertyResult
    {
        return $this->properties[$name];
    }

    public function hasConstant(string $name): bool
    {
        return isset($this->constants[$name]);
    }

    public function getConstant(string $name): ConstantResult
    {
        return $this->constants[$name];
    }

    public function hasUse(string $name): bool
    {
        return isset($this->uses[$name]);
    }

    public function getUse(string $name): ?string
    {
        return $this->uses[$name] ?? null;
    }
}
