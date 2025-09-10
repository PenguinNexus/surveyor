<?php

namespace Laravel\Surveyor\DocBlockResolvers\PhpDoc;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class ParamTagValueNode extends AbstractResolver
{
    public function resolve(Ast\PhpDoc\ParamTagValueNode $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
