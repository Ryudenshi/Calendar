<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'reminder_id',
        'repeat_type',
        'repeat_value',
    ];

    public function reminder()
    {
        return $this->belongsTo(Reminder::class);
    }
}
