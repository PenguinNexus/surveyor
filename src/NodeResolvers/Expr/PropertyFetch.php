<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Expr;

use Laravel\StaticAnalyzer\Debug\Debug;
use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class PropertyFetch extends AbstractResolver
{
    public function resolve(Node\Expr\PropertyFetch $node)
    {
        return $this->reflector->propertyType($node->name, $this->from($node->var), $node);
    }
}
