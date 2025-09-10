<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\Cast;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Double extends AbstractResolver
{
    public function resolve(Node\Expr\Cast\Double $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
