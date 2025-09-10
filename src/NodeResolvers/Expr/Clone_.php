<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Clone_ extends AbstractResolver
{
    public function resolve(Node\Expr\Clone_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
