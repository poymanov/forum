<?php

use Illuminate\Database\Seeder;
use App\Thread;

class ThreadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Thread::class, 50)->create();
    }
}
