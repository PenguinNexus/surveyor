<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Expr;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class ClassConstFetch extends AbstractResolver
{
    public function resolve(Node\Expr\ClassConstFetch $node)
    {
        if ($node->name instanceof Node\Identifier && $node->name->name === 'class') {
            return $this->from($node->class);
        }

        dd($node, 'class const fetch not implemented yet');
    }
}
