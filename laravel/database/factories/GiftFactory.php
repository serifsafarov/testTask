<?php

namespace Database\Factories;

use App\Models\Gift;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GiftFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gift::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'created_at' => now(),
            'updated_at' => now(),
            'title' => 'Товар ' . rand(1, 9999999999),
            'sku' => strtoupper(Str::random(8)),
            'count' => 1000
        ];
    }
}
