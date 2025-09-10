<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ObjectShapeNode extends AbstractResolver
{
    public function resolve(Ast\Type\ObjectShapeNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
