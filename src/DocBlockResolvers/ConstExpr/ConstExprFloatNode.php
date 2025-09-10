<?php

namespace Laravel\Surveyor\DocBlockResolvers\ConstExpr;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ConstExprFloatNode extends AbstractResolver
{
    public function resolve(Ast\ConstExpr\ConstExprFloatNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
