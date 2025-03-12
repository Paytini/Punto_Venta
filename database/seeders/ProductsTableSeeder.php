<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();

        $products = [
            // Productos de Electrónicos S.A.
            [
                'supplier_id' => 1,
                'name' => 'Smartphone X',
                'sku' => 'SPHX001',
                'description' => 'Smartphone de última generación con cámara de alta resolución',
                'price' => 599.99,
                'cost' => 399.99,
                'stock' => 20,
                'image' => null,
                'active' => true,
            ],
            [
                'supplier_id' => 1,
                'name' => 'Laptop Pro',
                'sku' => 'LPRO001',
                'description' => 'Laptop profesional con procesador de alta velocidad',
                'price' => 1299.99,
                'cost' => 899.99,
                'stock' => 10,
                'image' => null,
                'active' => true,
            ],
            [
                'supplier_id' => 1,
                'name' => 'Tablet Mini',
                'sku' => 'TMIN001',
                'description' => 'Tablet compacta con pantalla de alta resolución',
                'price' => 399.99,
                'cost' => 249.99,
                'stock' => 15,
                'image' => null,
                'active' => true,
            ],
            // Productos de Muebles y Más
            [
                'supplier_id' => 2,
                'name' => 'Sofá Moderno',
                'sku' => 'SMOD001',
                'description' => 'Sofá moderno de 3 plazas con tapizado de alta calidad',
                'price' => 799.99,
                'cost' => 499.99,
                'stock' => 5,
                'image' => null,
                'active' => true,
            ],
            [
                'supplier_id' => 2,
                'name' => 'Mesa de Comedor',
                'sku' => 'MCOM001',
                'description' => 'Mesa de comedor para 6 personas con acabado de madera',
                'price' => 499.99,
                'cost' => 299.99,
                'stock' => 8,
                'image' => null,
                'active' => true,
            ],
            // Productos de Alimentos Frescos
            [
                'supplier_id' => 3,
                'name' => 'Frutas Variadas',
                'sku' => 'FVAR001',
                'description' => 'Paquete de frutas variadas de temporada',
                'price' => 29.99,
                'cost' => 19.99,
                'stock' => 30,
                'image' => null,
                'active' => true,
            ],
            [
                'supplier_id' => 3,
                'name' => 'Verduras Orgánicas',
                'sku' => 'VORG001',
                'description' => 'Paquete de verduras orgánicas cultivadas localmente',
                'price' => 24.99,
                'cost' => 14.99,
                'stock' => 25,
                'image' => null,
                'active' => true,
            ],
            // Producto con stock bajo para probar notificaciones
            [
                'supplier_id' => 1,
                'name' => 'Auriculares Inalámbricos',
                'sku' => 'AURI001',
                'description' => 'Auriculares inalámbricos con cancelación de ruido',
                'price' => 149.99,
                'cost' => 89.99,
                'stock' => 3,
                'image' => null,
                'active' => true,
            ],
            // Producto sin stock para probar notificaciones
            [
                'supplier_id' => 2,
                'name' => 'Silla de Oficina',
                'sku' => 'SILL001',
                'description' => 'Silla de oficina ergonómica con soporte lumbar',
                'price' => 199.99,
                'cost' => 129.99,
                'stock' => 0,
                'image' => null,
                'active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
