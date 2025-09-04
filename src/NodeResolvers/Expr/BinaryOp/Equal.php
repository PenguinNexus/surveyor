<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Expr\BinaryOp;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Types\Type;
use PhpParser\Node;

class Equal extends AbstractResolver
{
    public function resolve(Node\Expr\BinaryOp\Equal $node)
    {
        return Type::bool();
    }
}
