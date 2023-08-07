<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'color',
        'start_datetime',
        'end_datetime',
        'completed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
