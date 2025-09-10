<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class ArrayItem extends AbstractResolver
{
    public function resolve(Node\Expr\ArrayItem $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
