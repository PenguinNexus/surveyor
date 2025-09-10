<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ArrayShapeUnsealedTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\ArrayShapeUnsealedTypeNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
