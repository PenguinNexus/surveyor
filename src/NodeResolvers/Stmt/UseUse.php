<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class UseUse extends AbstractResolver
{
    public function resolve(Node\Stmt\UseUse $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
