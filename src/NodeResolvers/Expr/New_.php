<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Expr;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Types\Type;
use PhpParser\Node;

class New_ extends AbstractResolver
{
    public function resolve(Node\Expr\New_ $node)
    {
        // TODO: Nab arguments?
        return Type::string($this->scope->getUse($node->class));
    }
}
