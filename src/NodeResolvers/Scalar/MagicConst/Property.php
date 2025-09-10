<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar\MagicConst;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Property extends AbstractResolver
{
    public function resolve(Node\Scalar\MagicConst\Property $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
