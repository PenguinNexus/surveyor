<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Name extends AbstractResolver
{
    public function resolve(Node\Name $node)
    {
        dd($node, $node::class . ' not implemented yet');
    }
}
