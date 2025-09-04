<?php

namespace Laravel\StaticAnalyzer\NodeResolvers\Stmt;

use Laravel\StaticAnalyzer\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class TraitUse extends AbstractResolver
{
    public function resolve(Node\Stmt\TraitUse $node)
    {
        foreach ($node->traits as $trait) {
            $this->scope->addTrait($trait->toString());
        }

        return null;
    }
}
