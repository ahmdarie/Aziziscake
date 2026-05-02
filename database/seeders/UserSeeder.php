<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Roti',
            'email'    => 'admin@bakery.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '081234567890',
            'address'  => 'Jl. Roti Manis No. 1, Jakarta',
        ]);

        // Customers
        $customers = [
            ['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'phone' => '081111111111', 'address' => 'Jl. Anggrek No. 5, Bandung'],
            ['name' => 'Siti Rahayu', 'email' => 'siti@example.com', 'phone' => '082222222222', 'address' => 'Jl. Melati No. 10, Surabaya'],
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad@example.com', 'phone' => '083333333333', 'address' => 'Jl. Kenanga No. 3, Yogyakarta'],
            ['name' => 'Dewi Kartika', 'email' => 'dewi@example.com', 'phone' => '084444444444', 'address' => 'Jl. Dahlia No. 8, Semarang'],
            ['name' => 'Riko Pratama', 'email' => 'riko@example.com', 'phone' => '085555555555', 'address' => 'Jl. Cempaka No. 15, Medan'],
        ];

        foreach ($customers as $customer) {
            User::create(array_merge($customer, [
                'password' => Hash::make('password'),
                'role'     => 'customer',
            ]));
        }
    }
}