<?php

namespace Laravel\StaticAnalyzer\DocBlockResolvers\Type;

use Laravel\StaticAnalyzer\DocBlockResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Types\Type;
use PHPStan\PhpDocParser\Ast;

class UnionTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\UnionTypeNode $node)
    {
        return Type::union(...array_map(fn ($type) => $this->from($type), $node->types));
    }
}
