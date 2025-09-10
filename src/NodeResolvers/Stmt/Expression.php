<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Expression extends AbstractResolver
{
    public function resolve(Node\Stmt\Expression $node)
    {
        return null;
    }
}
