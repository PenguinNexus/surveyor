<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class ClassLike extends AbstractResolver
{
    public function resolve(Node\Stmt\ClassLike $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
