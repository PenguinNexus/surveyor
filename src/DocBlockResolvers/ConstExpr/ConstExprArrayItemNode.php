<?php

namespace Laravel\Surveyor\DocBlockResolvers\ConstExpr;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ConstExprArrayItemNode extends AbstractResolver
{
    public function resolve(Ast\ConstExpr\ConstExprArrayItemNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
