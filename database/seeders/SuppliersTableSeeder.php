<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Electrónicos S.A.',
                'contact_name' => 'Juan Pérez',
                'email' => 'juan@electronicos.com',
                'phone' => '1234567890',
                'address' => 'Calle Electrónica 123',
                'city' => 'Ciudad Electrónica',
                'state' => 'Estado Electrónico',
                'postal_code' => '12345',
                'notes' => 'Proveedor de productos electrónicos',
            ],
            [
                'name' => 'Muebles y Más',
                'contact_name' => 'María Gómez',
                'email' => 'maria@mueblesymas.com',
                'phone' => '0987654321',
                'address' => 'Calle Mueble 456',
                'city' => 'Ciudad Mueble',
                'state' => 'Estado Mueble',
                'postal_code' => '54321',
                'notes' => 'Proveedor de muebles',
            ],
            [
                'name' => 'Alimentos Frescos',
                'contact_name' => 'Pedro López',
                'email' => 'pedro@alimentosfrescos.com',
                'phone' => '1122334455',
                'address' => 'Calle Alimento 789',
                'city' => 'Ciudad Alimento',
                'state' => 'Estado Alimento',
                'postal_code' => '67890',
                'notes' => 'Proveedor de alimentos frescos',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
