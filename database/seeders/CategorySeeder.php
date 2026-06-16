<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Beras & Grain',
                'description' => 'Beras, kacang-kacangan, dan biji-bijian berkualitas tinggi untuk kebutuhan dapur sehari-hari.',
                'image' => 'images/categories/beras-grain.jpg',
                'icon' => 'fas fa-wheat-awn',
                'sort_order' => 1,
            ],
            [
                'name' => 'Minyak & Bahan Masak',
                'description' => 'Berbagai jenis minyak goreng, santan, dan bahan masak untuk melengkapi masakan Anda.',
                'image' => 'images/categories/minyak-bahan-masak.jpg',
                'icon' => 'fas fa-droplet',
                'sort_order' => 2,
            ],
            [
                'name' => 'Telur & Susu',
                'description' => 'Telur ayam segar dan berbagai produk susu untuk nutrisi keluarga.',
                'image' => 'images/categories/telur-susu.jpg',
                'icon' => 'fas fa-egg',
                'sort_order' => 3,
            ],
            [
                'name' => 'Bumbu & Masakan',
                'description' => 'Berbagai bumbu dapur, rempah, dan bahan masakan untuk rasa yang lebih lezat.',
                'image' => 'images/categories/bumbu-masakan.jpg',
                'icon' => 'fas fa-pepper-hot',
                'sort_order' => 4,
            ],
            [
                'name' => 'Mie & Makanan Instan',
                'description' => 'Mie instan, mie kering, dan berbagai makanan instan berkualitas.',
                'image' => 'images/categories/mie-makanan-instan.jpg',
                'icon' => 'fas fa-bowl-food',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'image' => $category['image'],
                    'icon' => $category['icon'],
                    'is_active' => true,
                    'sort_order' => $category['sort_order'],
                ]
            );
        }
    }
}
