<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\BinaryOp;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Mul extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\Mul $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
