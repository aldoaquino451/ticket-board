<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use App\Models\Operator;
use App\Models\Ticket;
use Illuminate\Http\Request;

class NoteController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
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
  public function store(StoreNoteRequest $request)
  {
    $validated_data = $request->validated();

    $operator = Operator::where('id', $validated_data['operator_id'])->first();

    Note::create([
      'ticket_id' => $validated_data['ticket_id'],
      'content' => $validated_data['content'],
    ]);

    return redirect()->route('dashboard.operators.show', ['operator' => $operator->slug]);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
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
  public function update(UpdateNoteRequest $request, Note $note)
  {
    $validated_data = $request->validated();

    $note->update(['content' => $validated_data['content']]);

    $operator = Operator::where('id', $validated_data['operator_id'])->first();

    return redirect()->route('dashboard.operators.show', ['operator' => $operator->slug]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, Note $note)
  {
    $note->delete();

    $operator = Operator::where('id', $request->operator_id)->first();

    // dd($operator);

    return redirect()->route('dashboard.operators.show', ['operator' => $operator->slug]);
  }
}
