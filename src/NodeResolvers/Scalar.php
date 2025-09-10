<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class Scalar extends AbstractResolver
{
    public function resolve(Node\Scalar $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
