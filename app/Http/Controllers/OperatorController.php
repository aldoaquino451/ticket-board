<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOperatorRequest;
use App\Models\Note;
use App\Models\Operator;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OperatorController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $available = Operator::where('is_available', 1)
      ->orderBy('name', 'asc')
      ->orderBy('surname', 'asc')
      ->with(['tickets' => function ($query) {
        $query->whereIn('status', ['assigned', 'in progress']);
      }])
      ->get();

    $notAvailable = Operator::where('is_available', 0)
      ->orderBy('name', 'asc')
      ->orderBy('surname', 'asc')
      ->with(['tickets' => function ($query) {
        $query->whereIn('status', ['assigned', 'in progress']);
      }])
      ->get();

    $flash_message = session('flash', null);

    return Inertia::render('Operators/Index', [
      'available' => $available,
      'notAvailable' => $notAvailable,
      'flash' => $flash_message,
    ]);
  }


  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Operator $operator)
  {
    // Trova il primo ticket dell'operatore con stato 'assigned' o 'in progress'
    $ticket = Ticket::where('operator_id', $operator->id)->whereIn('status', ['assigned', 'in progress'])->first();

    if ($ticket) {
      $ticket->load('category', 'operator');
    }

    // Se c'è un ticket, trova le note associate, altrimenti imposta un array vuoto
    $notes = $ticket ? Note::where('ticket_id', $ticket->id)->get() : [];

    $flash_message = session('flash', null);

    // Rendi la vista passando i dati del ticket e delle note
    return Inertia::render('Operators/Show', [
      'ticket' => $ticket,
      'slug' => $operator->slug,
      'operator_id' => $operator->id,
      'notes' => $notes,
      'operator' => $operator,
      'flash' => $flash_message,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateOperatorRequest $request, Operator $operator)
  {
    $validated_data = $request->validated();

    if ($request->has('is_available')) {

      $operator->update(['is_available' => $validated_data['is_available']]);

      if ($validated_data['is_available'] === true) {

        $oldestQueuedTicket = Ticket::where('status', 'queued')
          ->orderBy('created_at', 'asc')
          ->first();

        if (!$oldestQueuedTicket) {

          $flash_message = [
            'message' => 'Attualmente non ci sono ticket in coda da poter lavorare.',
            'class' => 'text-red-600 dark:text-red-400'
          ];

          // return redirect()->route('dashboard.operators.show', ['operator' => $operator])->with('flash', $flash_message);
          return redirect()->route('dashboard.operators.index')->with('flash', $flash_message);
        }

        $oldestQueuedTicket->update(['status' => 'assigned']);
        $oldestQueuedTicket->update(['operator_id' => $operator->id]);
        $operator->update(['is_available' => false]);

        // dd($oldestQueuedTicket, $operator);

        return redirect()->route('dashboard.operators.show', ['operator' => $operator]);
      } else {

        return redirect()->route('dashboard.operators.index');
      }
    } else {

      $ticket = Ticket::where('id', $validated_data['ticket_id'])->first();

      $ticket->update(['status' => $validated_data['status']]);

      return redirect()->route('dashboard.operators.show', ['operator' => $operator]);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
