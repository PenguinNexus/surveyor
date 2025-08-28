<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class UseItem extends AbstractResolver
{
    public function resolve(Node\UseItem $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
