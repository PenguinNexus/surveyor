<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;
use PhpParser\NodeAbstract;

class If_ extends AbstractResolver
{
    public function resolve(Node\Stmt\If_ $node)
    {
        $this->scope->variables()->startSnapshot($node);

        // Analyze the condition for type narrowing
        $this->scope->startConditionAnalysis();
        $this->from($node->cond);
        $this->scope->endConditionAnalysis();
    }

    public function onExit(NodeAbstract $node)
    {
        $this->scope->variables()->endSnapshotAndAddToPending($node);

        $changed = $this->scope->variables()->getPendingTypes($node);

        $finalChanged = [];

        foreach ($changed as $changes) {
            foreach ($changes as $name => $changes) {
                $finalChanged[$name] ??= [];
                $finalChanged[$name] = array_merge($finalChanged[$name], $changes);
            }
        }

        foreach ($finalChanged as $name => $changes) {
            $types = array_map(fn ($change) => $change['type'], $changes);

            array_unshift($types, $this->scope->variables()->getAtLine($name, $node)['type']);

            $this->scope->variables()->addManually(
                $name,
                Type::union(...$types),
                $node->getEndLine(),
                $node->getEndTokenPos(),
                $node->getEndLine(),
                $node->getEndTokenPos()
            );
        }
    }
}
