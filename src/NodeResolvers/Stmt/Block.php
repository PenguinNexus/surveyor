<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Block extends AbstractResolver
{
    public function resolve(Node\Stmt\Block $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
