<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar\MagicConst;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Namespace_ extends AbstractResolver
{
    public function resolve(Node\Scalar\MagicConst\Namespace_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
