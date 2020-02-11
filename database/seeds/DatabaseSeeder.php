<?php

use StartBox\Schema\Seeds\Api;
use Illuminate\Database\Seeder;
use StartBox\Schema\Seeds\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Api::class);
        $this->call(Admin::class);
    }
}
