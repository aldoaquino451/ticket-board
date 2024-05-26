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
    $available = Operator::where('is_available', 1)->get();
    $notAvailable = Operator::where('is_available', 0)->get();

    return Inertia::render('Operators/Index', ['available' => $available, 'notAvailable' => $notAvailable]);
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
    $ticket = Ticket::where('operator_id', $operator->id)->whereIn('status', ['assigned', 'in progress'])->first();
    $notes = Note::where('ticket_id', $ticket->id)->get();

    return Inertia::render('Operators/Show', ['ticket' => $ticket, 'slug' => $operator->slug, 'notes' => $notes]);
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
  public function update(UpdateOperatorRequest $request, string $slug)
  {
    $validated_data = $request->validated();

    $ticket_id = $validated_data['ticket']['id'];
    $ticket = Ticket::where('id', $ticket_id)->first();
    $operator = Operator::where('slug', $slug)->first();

    if ($validated_data['status'] == 'in progress') {
      $ticket->update($validated_data);
      return redirect()->route('dashboard.operators.show', ['operator' => $operator]);
    } else {
      $ticket->update([$validated_data['status']]);
      $operator->update(['is_available' => 1]);
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
