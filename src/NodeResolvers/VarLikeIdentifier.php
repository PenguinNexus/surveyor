<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class VarLikeIdentifier extends AbstractResolver
{
    public function resolve(Node\VarLikeIdentifier $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
