<?php

namespace Laravel\Surveyor\DocBlockResolvers\ConstExpr;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ConstExprStringNode extends AbstractResolver
{
    public function resolve(Ast\ConstExpr\ConstExprStringNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
