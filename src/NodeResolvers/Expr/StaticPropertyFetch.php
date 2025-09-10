<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class StaticPropertyFetch extends AbstractResolver
{
    public function resolve(Node\Expr\StaticPropertyFetch $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
