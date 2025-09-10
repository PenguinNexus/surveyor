<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar\MagicConst;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Method extends AbstractResolver
{
    public function resolve(Node\Scalar\MagicConst\Method $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
