<?php

namespace Laravel\StaticAnalyzer\Console;

use Illuminate\Console\Command;
use Laravel\StaticAnalyzer\Analyzer\Analyzer;
use Laravel\StaticAnalyzer\Debug\Debug;

class Analyze extends Command
{
    protected $signature = 'analyze {--path=} {--dump} {--log}';

    protected $description = '';

    public function handle(Analyzer $analyzer)
    {
        Debug::$dump = (bool) $this->option('dump');
        Debug::$log = (bool) $this->option('log');

        if ($this->option('verbose')) {
            Debug::$currentlyInterested = true;
        }

        $path = $this->option('path');

        $analyzer->analyze(getcwd().'/'.$path)->analyzed();
        dd('done');
    }
}
