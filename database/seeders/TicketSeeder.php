<?php

namespace Database\Seeders;

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



        Ticket::create([
            'code' => $faker->isbn10(),
            'operator_id' => $name,
            'category_id' => $email,
            'title' => $message,
            'description' => $createdAt,
            'status' => $createdAt,
        ]);
    }
}
