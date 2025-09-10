<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar\MagicConst;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Dir extends AbstractResolver
{
    public function resolve(Node\Scalar\MagicConst\Dir $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
