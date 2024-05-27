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
      ->get();

    $notAvailable = Operator::where('is_available', 0)
      ->orderBy('name', 'asc')
      ->orderBy('surname', 'asc')
      ->get();

    return Inertia::render('Operators/Index', [
      'available' => $available,
      'notAvailable' => $notAvailable
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

    // Rendi la vista passando i dati del ticket e delle note
    return Inertia::render('Operators/Show', [
      'ticket' => $ticket,
      'slug' => $operator->slug,
      'operator_id' => $operator->id,
      'notes' => $notes
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

    $ticket = Ticket::where('id', $validated_data['ticket_id'])->first();

    if ($validated_data['status'] == 'in progress') {
      $ticket->update(['status' => $validated_data['status']]);
      return redirect()->route('dashboard.operators.show', ['operator' => $operator]);
    } else if (($validated_data['status'] == 'closed')) {
      $ticket->update(['status' => $validated_data['status']]);
      $operator->update(['is_available' => 1]);
      // dd($ticket, $operator);
      return redirect()->route('dashboard.operators.index');
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
