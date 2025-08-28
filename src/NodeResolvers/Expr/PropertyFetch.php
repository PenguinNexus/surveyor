<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Expr;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class PropertyFetch extends AbstractResolver
{
    public function resolve(Node\Expr\PropertyFetch $node)
    {
        dump([
            $node->name,
            $this->from($node->var),
        ]);

        return $this->reflector->propertyType($node->name, $this->from($node->var), $node);
    }
}
