<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class PropertyItem extends AbstractResolver
{
    public function resolve(Node\PropertyItem $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
