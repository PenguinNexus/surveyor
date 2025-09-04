<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Expr;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Types\ClassType;
use PhpParser\Node;

class PropertyFetch extends AbstractResolver
{
    public function resolve(Node\Expr\PropertyFetch $node)
    {
        if (! $this->from($node->var) instanceof ClassType) {
            dd('property fetch but not a class type??', $node->name, $node->var, $this->from($node->var), $this->scope);
        }

        return $this->reflector->propertyType($node->name, $this->from($node->var), $node);
    }
}
