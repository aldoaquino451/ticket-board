<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
