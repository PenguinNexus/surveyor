<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class GroupUse extends AbstractResolver
{
    public function resolve(Node\Stmt\GroupUse $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
