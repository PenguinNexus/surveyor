<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Exit_ extends AbstractResolver
{
    public function resolve(Node\Expr\Exit_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
