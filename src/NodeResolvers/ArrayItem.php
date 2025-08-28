<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class ArrayItem extends AbstractResolver
{
    public function resolve(Node\ArrayItem $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
