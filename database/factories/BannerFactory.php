<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Diskon Besar-besaran',
            'Promo Mingguan',
            'Gratis Ongkir',
            'Flash Sale',
            'Belanja Hemat',
        ];

        $title = fake()->randomElement($titles) . ' ' . fake()->numberBetween(1, 50) . '%';

        return [
            'title' => $title,
            'description' => fake()->paragraph(),
            'image' => fake()->imageUrl(1200, 400, 'business'),
            'link' => fake()->url(),
            'link_type' => 'url',
            'link_id' => null,
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 10),
            'start_date' => now(),
            'end_date' => now()->addMonth(),
        ];
    }

    /**
     * Indicate that the banner is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the banner has expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => now()->subDay(),
        ]);
    }

    /**
     * Set the banner link to a product.
     */
    public function forProduct(int $productId): static
    {
        return $this->state(fn (array $attributes) => [
            'link_type' => 'product',
            'link_id' => $productId,
            'link' => null,
        ]);
    }

    /**
     * Set the banner link to a category.
     */
    public function forCategory(int $categoryId): static
    {
        return $this->state(fn (array $attributes) => [
            'link_type' => 'category',
            'link_id' => $categoryId,
            'link' => null,
        ]);
    }
}
