<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt\TraitUseAdaptation;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Alias extends AbstractResolver
{
    public function resolve(Node\Stmt\TraitUseAdaptation\Alias $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
