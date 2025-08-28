<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use Laravel\StaticAnalyzer\Analysis\Scope;
use Laravel\StaticAnalyzer\Debug\Debug;
use Laravel\StaticAnalyzer\Reflector\Reflector;
use Laravel\StaticAnalyzer\Resolvers\NodeResolver;
use Laravel\StaticAnalyzer\Parser\DocBlockParser;
use PhpParser\NodeAbstract;

abstract class AbstractResolver
{
    public function __construct(
        protected NodeResolver $resolver,
        protected DocBlockParser $docBlockParser,
        protected Reflector $reflector,
        protected Scope $scope,
    ) {
        $this->reflector->setScope($scope);
    }

    protected function from(NodeAbstract $node)
    {
        Debug::log('🔍 Resolving Node: ' . $node->getType());
        Debug::log('🔬 Scope: ' . $this->scope->className() . '::' . $this->scope->methodName());

        return $this->resolver->from($node, $this->scope);
    }
}
