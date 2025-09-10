<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class ClosureUse extends AbstractResolver
{
    public function resolve(Node\Expr\ClosureUse $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
