<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class AttributeGroup extends AbstractResolver
{
    public function resolve(Node\AttributeGroup $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
