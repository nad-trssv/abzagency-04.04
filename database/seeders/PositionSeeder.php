<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['name' => 'Lawyer'],
            ['name' => 'Content manager'],
            ['name' => 'Security'],
            ['name' => 'Designer'],
        ];

        Position::insert($positions);
    }
}
