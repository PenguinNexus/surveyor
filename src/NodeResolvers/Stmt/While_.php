<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class While_ extends AbstractResolver
{
    public function resolve(Node\Stmt\While_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
