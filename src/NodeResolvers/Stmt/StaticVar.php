<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class StaticVar extends AbstractResolver
{
    public function resolve(Node\Stmt\StaticVar $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
