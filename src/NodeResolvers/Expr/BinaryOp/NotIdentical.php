<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Expr\BinaryOp;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Types\Type;
use PhpParser\Node;

class NotIdentical extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\NotIdentical $node)
    {
        return Type::bool();
    }
}
