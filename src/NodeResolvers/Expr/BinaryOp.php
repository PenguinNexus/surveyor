<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class BinaryOp extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
