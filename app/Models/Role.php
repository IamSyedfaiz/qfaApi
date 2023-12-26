<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'lead', 'user', 'meeting', 'proposal', 'certificate', 'account', 'certificate_option'];
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
