<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Crear roles
        $adminRole = Role::create(['name' => 'admin']);
        $clientRole = Role::create(['name' => 'client']);
    
        // Crear un usuario administrador
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);
    
        // Crear un usuario cliente
        $client = User::create([
            'name' => 'Cliente',
            'email' => 'cliente@example.com',
            'password' => bcrypt('password'),
        ]);
        $client->assignRole($clientRole);
    }
}
