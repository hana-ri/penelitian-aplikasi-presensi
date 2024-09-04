<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateFreshWithoutMdl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:fresh_without_mdl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all tables except those with the mdl_ prefix and run migrations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Mendapatkan semua tabel di database
        $tables = DB::select('SHOW TABLES');

        $dbName = DB::getDatabaseName();
        $keyName = 'Tables_in_' . $dbName;

        // Memisahkan tabel yang tidak memiliki prefix mdl_
        $tablesToDrop = [];
        foreach ($tables as $table) {
            $tableName = $table->$keyName;
            if (!str_starts_with($tableName, 'mdl_')) {
                $tablesToDrop[] = $tableName;
            }
        }

        // Menonaktifkan foreign key checks
        Schema::disableForeignKeyConstraints();

        // Menghapus tabel yang tidak memiliki prefix mdl_
        foreach ($tablesToDrop as $table) {
            // $this->info($table);
            Schema::drop($table);
        }

        // Mengaktifkan kembali foreign key checks
        Schema::enableForeignKeyConstraints();

        // Menjalankan migrate
        $this->call('migrate');

        $this->info('Migrate fresh selesai tanpa menghapus tabel dengan prefix mdl_');
    }
}
