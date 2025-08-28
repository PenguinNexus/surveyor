<?php

namespace Laravel\StaticAnalyzer\Resolvers;

// use Laravel\StaticAnalyzer\Debug;
// use Laravel\StaticAnalyzer\Types\Contracts\Type;

use Illuminate\Container\Container;
use Laravel\StaticAnalyzer\Analysis\Scope;
use PhpParser\NodeAbstract;

class NodeResolver
{
    // protected array $parsed = [];

    public function __construct(
        protected Container $container,
    ) {}

    // public function setParsed(array $parsed): self
    // {
    //     $this->parsed = $parsed;

    //     return $this;
    // }

    public function from(NodeAbstract $node, Scope $scope)
    {
        $className = str(get_class($node))->after('Node\\')->prepend('Laravel\\StaticAnalyzer\\NodeResolvers\\')->toString();

        if (! class_exists($className)) {
            dd("NodeResolver: Class {$className} does not exist");
        }

        return $this->container->make($className, [
            // 'typeResolver' => $this,
            // 'context' => $context,
            // 'parsed' => $this->parsed,
            'scope' => $scope,
        ])->resolve($node);
    }
}
