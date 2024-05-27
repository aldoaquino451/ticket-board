<?php

namespace App\Models;

use App\Mail\TicketNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Mail;


class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'operator_id',
        'category_id',
        'title',
        'description',
        'status'
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($ticket) {
    //         $messageContent = 'Un nuovo ticket è stato creato e ti è stato assegnato.';
    //         Mail::to($ticket->operator->email)->send(new TicketNotification($ticket, $messageContent));
    //     });

    //     static::updated(function ($ticket) {
    //         if ($ticket->status === 'closed') {
    //             $messageContent = 'Un ticket è stato chiuso.';
    //             Mail::to($ticket->operator->email)->send(new TicketNotification($ticket, $messageContent));
    //         } elseif ($ticket->status === 'assigned') {
    //             $messageContent = 'Ti è stato assegnato un ticket.';
    //             Mail::to($ticket->operator->email)->send(new TicketNotification($ticket, $messageContent));
    //         }
    //     });
    // }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
