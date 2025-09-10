<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Float_ extends AbstractResolver
{
    public function resolve(Node\Scalar\Float_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
