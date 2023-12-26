<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'certificate_id', 'file_name', 'file_path', 'status',
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
