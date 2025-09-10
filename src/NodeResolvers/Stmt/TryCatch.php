<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class TryCatch extends AbstractResolver
{
    public function resolve(Node\Stmt\TryCatch $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
