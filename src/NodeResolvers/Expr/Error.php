<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Error extends AbstractResolver
{
    public function resolve(Node\Expr\Error $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
