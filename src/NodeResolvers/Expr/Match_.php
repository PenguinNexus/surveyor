<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class Match_ extends AbstractResolver
{
    public function resolve(Node\Expr\Match_ $node)
    {
        return Type::union(
            ...array_map(
                fn ($arm) => $this->from($arm->body),
                $node->arms,
            ),
        );
    }
}
