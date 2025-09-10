<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Nop extends AbstractResolver
{
    public function resolve(Node\Stmt\Nop $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
