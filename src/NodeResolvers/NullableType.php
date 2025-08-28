<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class NullableType extends AbstractResolver
{
    public function resolve(Node\NullableType $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
