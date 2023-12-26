<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'certificate_id',
        'user_id',
        'payment_type',
        'payment_balance',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function certificate()
    {
        return $this->belongsTo(Certificate::class, 'certificate_id');
    }
}
