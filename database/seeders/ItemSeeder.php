<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items  = [
            // Makanan
            [
                'name' => 'Nasi Goreng Spesial',
                'price' => 25000,
                'description' => 'Nasi goreng dengan tambahan ayam, telur, dan sayuran.',
                'category' => 'Makanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mie Goreng Ayam',
                'price' => 20000,
                'description' => 'Mie goreng lezat dengan potongan ayam.',
                'category' => 'Makanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sate Ayam (10 tusuk)',
                'price' => 30000,
                'description' => 'Sate ayam dengan bumbu kacang khas Indonesia.',
                'category' => 'Makanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ayam Geprek Sambal Bawang',
                'price' => 22000,
                'description' => 'Ayam geprek dengan sambal bawang pedas.',
                'category' => 'Makanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rendang Sapi',
                'price' => 35000,
                'description' => 'Rendang sapi dengan bumbu khas Padang.',
                'category' => 'Makanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bakso Urat',
                'price' => 18000,
                'description' => 'Bakso urat disajikan dengan kuah kaldu sapi.',
                'category' => 'Makanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pizza Margherita',
                'price' => 50000,
                'description' => 'Pizza dengan topping keju mozzarella dan saus tomat.',
                'category' => 'Makanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Burger Keju',
                'price' => 30000,
                'description' => 'Burger dengan patty sapi dan keju leleh.',
                'category' => 'Makanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Minuman
            [
                'name' => 'Es Teh Manis',
                'price' => 5000,
                'description' => 'Minuman teh manis dengan es segar.',
                'category' => 'Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jus Alpukat',
                'price' => 15000,
                'description' => 'Jus alpukat segar dengan susu kental manis.',
                'category' => 'Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kopi Latte',
                'price' => 25000,
                'description' => 'Kopi latte dengan perpaduan rasa manis dan pahit.',
                'category' => 'Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Es Jeruk',
                'price' => 10000,
                'description' => 'Minuman segar dengan perasan jeruk asli.',
                'category' => 'Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Susu Coklat',
                'price' => 12000,
                'description' => 'Susu coklat hangat atau dingin sesuai selera.',
                'category' => 'Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Matcha Latte',
                'price' => 20000,
                'description' => 'Latte dengan rasa matcha yang creamy.',
                'category' => 'Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Milkshake Strawberry',
                'price' => 18000,
                'description' => 'Milkshake segar dengan rasa stroberi.',
                'category' => 'Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Smoothie Mangga',
                'price' => 20000,
                'description' => 'Smoothie mangga segar dengan tekstur lembut.',
                'category' => 'Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
