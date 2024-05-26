<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Mail\TicketNotification;
use App\Models\Category;
use App\Models\Operator;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $tickets = Ticket::with(['category', 'operator'])->paginate(15);

    $pagination = [
      'tickets' => $tickets->items(),
      'pagination' => [
        'current_page' => $tickets->currentPage(),
        'last_page' => $tickets->lastPage(),
        'from' => $tickets->firstItem(),
        'to' => $tickets->lastItem(),
        'total' => $tickets->total(),
      ],
    ];

    // Controlla se la richiesta è AJAX e restituisci una risposta JSON
    if ($request->expectsJson()) {
      return response()->json($pagination);
    }

    // Restituisci la vista Inertia se la richiesta non è AJAX
    return Inertia::render('Tickets/Index', $pagination);
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

      $flash_message = [
        'message' => 'Il ticket è stato creato con successo e assegnato a un operatore.',
        'class' => 'text-green-600 dark:text-green-400'
      ];
    } else {

      $validated_data['operator_id'] = null;
      $validated_data['status'] = 'queued';

      $flash_message = [
        'message' => 'Il ticket è stato creato con successo ma nessun operatore è attualmente disponibile. Il ticket è stato messo in coda',
        'class' => 'text-yellow-600 dark:text-yellow-400'
      ];
    }

    $new_ticket = Ticket::create($validated_data);
    $new_ticket->load('category', 'operator'); // Carica le relazioni

    if ($new_ticket->operator_id !== null) {
      $messageContent = 'Un nuovo ticket è stato creato.';
      Mail::to($new_ticket->operator->email)->send(new TicketNotification($new_ticket, $messageContent));
    }

    return redirect()->route('dashboard.tickets.show', ['ticket' => $new_ticket->code])
      ->with('flash', $flash_message);
  }

  /**
   * Display the specified resource.
   */
  public function show(Ticket $ticket)
  {
    $ticket->load('category', 'operator');

    $flash_message = session('flash', null);

    return Inertia::render('Tickets/Show', [
      'ticket' => $ticket,
      'flash' => $flash_message,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Ticket $ticket)
  {
    $ticket->load('category', 'operator');

    $statuses = [
      ['id' => 'queued', 'name' => 'In coda'],
      ['id' => 'assigned', 'name' => 'Assegnato'],
      // ['id' => 'in progress', 'name' => 'In lavorazione'],
      ['id' => 'closed', 'name' => 'Chiuso'],
    ];

    $operators = Operator::all();

    $flash_message = session('flash', null);

    return Inertia::render('Tickets/Edit', [
      'ticket' => $ticket,
      'operators' => $operators,
      'statuses' => $statuses,
      'flash' => $flash_message,
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateTicketRequest $request, Ticket $ticket)
  {
    $validated_data = $request->validated();
    $ticket->update(['status' => $validated_data['status']]);

    switch ($validated_data['status']) {
      case 'queued':

        $ticket->update(['operator_id' => null]);

        $flash_message = [
          'message' => 'Il ticket è stato modificato con successo ed è stato messo in coda.',
          'class' => 'text-amber-600 dark:text-amber-400'
        ];
        break;
      case 'assigned':

        $ticket->update(['operator_id' => $validated_data['operator_id']]);

        $messageContent = 'Ti è stato assegnato un ticket.';

        $flash_message = [
          'message' => 'Il ticket è stato modificato con successo e assegnato a un operatore.',
          'class' => 'text-green-600 dark:text-green-400'
        ];
        break;
      case 'closed':

        $messageContent = 'Un ticket è stato chiuso.';

        $flash_message = [
          'message' => 'Il ticket è stato modificato con successo ed è stato chiuso.',
          'class' => 'text-red-600 dark:text-red-400'
        ];
        break;
    }

    if ($ticket->operator_id !== null) {
      Mail::to($ticket->operator->email)->send(new TicketNotification($ticket, $messageContent));
    }

    return redirect()
      ->route('dashboard.tickets.edit', ['ticket' => $ticket->code])
      ->with('flash', $flash_message);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Ticket $ticket)
  {
    //
  }
}
