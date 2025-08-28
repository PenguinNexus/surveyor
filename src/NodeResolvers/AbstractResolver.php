<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use Laravel\StaticAnalyzer\Analysis\Scope;
use Laravel\StaticAnalyzer\Debug\Debug;
use Laravel\StaticAnalyzer\Parser\DocBlockParser;
use Laravel\StaticAnalyzer\Reflector\Reflector;
use Laravel\StaticAnalyzer\Resolvers\NodeResolver;
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
        Debug::log('🔍 Resolving Node: '.$node->getType());

        if ($this->scope->className()) {
            if ($this->scope->methodName()) {
                Debug::log('🔬 Scope: '.$this->scope->className().'::'.$this->scope->methodName());
            } else {
                Debug::log('🔬 Scope: '.$this->scope->className());
            }
        }

        return $this->resolver->from($node, $this->scope);
    }
}
