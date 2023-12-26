<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'lead_id', 'date_time', 'status'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}
