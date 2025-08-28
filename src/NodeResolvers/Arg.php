<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class Arg extends AbstractResolver
{
    public function resolve(Node\Arg $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
