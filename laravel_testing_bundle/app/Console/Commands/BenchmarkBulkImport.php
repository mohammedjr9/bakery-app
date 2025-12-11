<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Beneficiary;

class BenchmarkBulkImport extends Command
{
    protected $signature = 'benchmark:bulk-import {count=5000}';
    protected $description = 'Insert many beneficiaries and report elapsed time/memory';

    public function handle()
    {
        $count = (int) $this->argument('count');
        $this->info("Starting bulk insert of {$count} beneficiaries...");

        $start = microtime(true);
        $chunks = 500;

        for ($i = 0; $i < $count; $i += $chunks) {
            $batch = [];
            for ($j = 0; $j < $chunks && ($i + $j) < $count; $j++) {
                $batch[] = [
                    'name' => 'Perf User '.($i + $j),
                    'phone' => '059'.str_pad((string)rand(1000000, 9999999), 7, '0', STR_PAD_LEFT),
                    'service_type' => ['Food Aid','Cash Aid','Medical Aid'][array_rand([0,1,2])],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            \App\Models\Beneficiary::insert($batch);
        }

        $elapsed = microtime(true) - $start;
        $this->info("Done. Elapsed: ".number_format($elapsed, 2)."s");
        $this->info("Peak Memory: ".number_format(memory_get_peak_usage(true) / (1024*1024), 2)." MB");

        return self::SUCCESS;
    }
}