<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\Analysis\EntityType;
use Laravel\Surveyor\Analysis\Scope;
use Laravel\Surveyor\Analyzed\MethodResult;
use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use PhpParser\Node;

class ClassMethod extends AbstractResolver
{
    public function resolve(Node\Stmt\ClassMethod $node)
    {
        $this->scope->setMethodName($node->name);
        $this->scope->setEntityType(EntityType::METHOD_TYPE);

        if ($node->returnType) {
            $returnTypes = $this->from($node->returnType);

            if ($returnTypes) {
                $this->scope->addReturnType($returnTypes, $node->getStartLine());
            }
        }

        return null;
    }

    public function scope(): Scope
    {
        return $this->scope->newChildScope();
    }

    public function exitScope(): Scope
    {
        $result = new MethodResult(
            name: $this->scope->methodName(),
            parameters: $this->scope->parameters(),
            returnTypes: $this->scope->returnTypes(),
        );

        $this->scope->parent()->result()?->addMethod($result);

        return $this->scope->parent();
    }
}
