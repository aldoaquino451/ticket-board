<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Category;
use App\Models\Operator;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Faker\Factory as Faker;
use Illuminate\Support\Collection;

class TicketController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $tickets = Ticket::with(['category', 'operator'])->paginate(15);

    // Controlla se la richiesta è AJAX e restituisci una risposta JSON
    if ($request->expectsJson()) {
      return response()->json([
        'tickets' => $tickets->items(),
        'pagination' => [
          'current_page' => $tickets->currentPage(),
          'last_page' => $tickets->lastPage(),
          'from' => $tickets->firstItem(),
          'to' => $tickets->lastItem(),
          'total' => $tickets->total(),
        ],
      ]);
    }

    // Restituisci la vista Inertia se la richiesta non è AJAX
    return Inertia::render('Tickets/Index', [
      'tickets' => $tickets->items(),
      'pagination' => [
        'current_page' => $tickets->currentPage(),
        'last_page' => $tickets->lastPage(),
        'from' => $tickets->firstItem(),
        'to' => $tickets->lastItem(),
        'total' => $tickets->total(),
      ]
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $categories = Category::all();

    return Inertia::render('Tickets/Create', [
      'categories' => $categories
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreTicketRequest $request)
  {
    $faker = Faker::create('it_IT');

    // Creating code
    $validated_data = $request->validated();
    $validated_data['code'] = $faker->isbn10();

    $available_operators = Operator::where('is_available', true)->get();

    if ($available_operators->count() > 0) {

      $random_operator = $faker->randomElement($available_operators);
      $validated_data['operator_id'] = $random_operator->id;
      $random_operator->update(['is_available' => 0]);

      $validated_data['status'] = 'assigned';
    } else {

      $validated_data['operator_id'] = null;
      $validated_data['status'] = 'queued';
    }

    $new_ticket = Ticket::create($validated_data);

    return Inertia::render('Tickets/Show', [
      'ticket' => $new_ticket
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(Ticket $ticket)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Ticket $ticket)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Ticket $ticket)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Ticket $ticket)
  {
    //
  }
}
