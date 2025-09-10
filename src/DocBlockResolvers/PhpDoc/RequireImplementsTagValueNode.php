<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class RequireImplementsTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\RequireImplementsTagValueNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
