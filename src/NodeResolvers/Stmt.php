<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Stmt extends AbstractResolver
{
    public function resolve(Node\Stmt $node)
    {
        dd($node, $node::class . ' not implemented yet');
    }
}
