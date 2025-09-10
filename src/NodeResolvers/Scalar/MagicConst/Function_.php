<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar\MagicConst;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Function_ extends AbstractResolver
{
    public function resolve(Node\Scalar\MagicConst\Function_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
