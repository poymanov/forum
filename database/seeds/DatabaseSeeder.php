<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * @var array
     */
    private $tables = [
        'users',
        'threads',
        'replies'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ThreadsSeeder::class);
        $this->call(RepliesSeeder::class);
    }

    /**
     *
     */
    private function clearDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
