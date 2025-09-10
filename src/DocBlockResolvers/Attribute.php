<?php

namespace Laravel\Surveyor\DocBlockResolvers\Attribute;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class Attribute extends AbstractResolver
{
    public function resolve(Ast\Attribute $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
