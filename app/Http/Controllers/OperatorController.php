<?php

namespace App\Http\Controllers;

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

    return Inertia::render('Operators/Show', ['ticket' => $ticket]);
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
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
