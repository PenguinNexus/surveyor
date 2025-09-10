<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class DNumber extends AbstractResolver
{
    public function resolve(Node\Scalar\DNumber $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
