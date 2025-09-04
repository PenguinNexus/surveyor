<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Stmt;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class ClassConst extends AbstractResolver
{
    public function resolve(Node\Stmt\ClassConst $node)
    {
        $this->scope->addConstant($node->consts[0]->name, $this->from($node->consts[0]->value));

        return null;
    }
}
