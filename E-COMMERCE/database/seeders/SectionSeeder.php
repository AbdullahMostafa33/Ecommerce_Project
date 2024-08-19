<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionSeeder extends Seeder
{
    public function run()
    {
        $sections = [
            ['name' => 'Men\'s Shoes'],
            ['name' => 'Women\'s Shoes'],
            ['name' => 'Kid\'s Shoes'],
            ['name' => 'Sports'],
            ['name' => 'Accessories']
        ];

        DB::table('sections')->insert($sections);
    }
}
