<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BenchmarkBulkImport extends Command
{
    protected $signature = 'benchmark:bulk-import {count}';
    protected $description = 'Simulate a bulk import benchmark test';

    public function handle()
    {
        $count = $this->argument('count');
        $this->info("Benchmarking bulk import for {$count} records...");

        $start = microtime(true);
        sleep(2); // عملية وهمية
        $time = microtime(true) - $start;

        $this->info("Done in {$time} seconds!");
    }
}
