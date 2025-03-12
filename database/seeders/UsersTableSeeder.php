<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Crear usuario cliente
        $customer = User::create([
            'name' => 'Cliente',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Crear perfil de cliente
        Customer::create([
            'user_id' => $customer->id,
            'phone' => '1234567890',
            'address' => 'Calle Principal 123',
            'city' => 'Ciudad',
            'state' => 'Estado',
            'postal_code' => '12345',
        ]);
    }
}
