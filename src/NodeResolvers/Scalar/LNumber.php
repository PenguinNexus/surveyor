<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class LNumber extends AbstractResolver
{
    public function resolve(Node\Scalar\LNumber $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
