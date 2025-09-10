<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Trait_ extends AbstractResolver
{
    public function resolve(Node\Stmt\Trait_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
