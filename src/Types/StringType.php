<?php

namespace Laravel\StaticAnalyzer\Types;

class StringType extends AbstractType implements Contracts\Type
{
    public function __construct(public readonly ?string $value = null)
    {
        //
        if ($value === 'static') {
            dd(debug_backtrace(limit: 6));
        }
    }

    public function id(): string
    {
        return $this->value === null ? 'null' : $this->value;
    }
}
