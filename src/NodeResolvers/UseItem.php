<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class UseItem extends AbstractResolver
{
    public function resolve(Node\UseItem $node)
    {
        return null;
    }
}
