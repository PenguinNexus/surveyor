<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class PropertyProperty extends AbstractResolver
{
    public function resolve(Node\Stmt\PropertyProperty $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
