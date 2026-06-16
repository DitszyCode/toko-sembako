<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $units = ['kg', 'liter', 'pcs', 'pack', 'gram', 'botol', 'kaleng'];

        return [
            'category_id' => Category::factory(),
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'image' => fake()->imageUrl(800, 800, 'food'),
            'price' => fake()->randomFloat(2, 5000, 500000),
            'unit' => fake()->randomElement($units),
            'stock' => fake()->randomFloat(2, 0, 1000),
            'min_stock' => fake()->numberBetween(5, 50),
            'is_active' => true,
            'is_featured' => fake()->boolean(20),
            'barcode' => fake()->ean13(),
        ];
    }

    /**
     * Indicate that the product is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }

    /**
     * Indicate that the product is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the product is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Set specific unit for the product.
     */
    public function withUnit(string $unit): static
    {
        return $this->state(fn (array $attributes) => [
            'unit' => $unit,
        ]);
    }
}
