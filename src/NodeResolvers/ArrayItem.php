<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class ArrayItem extends AbstractResolver
{
    public function resolve(Node\ArrayItem $node)
    {
        // TODO: This is probably wrong
        return null;
    }
}
