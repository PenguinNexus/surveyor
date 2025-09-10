<?php

namespace Laravel\Surveyor\DocBlockResolvers\ConstExpr;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ConstExprIntegerNode extends AbstractResolver
{
    public function resolve(Ast\ConstExpr\ConstExprIntegerNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
