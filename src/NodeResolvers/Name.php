<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class Name extends AbstractResolver
{
    public function resolve(Node\Name $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
