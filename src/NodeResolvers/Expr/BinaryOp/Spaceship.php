<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\BinaryOp;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Spaceship extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\Spaceship $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
