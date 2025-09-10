<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\ClassType;
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
