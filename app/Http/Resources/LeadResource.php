<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
         
            'id' => $this->id,
            'user_id' => $this->user_id,
            'Name' => $this->name,
            'Email' => $this->email,
            'Number' => $this->number,
            'Number of employees' => $this->contact_person,
            'Contact Person' => null,
            'Scope Activity' => $this->scope_activity,
            'Allocate User' => $this->allocate_user,
            'Amount' => $this->amount,
            'Address' => $this->address,
            'City' => $this->city,
            'Gst' => $this->gst,
            'Additional Options' => $this->additional_options,
            'Date' => $this->date,
            'Lead Source Text' => $this->lead_source_text,
            'Comment' => $this->comment,
            'status' => [
                'id' => $this->status->id,
                'name' => $this->status->name,
            ],
            'accreditation' => [
                'id' => $this->accreditation->id,
                'accreditation_name' => $this->accreditation->accreditation_name,
            ],
            'standard' => [
                'id' => $this->standard->id,
                'standard_name' => $this->standard->standard_name,
            ],
            'lead_source' => [
                'id' => $this->leadSource->id,
                'name' => $this->leadSource->name,
            ],
        ];
    }
}