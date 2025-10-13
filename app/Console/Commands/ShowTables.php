<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:show-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
public function handle()
{
    $tables = DB::select('SHOW TABLES');
    $tableNames = array_map(fn($table) => array_values((array)$table)[0], $tables);
    
    $this->info('Database tables:');
    foreach ($tableNames as $table) {
        $this->line("- $table");
    }
}
}
