<?php

namespace Laravel\Surveyor\NodeResolvers\Expr\Cast;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Object_ extends AbstractResolver
{
    public function resolve(Node\Expr\Cast\Object_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
