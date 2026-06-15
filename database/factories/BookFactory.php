<?php

namespace Database\Factories;

use App\Enums\IsbnStatus;
use App\Enums\ProductionStage;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        $title = rtrim(fake()->unique()->sentence(4), '.');
        $status = fake()->randomElement(IsbnStatus::cases());

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 999999),
            'author' => fake()->name(),
            'category_id' => Category::factory(),
            'isbn_status' => $status,
            'isbn_number' => $status === IsbnStatus::Terbit ? fake()->isbn13() : null,
            'production_stage' => fake()->randomElement(ProductionStage::cases()),
            'stage_updated_at' => fake()->dateTimeBetween('-2 months', 'now'),
            'cover' => null,
            'synopsis' => fake()->paragraphs(2, true),
            'year' => fake()->numberBetween(2015, (int) date('Y')),
            'pages' => fake()->numberBetween(80, 500),
            'price' => fake()->numberBetween(35, 250) * 1000,
            'marketplace_url' => fake()->boolean(60) ? fake()->url() : null,
            'is_featured' => fake()->boolean(30),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'isbn_status' => IsbnStatus::Terbit,
            'isbn_number' => fake()->isbn13(),
        ]);
    }

    public function withMarketplace(?string $url = null): static
    {
        return $this->state(fn () => ['marketplace_url' => $url ?? fake()->url()]);
    }

    public function withoutMarketplace(): static
    {
        return $this->state(fn () => ['marketplace_url' => null]);
    }
}
