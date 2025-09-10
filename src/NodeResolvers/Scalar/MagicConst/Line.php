<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar\MagicConst;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Line extends AbstractResolver
{
    public function resolve(Node\Scalar\MagicConst\Line $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
