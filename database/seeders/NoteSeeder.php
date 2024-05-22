<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class NoteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $faker = Faker::create('it_IT');
    $ticketArr = Ticket::pluck('id');

    for ($i = 0; $i < 100; $i++) {

      Note::create([
        'ticket_id' => $faker->randomElement($ticketArr),
        'content' => $faker->realText(),
      ]);
    }
  }
}
