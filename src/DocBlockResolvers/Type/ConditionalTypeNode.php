<?php

namespace Laravel\Surveyor\DocBlockResolvers\Type;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ConditionalTypeNode extends AbstractResolver
{
    public function resolve(Ast\Type\ConditionalTypeNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
