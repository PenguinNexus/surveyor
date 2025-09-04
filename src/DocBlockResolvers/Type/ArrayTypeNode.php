<?php

namespace Laravel\StaticAnalyzer\DocBlockResolvers\Type;

use Laravel\StaticAnalyzer\DocBlockResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Types\Type;
use PHPStan\PhpDocParser\Ast;

class ArrayTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\ArrayTypeNode $node)
    {
        return Type::arrayShape(Type::int(), $this->from($node->type));
    }
}
