<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Expr;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Types\ArrayType;
use Laravel\StaticAnalyzer\Types\Type;
use PhpParser\Node;

class ArrayDimFetch extends AbstractResolver
{
    public function resolve(Node\Expr\ArrayDimFetch $node)
    {
        $var = $this->from($node->var);
        $dim = $this->from($node->dim);

        if (! $var instanceof ArrayType) {
            dd('ArrayDimFetch on non-array?', $var);
        }

        if (property_exists($dim, 'value')) {
            return $var->value[$dim->value] ?? Type::mixed();
        }

        return Type::mixed();
    }
}
