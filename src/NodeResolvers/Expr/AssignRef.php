<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class AssignRef extends AbstractResolver
{
    public function resolve(Node\Expr\AssignRef $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
