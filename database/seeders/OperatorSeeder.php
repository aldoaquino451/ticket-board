<?php

namespace Database\Seeders;

use App\Models\Operator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OperatorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $faker = Faker::create('it_IT');

    for ($i = 0; $i < 20; $i++) {

      $name = $faker->firstName();
      $surname = $faker->lastName();
      $slug = lcfirst($name) . '-' . lcfirst($surname);
      $email = lcfirst($name) . '.' . lcfirst($surname) . '@gmail.com';

      Operator::create([
        'name' => $name,
        'surname' => $surname,
        'slug' => $slug,
        'email' => $email,
        'is_available' => $faker->boolean(),
      ]);
    }
  }
}
