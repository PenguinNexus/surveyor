<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class EncapsedStringPart extends AbstractResolver
{
    public function resolve(Node\Scalar\EncapsedStringPart $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
