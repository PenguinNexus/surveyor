<?php

namespace Laravel\StaticAnalyzer\DocBlockResolvers\Type;

use Laravel\StaticAnalyzer\DocBlockResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Types\Type;
use PHPStan\PhpDocParser\Ast;

class GenericTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\GenericTypeNode $node)
    {
        $baseType = $this->from($node->type);

        $genericTypes = collect($node->genericTypes)
            ->map(fn ($type) => $this->from($type))
            ->all();

        return Type::generic($baseType->id(), $genericTypes);
    }
}
