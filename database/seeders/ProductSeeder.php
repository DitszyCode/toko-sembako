<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $berasGrain = Category::where('slug', 'beras-grain')->first()->id;
        $minyakBahanMasak = Category::where('slug', 'minyak-bahan-masak')->first()->id;
        $telurSusu = Category::where('slug', 'telur-susu')->first()->id;
        $bumbuMasakan = Category::where('slug', 'bumbu-masakan')->first()->id;
        $mieMakananInstan = Category::where('slug', 'mie-makanan-instan')->first()->id;

        $products = [
            // Beras & Grain (22 products)
            [
                'category_id' => $berasGrain,
                'name' => 'Beras Premium 5 Kg',
                'description' => 'Beras premium berkualitas tinggi, pulen dan wangi. Cocok untuk konsumsi sehari-hari.',
                'image' => 'images/products/beras-premium-5kg.jpg',
                'price' => 75000,
                'unit' => 'pack',
                'stock' => 100,
                'min_stock' => 20,
                'is_featured' => true,
            ],
            [
                'category_id' => $berasGrain,
                'name' => 'Beras Medium 5 Kg',
                'description' => 'Beras medium pilihan untuk kebutuhan dapur sehari-hari.',
                'image' => 'images/products/beras-medium-5kg.jpg',
                'price' => 65000,
                'unit' => 'pack',
                'stock' => 80,
                'min_stock' => 15,
                'is_featured' => false,
            ],
            [
                'category_id' => $berasGrain,
                'name' => 'Kacang Tanah 500g',
                'description' => 'Kacang tanah pilihan, segar dan berkualitas.',
                'image' => 'images/products/kacang-tanah.jpg',
                'price' => 25000,
                'unit' => 'pack',
                'stock' => 50,
                'min_stock' => 10,
                'is_featured' => false,
            ],
            [
                'category_id' => $berasGrain,
                'name' => 'Kacang Hijau 500g',
                'description' => 'Kacang hijau pilihan untuk dibuat bubur atau minuman.',
                'image' => 'images/products/kacang-hijau.jpg',
                'price' => 22000,
                'unit' => 'pack',
                'stock' => 45,
                'min_stock' => 10,
                'is_featured' => false,
            ],
            [
                'category_id' => $berasGrain,
                'name' => 'Jagung Pipilan 500g',
                'description' => 'Jagung pipilan kering untuk arem-arem atau nasi jagung.',
                'image' => 'images/products/jagung-pipilan.jpg',
                'price' => 18000,
                'unit' => 'pack',
                'stock' => 40,
                'min_stock' => 10,
                'is_featured' => false,
            ],

            // Minyak & Bahan Masak
            [
                'category_id' => $minyakBahanMasak,
                'name' => 'Minyak Goreng Tropical 2L',
                'description' => 'Minyak goreng tropical berkualitas tinggi, tahan panas.',
                'image' => 'images/products/minyak-goreng-tropical.jpg',
                'price' => 38000,
                'unit' => 'botol',
                'stock' => 120,
                'min_stock' => 25,
                'is_featured' => true,
            ],
            [
                'category_id' => $minyakBahanMasak,
                'name' => 'Minyak Kelapa 500ml',
                'description' => 'Minyak kelapa murni untuk memasak dan kue.',
                'image' => 'images/products/minyak-kelapa.jpg',
                'price' => 28000,
                'unit' => 'botol',
                'stock' => 60,
                'min_stock' => 15,
                'is_featured' => false,
            ],
            [
                'category_id' => $minyakBahanMasak,
                'name' => 'Santan Kara 200ml',
                'description' => 'Santan kelapa siap pakai untuk masakan rendang, gulai, dan lainnya.',
                'image' => 'images/products/santan-kara.jpg',
                'price' => 8000,
                'unit' => 'pcs',
                'stock' => 200,
                'min_stock' => 50,
                'is_featured' => true,
            ],
            [
                'category_id' => $minyakBahanMasak,
                'name' => 'Margarin 250g',
                'description' => 'Margarin untuk olesan roti dan memasak.',
                'image' => 'images/products/margarin.jpg',
                'price' => 15000,
                'unit' => 'pcs',
                'stock' => 80,
                'min_stock' => 20,
                'is_featured' => false,
            ],

            // Telur & Susu
            [
                'category_id' => $telurSusu,
                'name' => 'Telur Ayam Negeri 1kg',
                'description' => 'Telur ayam negeri segar, kaya protein.',
                'image' => 'images/products/telur-ayam-negeri.jpg',
                'price' => 28000,
                'unit' => 'kg',
                'stock' => 150,
                'min_stock' => 30,
                'is_featured' => true,
            ],
            [
                'category_id' => $telurSusu,
                'name' => 'Telur Puyuh 100g',
                'description' => 'Telur puyuh segar untuk campuran sayur atau gorengan.',
                'image' => 'images/products/telur-puyuh.jpg',
                'price' => 12000,
                'unit' => 'pack',
                'stock' => 60,
                'min_stock' => 15,
                'is_featured' => false,
            ],
            [
                'category_id' => $telurSusu,
                'name' => 'Susu Kental Manis 370g',
                'description' => 'Susu kental manis untuk minuman dan kue.',
                'image' => 'images/products/skm.jpg',
                'price' => 15000,
                'unit' => 'pcs',
                'stock' => 100,
                'min_stock' => 25,
                'is_featured' => true,
            ],
            [
                'category_id' => $telurSusu,
                'name' => 'Susu Bubuk Dancow 400g',
                'description' => 'Susu bubuk full cream untuk keluarga.',
                'image' => 'images/products/susu-dancow.jpg',
                'price' => 45000,
                'unit' => 'pack',
                'stock' => 70,
                'min_stock' => 15,
                'is_featured' => false,
            ],

            // Bumbu & Masakan
            [
                'category_id' => $bumbuMasakan,
                'name' => 'Bawang Merah 500g',
                'description' => 'Bawang merah segar pilihan untuk bumbu masakan.',
                'image' => 'images/products/bawang-merah.jpg',
                'price' => 20000,
                'unit' => 'pack',
                'stock' => 80,
                'min_stock' => 20,
                'is_featured' => true,
            ],
            [
                'category_id' => $bumbuMasakan,
                'name' => 'Bawang Putih 250g',
                'description' => 'Bawang putih segar untuk bumbu masakan.',
                'image' => 'images/products/bawang-putih.jpg',
                'price' => 15000,
                'unit' => 'pack',
                'stock' => 70,
                'min_stock' => 15,
                'is_featured' => false,
            ],
            [
                'category_id' => $bumbuMasakan,
                'name' => 'Gula Pasir 1kg',
                'description' => 'Gula pasir putih berkualitas untuk minuman dan kue.',
                'image' => 'images/products/gula-pasir.jpg',
                'price' => 15000,
                'unit' => 'kg',
                'stock' => 100,
                'min_stock' => 25,
                'is_featured' => true,
            ],
            [
                'category_id' => $bumbuMasakan,
                'name' => 'Garam 500g',
                'description' => 'Garam dapur untuk masakan sehari-hari.',
                'image' => 'images/products/garam.jpg',
                'price' => 5000,
                'unit' => 'pack',
                'stock' => 150,
                'min_stock' => 30,
                'is_featured' => false,
            ],
            [
                'category_id' => $bumbuMasakan,
                'name' => 'Saus Teriyaki 135ml',
                'description' => 'Saus teriyaki untuk masakan japchae dan stir-fry.',
                'image' => 'images/products/saus-teriyaki.jpg',
                'price' => 12000,
                'unit' => 'pcs',
                'stock' => 50,
                'min_stock' => 10,
                'is_featured' => false,
            ],

            // Mie & Makanan Instan
            [
                'category_id' => $mieMakananInstan,
                'name' => 'Indomie Goreng 80g',
                'description' => 'Indomie goreng rasa original, mie instan favorit Indonesia.',
                'image' => 'images/products/indomie-goreng.jpg',
                'price' => 3500,
                'unit' => 'pcs',
                'stock' => 500,
                'min_stock' => 100,
                'is_featured' => true,
            ],
            [
                'category_id' => $mieMakananInstan,
                'name' => 'Indomie Kuah 80g',
                'description' => 'Indomie kuah rasa chicken, mie instan favorit Indonesia.',
                'image' => 'images/products/indomie-kuah.jpg',
                'price' => 3500,
                'unit' => 'pcs',
                'stock' => 500,
                'min_stock' => 100,
                'is_featured' => true,
            ],
            [
                'category_id' => $mieMakananInstan,
                'name' => 'Mie Sedap Goreng 85g',
                'description' => 'Mie sedap goreng dengan bumbu khas.',
                'image' => 'images/products/mie-sedap-goreng.jpg',
                'price' => 3300,
                'unit' => 'pcs',
                'stock' => 300,
                'min_stock' => 50,
                'is_featured' => false,
            ],
            [
                'category_id' => $mieMakananInstan,
                'name' => 'Sari Roti Bread 450g',
                'description' => 'Roti tawar untuk sarapan keluarga.',
                'image' => 'images/products/sari-roti.jpg',
                'price' => 18000,
                'unit' => 'pcs',
                'stock' => 60,
                'min_stock' => 15,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'image' => $product['image'],
                'price' => $product['price'],
                'unit' => $product['unit'],
                'stock' => $product['stock'],
                'min_stock' => $product['min_stock'],
                'is_active' => true,
                'is_featured' => $product['is_featured'],
                'barcode' => '890' . fake()->numerify('##########'),
            ]);
        }
    }
}
