<?php

namespace Laravel\Surveyor\Console;

use Illuminate\Console\Command;
use Laravel\Surveyor\Analyzer\Analyzer;
use Laravel\Surveyor\Debug\Debug;

class Analyze extends Command
{
    protected $signature = 'analyze {--path=} {--dump} {--log}';

    protected $description = '';

    public function handle(Analyzer $analyzer)
    {
        Debug::$dump = (bool) $this->option('dump');
        Debug::$log = (bool) $this->option('log');

        $path = $this->option('path');

        $analyzer->analyze(getcwd().'/'.$path)->analyzed();
        dd('done');
    }
}
