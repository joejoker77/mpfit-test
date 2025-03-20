<?php

namespace Database\Factories\Shop;

use Bezhanov\Faker\Provider\Commerce;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{

    public function definition(): array
    {

        $faker = \Faker\Factory::create();
        $faker->addProvider(new Commerce($faker));

        $name = $faker->productName;
        $slug = Str::slug($name, '-');

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => $faker->paragraph(15, true),
            'cost' => $this->faker->randomFloat(2, 0, 1000) ,
            'category_id' => rand(1, 3),
        ];
    }
}
