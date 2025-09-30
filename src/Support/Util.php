<?php

namespace Laravel\Surveyor\Support;

class Util
{
    public static function isClassOrInterface(string $value): bool
    {
        return class_exists($value) || interface_exists($value);
    }
}
