<?php

namespace Laravel\Surveyor\NodeResolvers\Expr;

use Laravel\Surveyor\NodeResolvers\AbstractResolver;
use Laravel\Surveyor\Types\Type;
use PhpParser\Node;

class Array_ extends AbstractResolver
{
    public function resolve(Node\Expr\Array_ $node)
    {
        $items = collect($node->items);

        $isList = $items->every(fn ($item) => $item->key === null);

        if ($isList) {
            return Type::array(
                $items->map(fn ($item) => $this->from($item->value))->unique()->values()->toArray(),
            );
        }

        return Type::array(
            $items
                ->mapWithKeys(fn ($item) => [
                    $item->key->value ?? null => $this->from($item->value),
                ])
                ->toArray(),
        );
    }
}
