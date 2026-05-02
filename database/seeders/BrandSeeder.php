<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name'        => 'Golden Crust',
                'description' => 'Roti artisan premium dengan bahan pilihan terbaik, menggunakan resep turun-temurun dari Eropa.',
            ],
            [
                'name'        => 'Sweet Heaven',
                'description' => 'Spesialis kue-kue manis dan pastry dengan cita rasa tinggi untuk berbagai kesempatan.',
            ],
            [
                'name'        => 'Whole Grain Co.',
                'description' => 'Pilihan sehat dengan roti biji-bijian utuh, bebas pengawet, dan kaya serat.',
            ],
            [
                'name'        => 'Croissant & Co.',
                'description' => 'Khusus pastry Prancis autentik, croissant lapis-lapis sempurna, dan pain au chocolat.',
            ],
            [
                'name'        => 'Local Bakehouse',
                'description' => 'Roti lokal Indonesia dengan cita rasa nusantara yang khas dan harga terjangkau.',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}