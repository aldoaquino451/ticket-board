<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FilterTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
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

        return response()->json($pagination);
    }

    public function filter(FilterTicketRequest $request)
    {
        $validated_data = $request->validated();

        $query = Ticket::with(['category', 'operator']);

        // Filtra per operator_id se presente
        $query->when($request->filled('operator_id'), function ($q) use ($request) {
            $q->where('operator_id', $request->input('operator_id'));
        });

        // Filtra per code se presente
        $query->when($request->filled('code'), function ($q) use ($request) {
            $q->where('code', $request->input('code'));
        });

        // Filtra per category_id se presente
        $query->when($request->filled('category_id'), function ($q) use ($request) {
            $q->where('category_id', $request->input('category_id'));
        });

        // Filtra per dateStart e dateEnd se entrambe presenti
        $query->when($request->filled('dateStart') && $request->filled('dateEnd'), function ($q) use ($request) {
            $q->whereBetween('created_at', [$request->input('dateStart'), $request->input('dateEnd')]);
        });

        // Filtra per statuses se presente
        $query->when($request->filled('statuses'), function ($q) use ($request) {
            $statuses = $request->input('statuses');
            $q->whereIn('status', $statuses);
        });

        // Paginazione
        $tickets = $query->paginate(15);

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

        return response()->json($pagination);
    }
}
