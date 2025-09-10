<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Encapsed extends AbstractResolver
{
    public function resolve(Node\Scalar\Encapsed $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
