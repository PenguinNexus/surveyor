<?php

namespace Laravel\StaticAnalyzer\Analysis;

use Laravel\StaticAnalyzer\Result\VariableTracker;

class Scope
{
    protected ?string $className = null;

    protected ?string $methodName = null;

    protected VariableTracker $variableTracker;

    protected array $children = [];

    public function __construct(protected ?Scope $parent = null)
    {
        $this->variableTracker = new VariableTracker;
    }

    public function setClassName(string $className): void
    {
        $this->className = $className;
        $this->variableTracker->setThis($className);
    }

    public function newChildScope(): self
    {
        $instance = new self;

        if ($this->className) {
            $instance->setClassName($this->className);
        }

        if ($this->methodName) {
            $instance->setMethodName($this->methodName);
        }

        // $this->children[] = $instance;

        return $instance;
    }

    public function setMethodName(string $methodName): void
    {
        $this->methodName = $methodName;
    }

    public function className(): ?string
    {
        return $this->className;
    }

    public function methodName(): ?string
    {
        return $this->methodName;
    }

    public function variableTracker()
    {
        return $this->variableTracker;
    }
}
