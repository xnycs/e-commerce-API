<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            'HTML',
            'PHP',
            'CSS',
            'Javascript',
            'Java',
            'Python'
        ];

        foreach ($skills as $skill) {
            DB::table('skills')->insert([
                'skill' => $skill,
                'created_at' => now()
            ]);
        };
    }
}
