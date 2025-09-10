<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class DeclareDeclare extends AbstractResolver
{
    public function resolve(Node\Stmt\DeclareDeclare $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
