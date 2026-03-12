<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Region;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Regions
        $regions = [
            ['name' => 'Kantor Pusat Jakarta', 'type' => 'head_office', 'location' => 'Jakarta'],
            ['name' => 'Kantor Cabang Surabaya', 'type' => 'branch_office', 'location' => 'Surabaya'],
            ['name' => 'Tambang Morowali', 'type' => 'mine', 'location' => 'Morowali'],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }

        // 2. Buat Users
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@nikel.co',
                'password' => Hash::make('admin123'),
                'full_name' => 'Admin Utama',
                'nip' => 'ADM001',
                'position' => 'Administrator',
                'region_id' => 1,
                'role' => 'admin',
                'is_active' => true
            ],
            [
                'username' => 'supervisor',
                'email' => 'supervisor@nikel.co',
                'password' => Hash::make('supervisor123'),
                'full_name' => 'Budi Santoso',
                'nip' => 'SPV001',
                'position' => 'Kepala Pool',
                'region_id' => 1,
                'role' => 'approver_level_1',
                'is_active' => true
            ],
            [
                'username' => 'manager',
                'email' => 'manager@nikel.co',
                'password' => Hash::make('manager123'),
                'full_name' => 'Siti Rahayu',
                'nip' => 'MGR001',
                'position' => 'Manajer Operasional',
                'region_id' => 1,
                'role' => 'approver_level_2',
                'is_active' => true
            ],
            [
                'username' => 'employee',
                'email' => 'employee@nikel.co',
                'password' => Hash::make('employee123'),
                'full_name' => 'Ahmad Hidayat',
                'nip' => 'EMP001',
                'position' => 'Staff Operasional',
                'region_id' => 2,
                'role' => 'employee',
                'is_active' => true
            ],
            [
                'username' => 'driver',
                'email' => 'driver@nikel.co',
                'password' => Hash::make('driver123'),
                'full_name' => 'Joko Susilo',
                'nip' => 'DRV001',
                'position' => 'Driver',
                'region_id' => 1,
                'role' => 'employee',
                'is_active' => true
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // 3. Buat Vehicles
        $vehicles = [
            [
                'license_plate' => 'B 1234 XYZ',
                'brand' => 'Toyota',
                'model' => 'Hiace',
                'type' => 'passenger',
                'ownership' => 'company',
                'region_id' => 1,
                'fuel_consumption' => 8.5,
                'status' => 'available'
            ],
            [
                'license_plate' => 'B 5678 ABC',
                'brand' => 'Mitsubishi',
                'model' => 'Fuso',
                'type' => 'cargo',
                'ownership' => 'company',
                'region_id' => 1,
                'fuel_consumption' => 4.2,
                'status' => 'available'
            ],
            [
                'license_plate' => 'B 9012 DEF',
                'brand' => 'Isuzu',
                'model' => 'Elf',
                'type' => 'passenger',
                'ownership' => 'rental',
                'rental_company' => 'PT Sewa Mobil',
                'rental_expiry' => now()->addMonths(6),
                'region_id' => 2,
                'fuel_consumption' => 9.0,
                'status' => 'available'
            ]
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }

        $this->command->info('Database seeded successfully!');
    }
}