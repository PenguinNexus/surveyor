<?php

namespace Laravel\Surveyor\DocBlockResolvers\ConstExpr;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ConstExprArrayNode extends AbstractResolver
{
    public function resolve(Ast\ConstExpr\ConstExprArrayNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
