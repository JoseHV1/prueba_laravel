<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Commune;

class CommuneSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id_reg' => '1',
                'description' => 'Municipio 1',
            ],
            [
                'id_reg' => '1',
                'description' => 'Municipio 2',
            ],
            [
                'id_reg' => '1',
                'description' => 'Municipio 3',
            ],
            [
                'id_reg' => '1',
                'description' => 'Municipio 4',
            ],
            [
                'id_reg' => '2',
                'description' => 'Municipio 5',
            ],
            [
                'id_reg' => '2',
                'description' => 'Municipio 6',
            ],
            [
                'id_reg' => '2',
                'description' => 'Municipio 7',
            ],
            [
                'id_reg' => '2',
                'description' => 'Municipio 8',
            ],
            [
                'id_reg' => '3',
                'description' => 'Municipio 9',
            ],
            [
                'id_reg' => '3',
                'description' => 'Municipio 10',
            ],
            [
                'id_reg' => '3',
                'description' => 'Municipio 11',
            ],
            [
                'id_reg' => '4',
                'description' => 'Municipio 12',
            ],
        ];

        foreach ($data as $item) {
            Commune::create($item);
        }
    }
}
