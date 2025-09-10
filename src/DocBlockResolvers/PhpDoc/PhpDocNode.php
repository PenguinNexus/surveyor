<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class PhpDocNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\PhpDocNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
