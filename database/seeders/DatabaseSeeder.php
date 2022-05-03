<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConstantsTableSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(PageSeeder::class);
    }
}
