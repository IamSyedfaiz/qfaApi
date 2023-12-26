<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'email', 'number', 'allocate_user', 'scope_activity', 'standard_id', 'accreditation_id', 'address', 'city', 'date', 'status_id', 'amount', 'lead_source_id', 'gst', 'additional_options', 'lead_source_text', 'comment', 'contact_person'];
    public function allocatedUser()
    {
        return $this->belongsTo(User::class, 'allocate_user');
    }
    public function executive()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class, 'lead_source_id');
    }
    public function standard()
    {
        return $this->belongsTo(Standard::class, 'standard_id');
    }
    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'lead_id');
    }

    public function accreditation()
    {
        return $this->belongsTo(Accreditation::class);
    }
}
