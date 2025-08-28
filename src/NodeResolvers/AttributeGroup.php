<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class AttributeGroup extends AbstractResolver
{
    public function resolve(Node\AttributeGroup $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
