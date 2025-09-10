<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class CallLike extends AbstractResolver
{
    public function resolve(Node\Expr\CallLike $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
