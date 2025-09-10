<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Const_ extends AbstractResolver
{
    public function resolve(Node\Stmt\Const_ $node)
    {
        dd($node, $node::class.' not implemented yet');
    }
}
