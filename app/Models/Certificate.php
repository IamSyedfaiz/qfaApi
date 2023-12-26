<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'lead_id', 'certificate_template', 'certificate_status', 'standard_name', 'standard_description', 'business_name', 'business_name_secondary', 'scope_registration', 'registered_site', 'business_sector'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'certificate_id');
    }
    public function documents()
    {
        return $this->hasMany(Document::class, 'certificate_id');
    }
    public function standard()
    {
        return $this->belongsTo(Standard::class, 'standard_id');
    }
}
