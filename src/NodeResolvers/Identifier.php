<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Types\Type;
use PhpParser\Node;

class Identifier extends AbstractResolver
{
    public function resolve(Node\Identifier $node)
    {
        return Type::from($node->name);
    }
}
