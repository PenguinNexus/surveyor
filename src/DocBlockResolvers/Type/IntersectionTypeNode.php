<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class IntersectionTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\IntersectionTypeNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
