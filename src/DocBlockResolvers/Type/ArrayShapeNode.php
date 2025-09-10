<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ArrayShapeNode extends AbstractResolver
{
    public function resolve(Ast\Type\ArrayShapeNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
