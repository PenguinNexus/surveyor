<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Stmt;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class Unset_ extends AbstractResolver
{
    public function resolve(Node\Stmt\Unset_ $node)
    {
        foreach ($node->vars as $var) {
            if ($var instanceof Node\Expr\Variable) {
                $this->scope->variables()->unset($var->name, $node->getStartLine());
            } elseif ($var instanceof Node\Expr\PropertyFetch) {
                $this->scope->properties()->unset($var->name->name, $node->getStartLine());
            } elseif ($var instanceof Node\Expr\ArrayDimFetch) {
                if ($var->dim === null) {
                    dd($node, $var, 'unset: array dim fetch but dim is null??');
                }

                $dim = $this->from($var->dim);

                if ($dim->value === null) {
                    // Couldn't figure out the dim, so we can't unset the array key
                    // TODO: May need to circle back on this
                    continue;
                }

                if ($var->var instanceof Node\Expr\Variable) {
                    $this->scope->variables()->unsetArrayKey(
                        $var->var->name,
                        $dim->value,
                        $node->getStartLine(),
                    );
                }

                if ($var->var instanceof Node\Expr\PropertyFetch) {
                    $this->scope->properties()->unsetArrayKey(
                        $var->var->name,
                        $dim->value,
                        $node->getStartLine(),
                    );
                }
            } else {
                dd('unset: not a variable or property fetch??', $var);
            }
        }

        return null;
    }
}
