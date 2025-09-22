<?php

namespace Laravel\Surveyor\NodeResolvers\Shared;

use Laravel\Surveyor\Debug\Debug;
use Laravel\Surveyor\Types\ClassType;
use Laravel\Surveyor\Types\UnionType;
use PhpParser\Node;

trait ResolvesPropertyFetches
{
    protected function resolvePropertyFetch(
        Node\Expr\PropertyFetch|Node\Expr\NullsafePropertyFetch|Node\Expr\StaticPropertyFetch $node,
    ) {
        $type = $node instanceof Node\Expr\StaticPropertyFetch ? $this->from($node->class) : $this->from($node->var);

        if ($type instanceof UnionType) {
            foreach ($type->types as $type) {
                if ($type instanceof ClassType) {
                    return $this->reflector->propertyType($node->name, $type, $node);
                }
            }
        }

        if (! $type instanceof ClassType) {
            Debug::ddAndOpen($node, $this->from($node->var), 'property fetch but not a class type??');
        }

        return $this->reflector->propertyType($node->name, $type, $node);
    }
}
