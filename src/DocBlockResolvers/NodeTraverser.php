<?php

namespace Laravel\Surveyor\DocBlockResolvers\NodeTraverser;

use Laravel\Surveyor\DocBlockResolvers\AbstractResolver;
use PHPStan\PhpDocParser\Ast;

class NodeTraverser extends AbstractResolver
{
    public function resolve(Ast\NodeTraverser $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
