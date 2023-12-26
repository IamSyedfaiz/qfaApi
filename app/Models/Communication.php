<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'lead_id',
        'type',
        'date_time',
        'message',
        'subject',
        'file',
        'status',
    ];
    public function getTypeLabel()
    {
        $types = [
            'c' => 'Call',
            'e' => 'Email',
            'w' => 'WhatsApp',
            'm' => 'Meeting',
        ];

        return $types[$this->type] ?? 'Unknown';
    }
    public function getFormattedDateTimeAttribute()
    {
        return Carbon::parse($this->date_time)->format('j F Y, h:i A');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
