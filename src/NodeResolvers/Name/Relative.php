<?php

namespace Laravel\Surveyor\NodeResolvers\Name;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Relative extends AbstractResolver
{
    public function resolve(Node\Name\Relative $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
