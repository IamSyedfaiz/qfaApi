<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [['name' => 'In Progress'], ['name' => 'Meeting'], ['name' => 'Not Interested'], ['name' => 'Closed'], ['name' => 'Follow Up'], ['name' => 'Send Proposal'], ['name' => 'Won']];

        // Insert statuses into the database
        DB::table('statuses')->insert($statuses);
    }
}
