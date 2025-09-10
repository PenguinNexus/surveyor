<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar\MagicConst;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Trait_ extends AbstractResolver
{
    public function resolve(Node\Scalar\MagicConst\Trait_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
