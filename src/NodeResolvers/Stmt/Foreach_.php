<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Stmt;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use Laravel\StaticAnalyzer\Types\ArrayShapeType;
use Laravel\StaticAnalyzer\Types\ArrayType;
use Laravel\StaticAnalyzer\Types\Type;
use PhpParser\Node;

class Foreach_ extends AbstractResolver
{
    public function resolve(Node\Stmt\Foreach_ $node)
    {
        $iterating = $this->from($node->expr);

        if (! $iterating instanceof ArrayType) {
            dd('Foreach on non-array?', $iterating);
        }

        if ($iterating instanceof ArrayShapeType) {
            dd('iterating shape', $iterating);
        }

        if (! $node->keyVar instanceof Node\Expr\Variable) {
            dd('keyVar is not a variable??', $node->keyVar);
        }

        if (! $node->valueVar instanceof Node\Expr\Variable) {
            dd('valueVar is not a variable??', $node->valueVar);
        }

        $this->scope->stateTracker()->addVariable(
            $node->keyVar->name,
            $iterating instanceof ArrayShapeType ? $iterating->keyType : Type::mixed(),
            $node->keyVar->getStartLine(),
        );

        $this->scope->stateTracker()->addVariable(
            $node->valueVar->name,
            $iterating instanceof ArrayShapeType ? $iterating->valueType : Type::mixed(),
            $node->valueVar->getStartLine(),
        );

        return null;
    }
}
