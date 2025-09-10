<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class Attribute extends AbstractResolver
{
    public function resolve(Node\Attribute $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
