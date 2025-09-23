<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class ShellExec extends AbstractResolver
{
    public function resolve(Node\Expr\ShellExec $node)
    {
        return Type::mixed();
    }
}
