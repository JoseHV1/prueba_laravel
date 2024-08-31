<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'description' => 'Region 1',
            ],
            [
                'description' => 'Region 2',
            ],
            [
                'description' => 'Region 3',
            ],
            [
                'description' => 'Region 4',
            ],
        ];

        foreach ($data as $item) {
            Region::create($item);
        }
    }
}
