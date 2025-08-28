<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Expr;

use Laravel\StaticAnalyzer\Debug\Debug;
use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Result\VariableTracker;
use PhpParser\Node;

class Variable extends AbstractResolver
{
    public function resolve(Node\Expr\Variable $node)
    {
        return $this->scope->variableTracker()->getAtLine($node->name, $node->getStartLine())['type'];
    }
}
