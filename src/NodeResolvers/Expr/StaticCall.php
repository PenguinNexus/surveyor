<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class StaticCall extends AbstractResolver
{
    public function resolve(Node\Expr\StaticCall $node)
    {
        $class = $this->from($node->class);
        $method = $node->name->toString();

        $returnTypes = $this->reflector->methodReturnType($class, $method, $node);

        return Type::union(...$returnTypes);
    }

    public function resolveForCondition(Node\Expr\StaticCall $node)
    {
        return $this->fromOutsideOfCondition($node);
    }
}
