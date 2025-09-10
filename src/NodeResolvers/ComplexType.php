<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class ComplexType extends AbstractResolver
{
    public function resolve(Node\ComplexType $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
