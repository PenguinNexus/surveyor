<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class InlineHTML extends AbstractResolver
{
    public function resolve(Node\Stmt\InlineHTML $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
