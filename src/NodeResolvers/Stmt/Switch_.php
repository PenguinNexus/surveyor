<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Switch_ extends AbstractResolver
{
    public function resolve(Node\Stmt\Switch_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
