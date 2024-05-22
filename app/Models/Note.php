<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
  use HasFactory;

  protected $fillable = [
    'ticket_id',
    'content'
  ];

  public function operator(): BelongsTo
  {
    return $this->belongsTo(Ticket::class);
  }
}
