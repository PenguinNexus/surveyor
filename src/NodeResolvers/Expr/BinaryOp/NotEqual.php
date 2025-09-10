<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\BinaryOp;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class NotEqual extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\NotEqual $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
