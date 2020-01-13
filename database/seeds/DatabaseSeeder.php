<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'cache',
            'failed_jobs',
            'jobs',
            'sessions',
            config('activitylog.table_name'),
        ]);

        $this->call(AuthTableSeeder::class);

        Model::reguard();
    }
}
