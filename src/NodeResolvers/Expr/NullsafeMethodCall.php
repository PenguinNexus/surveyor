<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class NullsafeMethodCall extends AbstractResolver
{
    public function resolve(Node\Expr\NullsafeMethodCall $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
