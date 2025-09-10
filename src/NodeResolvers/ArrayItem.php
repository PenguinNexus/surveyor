<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class ArrayItem extends AbstractResolver
{
    public function resolve(Node\ArrayItem $node)
    {
        // TODO: This is probably wrong
        return null;
    }
}
