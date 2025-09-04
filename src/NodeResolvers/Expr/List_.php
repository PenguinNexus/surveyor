<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Expr;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class List_ extends AbstractResolver
{
    public function resolve(Node\Expr\List_ $node)
    {
        // TODO: Might need to deal with this
        return null;
    }
}
