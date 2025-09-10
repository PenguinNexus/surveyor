<?php

namespace Laravel\Surveyor\NodeResolvers\Scalar\MagicConst;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class File extends AbstractResolver
{
    public function resolve(Node\Scalar\MagicConst\File $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
