<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\BinaryOp;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class LogicalOr extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\LogicalOr $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
