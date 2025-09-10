<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class IntersectionType extends AbstractResolver
{
    public function resolve(Node\IntersectionType $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
