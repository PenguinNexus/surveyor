<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class TraitUseAdaptation extends AbstractResolver
{
    public function resolve(Node\Stmt\TraitUseAdaptation $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
