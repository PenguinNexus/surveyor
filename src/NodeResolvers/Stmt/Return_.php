<?php

namespace Laravel\Surveyor\NodeResolvers\Stmt;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class Return_ extends AbstractResolver
{
    public function resolve(Node\Stmt\Return_ $node)
    {
        $this->scope->state()->markSnapShotAsTerminated($node);

        $type = ($node->expr) ? $this->from($node->expr) : Type::void();

        $this->scope->addReturnType(Type::collapse($type ?? Type::mixed()), $node->getStartLine());

        return null;
    }
}
