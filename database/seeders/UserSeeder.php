<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;



class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $faker = Faker::create('it_IT');

    User::create([
      'name' => 'admin',
      'surname' => 'admin',
      'username' => 'admin',
      'email' => 'admin@admin.com',
      'password' => '123123123',
    ]);

    for ($i = 0; $i < 10; $i++) {

      $name = $faker->firstName();
      $surname = $faker->lastName();

      $email = lcfirst($name) . '.' . Str::slug($surname) . '@gmail.com';

      User::create([
        'name' => $name,
        'surname' => $surname,
        'username' => $faker->userName(),
        'email' => $email,
        'password' => '123123123',
      ]);
    }
  }
}
