<?php

namespace Laravel\Surveyor\Analyzer;

use Laravel\Surveyor\Analysis\Scope;

class AnalyzedCache
{
    // TODO: Probably implemenent recently used strategy to keep a limit of cache entries
    protected static array $cached = [];

    protected static array $inProgress = [];

    public static function add(string $path, Scope $analyzed): void
    {
        static::$cached[$path] = $analyzed;
        unset(static::$inProgress[$path]);
    }

    public static function get(string $path): ?Scope
    {
        return static::$cached[$path] ?? null;
    }

    public static function inProgress(string $path): void
    {
        self::$inProgress[$path] = true;
    }

    public static function isInProgress(string $path): bool
    {
        return self::$inProgress[$path] ?? false;
    }
}
