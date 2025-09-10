<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\Analysis\ReturnTypeAnalyzer;
use Laravel\Surveyor\Analysis\Scope;
use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class ClassMethod extends AbstractResolver
{
    public function resolve(Node\Stmt\ClassMethod $node)
    {
        $this->scope->setMethodName($node->name);

        return null;
    }

    public function scope(): Scope
    {
        return $this->scope->newChildScope();
    }

    public function exitScope(): Scope
    {
        return $this->scope->parent();
    }

    // protected function getAllReturnTypes(Node\Stmt\ClassMethod $node)
    // {
    //     $analyzer = new ReturnTypeAnalyzer(
    //         $this->resolver,
    //         $this->docBlockParser,
    //         $this->reflector,
    //         $this->scope,
    //     );

    //     return $analyzer->analyze($node, $this->scope);
    // }
}
