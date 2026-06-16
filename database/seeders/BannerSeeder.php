<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Diskon 20% untuk Pembelian Pertama',
                'description' => 'Dapatkan potongan harga 20% untuk setiap pembelian pertama Anda. Berlaku untuk semua produk Sembako.',
                'image' => 'images/banners/diskon-pertama.jpg',
                'link' => '/register',
                'link_type' => 'url',
                'link_id' => null,
                'is_active' => true,
                'sort_order' => 1,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
            ],
            [
                'title' => 'Promo Mingguan: Belanja Rp 100.000 Gratis Ongkir',
                'description' => 'Belanja minimal Rp 100.000 dan dapatkan gratis ongkir untuk seluruh Indonesia.',
                'image' => 'images/banners/gratis-ongkir.jpg',
                'link' => '/products',
                'link_type' => 'url',
                'link_id' => null,
                'is_active' => true,
                'sort_order' => 2,
                'start_date' => now(),
                'end_date' => now()->addWeek(),
            ],
            [
                'title' => 'Flash Sale: Beras Premium Rp 65.000',
                'description' => 'Beras premium 5kg hanya Rp 65.000. Stok terbatas, buruan checkout!',
                'image' => 'images/banners/flash-sale-beras.jpg',
                'link' => '/products/beras-premium-5-kg',
                'link_type' => 'product',
                'link_id' => 1,
                'is_active' => true,
                'sort_order' => 3,
                'start_date' => now(),
                'end_date' => now()->addDays(3),
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
