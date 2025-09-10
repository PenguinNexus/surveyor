<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ExtendsTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\ExtendsTagValueNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
