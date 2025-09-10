<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\Cast;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Bool_ extends AbstractResolver
{
    public function resolve(Node\Expr\Cast\Bool_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
