<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class ClassConstFetch extends AbstractResolver
{
    public function resolve(Node\Expr\ClassConstFetch $node)
    {
        if ($node->name instanceof Node\Identifier && $node->name->name === 'class') {
            return $this->from($node->class);
        }

        return $this->scope->getConstant($node->name->name);
    }
}
