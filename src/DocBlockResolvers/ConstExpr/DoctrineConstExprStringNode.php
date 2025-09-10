<?php

namespace Laravel\Surveyor\DocBlockResolvers\ConstExpr;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class DoctrineConstExprStringNode extends AbstractResolver
{
    public function resolve(Ast\ConstExpr\DoctrineConstExprStringNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
