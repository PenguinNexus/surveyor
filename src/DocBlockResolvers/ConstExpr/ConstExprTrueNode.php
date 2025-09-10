<?php

namespace Laravel\Surveyor\DocBlockResolvers\ConstExpr;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ConstExprTrueNode extends AbstractResolver
{
    public function resolve(Ast\ConstExpr\ConstExprTrueNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
