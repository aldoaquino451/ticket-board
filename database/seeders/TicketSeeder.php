<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Operator;
use App\Models\Ticket;
use Carbon\Carbon;
use DateTime;
use Faker\Core\DateTime as CoreDateTime;
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
    $createdTime = Carbon::create(2023, 6, 1);

    // closed
    for ($i = 0; $i < 100; $i++) {

      $createdTime->addHours(rand(0, 100));

      Ticket::create([
        'code' => $faker->isbn10(),
        'operator_id' => $faker->randomElement($operatorArr),
        'category_id' => $faker->randomElement($categoryArr),
        'title' => $faker->realText(30),
        'description' => $faker->realText(),
        'status' =>  'closed',
        'created_at' => $createdTime,
      ]);
    }

    $createdTime = Carbon::create(2024, 5, 20);

    // assigned + in progress
    $available_operators = Operator::where('is_available', 0)->get();

    foreach ($available_operators as $operator) {
      $createdTime->addMinutes(rand(30, 60));

      Ticket::create([
        'code' => $faker->isbn10(),
        'operator_id' => $operator->id,
        'category_id' => $faker->randomElement($categoryArr),
        'title' => $faker->realText(30),
        'description' => $faker->realText(),
        'status' =>  $faker->randomElement(['assigned', 'in progress']),
        'created_at' => $createdTime,
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
