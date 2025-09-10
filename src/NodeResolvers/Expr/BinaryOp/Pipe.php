<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\BinaryOp;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Pipe extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\Pipe $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
