<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class StaticVar extends AbstractResolver
{
    public function resolve(Node\StaticVar $node)
    {
        dd($node, $node::class . ' not implemented yet');
    }
}
