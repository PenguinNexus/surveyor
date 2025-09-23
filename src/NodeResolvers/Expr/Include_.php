<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Include_ extends AbstractResolver
{
    public function resolve(Node\Expr\Include_ $node)
    {
        // TODO: Should handle this...
        return null;
    }
}
