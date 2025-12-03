<?php

namespace Laravel\Surveyor\Console;

use Illuminate\Console\Command;
use Laravel\Surveyor\Analyzer\AnalyzedCache;
use Laravel\Surveyor\Analyzer\Analyzer;
use Laravel\Surveyor\Debug\Debug;

class Analyze extends Command
{
    protected $signature = 'analyze {--path=} {--dump} {--cache} {--cache-dir=} {--v} {--vv} {--vvv}';

    protected $description = '';

    public function handle(Analyzer $analyzer)
    {
        Debug::$dump = (bool) $this->option('dump');
        Debug::$logLevel = match (true) {
            $this->option('v') => 1,
            $this->option('vv') => 2,
            $this->option('vvv') => 3,
            default => 0,
        };

        if ($this->option('cache')) {
            $cacheDir = $this->option('cache-dir') ?? storage_path('surveyor-cache');
            AnalyzedCache::setCacheDirectory($cacheDir);
            AnalyzedCache::enable();
            $this->info("Disk cache enabled: {$cacheDir}");
        }

        $path = $this->option('path');

        $result = $analyzer->analyze(getcwd().'/'.$path);

        dd([
            // 'scope' => $result->analyzed(),
            'result' => $result->result(),
            'counts' => Debug::getCounts(),
            'timings' => Debug::getTimings(),
            'tracked' => Debug::getTracked(),
        ]);
    }
}
