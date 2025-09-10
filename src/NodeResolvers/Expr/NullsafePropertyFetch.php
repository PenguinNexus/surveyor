<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class NullsafePropertyFetch extends AbstractResolver
{
    public function resolve(Node\Expr\NullsafePropertyFetch $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
