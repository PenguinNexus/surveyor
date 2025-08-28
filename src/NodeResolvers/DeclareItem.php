<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class DeclareItem extends AbstractResolver
{
    public function resolve(Node\DeclareItem $node)
    {
        dd($node, $node::class . ' not implemented yet');
    }
}
