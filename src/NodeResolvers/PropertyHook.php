<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class PropertyHook extends AbstractResolver
{
    public function resolve(Node\PropertyHook $node)
    {
        dd($node, $node::class . ' not implemented yet');
    }
}
