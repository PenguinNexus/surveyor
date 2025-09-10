<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class VarLikeIdentifier extends AbstractResolver
{
    public function resolve(Node\VarLikeIdentifier $node)
    {
        return null;
    }
}
