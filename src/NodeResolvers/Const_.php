<?php

namespace Laravel\StaticAnalyzer\NodeResolvers;

use PhpParser\Node;

class Const_ extends AbstractResolver
{
    public function resolve(Node\Const_ $node)
    {
        return null;
    }
}
