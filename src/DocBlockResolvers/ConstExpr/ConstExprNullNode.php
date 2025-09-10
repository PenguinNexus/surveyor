<?php

namespace Laravel\Surveyor\DocBlockResolvers\ConstExpr;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ConstExprNullNode extends AbstractResolver
{
    public function resolve(Ast\ConstExpr\ConstExprNullNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
