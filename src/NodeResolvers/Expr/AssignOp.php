<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class AssignOp extends AbstractResolver
{
    public function resolve(Node\Expr\AssignOp $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
