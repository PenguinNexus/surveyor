<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class VarLikeIdentifier extends AbstractResolver
{
    public function resolve(Node\VarLikeIdentifier $node)
    {
        dd($node, $node::class . ' not implemented yet');
    }
}
