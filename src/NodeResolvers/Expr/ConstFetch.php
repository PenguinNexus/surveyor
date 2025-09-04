<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Expr;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Types\Type;
use PhpParser\Node;

class ConstFetch extends AbstractResolver
{
    public function resolve(Node\Expr\ConstFetch $node)
    {
        return Type::from($node->name->toString());
    }
}
