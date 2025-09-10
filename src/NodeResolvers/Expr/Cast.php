<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Cast extends AbstractResolver
{
    public function resolve(Node\Expr\Cast $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
