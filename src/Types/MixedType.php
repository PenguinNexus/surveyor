<?php

namespace Laravel\Surveyor\Types;

class MixedType extends AbstractType implements Contracts\Type
{
    public function id(): string
    {
        return 'mixed';
    }
}
