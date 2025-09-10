<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class Property extends AbstractResolver
{
    public function resolve(Node\Stmt\Property $node)
    {
        foreach ($node->props as $prop) {
            $name = $prop->name->name;
            $this->scope->properties()->add(
                $name,
                $node->type ? $this->from($node->type) : Type::null(),
                $node->getLine()
            );
        }

        return null;
    }
}
