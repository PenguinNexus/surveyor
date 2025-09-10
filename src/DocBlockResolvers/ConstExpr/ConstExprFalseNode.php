<?php

namespace Laravel\Surveyor\DocBlockResolvers\ConstExpr;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ConstExprFalseNode extends AbstractResolver
{
    public function resolve(Ast\ConstExpr\ConstExprFalseNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
