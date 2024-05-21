<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('it_IT');

        for ($i = 0; $i < 10; $i++) {

            $name = $faker->firstName();
            $surname = $faker->lastName();

            $email = lcfirst($name) . '.' . lcfirst($surname) . '@gmail.com';

            User::create([
                'name' => $name,
                'surname' => $surname,
                'username' => $faker->userName(),
                'email' => $email,
                'password' => $faker->password(8, 32),
            ]);
        }
    }
}
