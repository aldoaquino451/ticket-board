<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Operator;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TicketSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $faker = Faker::create('it_IT');
    $operatorArr = Operator::pluck('id');
    $categoryArr = Category::pluck('id');


    // closed
    for ($i = 0; $i < 100; $i++) {
      Ticket::create([
        'code' => $faker->isbn10(),
        'operator_id' => $faker->randomElement($operatorArr),
        'category_id' => $faker->randomElement($categoryArr),
        'title' => $faker->realText(30),
        'description' => $faker->realText(),
        'status' =>  'closed',
      ]);
    }

    // assigned + in progress
    $operatorAll = Operator::all();
    foreach ($operatorAll as $operator) {
      Ticket::create([
        'code' => $faker->isbn10(),
        'operator_id' => $operator->id,
        'category_id' => $faker->randomElement($categoryArr),
        'title' => $faker->realText(30),
        'description' => $faker->realText(),
        'status' =>  $faker->randomElement(['assigned', 'in progress']),
      ]);
    }


    // queued
    for ($i = 0; $i < 30; $i++) {
      Ticket::create([
        'code' => $faker->isbn10(),
        'category_id' => $faker->randomElement($categoryArr),
        'title' => $faker->realText(30),
        'description' => $faker->realText(),
        'status' =>  'queued',
      ]);
    }
  }
}
