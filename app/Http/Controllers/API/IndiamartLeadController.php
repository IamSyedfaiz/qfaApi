<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ApiLead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class IndiamartLeadController extends Controller
{
    public function getLeadData()
    {
        try {
            // $crmKey = 'mRyzEbts7HrEQfei4XGD7l+IqlTFnzQ=';

            $endTimestamp = Carbon::create(2023, 2, 28)->format('d-M-Y');
            $startTimestamp = Carbon::create(2023, 2, 28)->subDays(7)->format('d-M-Y');

            // $apiEndpoint = "https://mapi.indiamart.com/wservce/crm/crmListing/v2/?glusr_crm_key={$crmKey}&start_time={$startTimestamp}&end_time={$endTimestamp}";
            $apiEndpoint = "";

            logger($apiEndpoint);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->get($apiEndpoint);

            $data = $response->json();
            logger($data);
            foreach ($data['RESPONSE'] as $leadData) {
                ApiLead::create([
                    'unique_query_id' => $leadData['UNIQUE_QUERY_ID'] ?? null,
                    'query_type' => $leadData['QUERY_TYPE'] ?? null,
                    'query_time' => $leadData['QUERY_TIME'] ?? null,
                    'sender_name' => $leadData['SENDER_NAME'] ?? null,
                    'sender_mobile' => $leadData['SENDER_MOBILE'] ?? null,
                    'sender_email' => $leadData['SENDER_EMAIL'] ?? null,
                    'subject' => $leadData['SUBJECT'] ?? null,
                    'sender_company' => $leadData['SENDER_COMPANY'] ?? null,
                    'sender_address' => $leadData['SENDER_ADDRESS'] ?? null,
                    'sender_city' => $leadData['SENDER_CITY'] ?? null,
                    'sender_state' => $leadData['SENDER_STATE'] ?? null,
                    'sender_pincode' => $leadData['SENDER_PINCODE'] ?? null,
                    'sender_country_iso' => $leadData['SENDER_COUNTRY_ISO'] ?? null,
                    'sender_mobile_alt' => $leadData['SENDER_MOBILE_ALT'] ?? null,
                    'sender_phone' => $leadData['SENDER_PHONE'] ?? null,
                    'sender_phone_alt' => $leadData['SENDER_PHONE_ALT'] ?? null,
                    'sender_email_alt' => $leadData['SENDER_EMAIL_ALT'] ?? null,
                    'query_product_name' => $leadData['QUERY_PRODUCT_NAME'] ?? null,
                    'query_message' => $leadData['QUERY_MESSAGE'] ?? null,
                    'query_mcat_name' => $leadData['QUERY_MCAT_NAME'] ?? null,
                    'call_duration' => $leadData['CALL_DURATION'] ?? null,
                    'receiver_mobile' => $leadData['RECEIVER_MOBILE'] ?? null,
                ]);
            }
            // return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function apiLeadView($id)
    {
        try {
            $apiLead = ApiLead::find($id);
            $attributes = $apiLead->getAttributes();
            $excludeAttributes = ['id', 'created_at', 'updated_at'];
            $filteredAttributes = array_diff_key($attributes, array_flip($excludeAttributes));

            return view('admin.viewApiLeads', compact('apiLead', 'filteredAttributes'));
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}