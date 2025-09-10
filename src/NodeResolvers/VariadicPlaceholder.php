<?php

namespace Laravel\Surveyor\NodeResolvers;

use PhpParser\Node;

class VariadicPlaceholder extends AbstractResolver
{
    public function resolve(Node\VariadicPlaceholder $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
