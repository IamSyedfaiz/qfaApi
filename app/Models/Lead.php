<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'email', 'number', 'allocate_user', 'scope_activity', 'standard_id', 'accreditation_id', 'address', 'city', 'date', 'status_id', 'amount', 'lead_source_id', 'gst', 'additional_options', 'lead_source_text', 'comment', 'contact_person', 'unique_query_id', 'sender_company', 'sender_state', 'sender_pincode', 'sender_country_iso', 'sender_mobile_alt', 'sender_phone', 'sender_phone_alt', 'sender_email_alt', 'query_product_name', 'call_duration', 'receiver_mobile'];
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