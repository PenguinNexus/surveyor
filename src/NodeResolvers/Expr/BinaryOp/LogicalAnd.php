<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\BinaryOp;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class LogicalAnd extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\LogicalAnd $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
