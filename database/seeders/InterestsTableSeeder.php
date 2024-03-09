<?php

namespace Database\Seeders;
use App\Models\Interest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interests = [
            'League of Legends',
            'Valorant',
            'Candy Crush',
            'Mobile Legends',
            'Call of Duty',
        ];
        foreach ($interests as $name) {
            Interest::create(['name' => $name]);
        }
    }


}
