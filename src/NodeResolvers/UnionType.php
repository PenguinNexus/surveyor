<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class UnionType extends AbstractResolver
{
    public function resolve(Node\UnionType $node)
    {
        dd($node, $node::class . ' not implemented yet');
    }
}
