<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class InterpolatedStringPart extends AbstractResolver
{
    public function resolve(Node\InterpolatedStringPart $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
