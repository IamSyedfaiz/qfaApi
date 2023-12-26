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
            // $apiEndpoint = 'https://mapi.indiamart.com/wservce/crm/crmListing/v2/?glusr_crm_key=mRyzEbts7HrEQfei4XGD7l+IqlTFnzQ=&start_time=01-Jan-202309:00:00&end_time=06-Jan-202313:00:00'; // Replace with the actual API endpoint
            // Replace with the actual API endpoint
            $crmKey = 'mRyzEbts7HrEQfei4XGD7l+IqlTFnzQ=';
            $endTimestamp = Carbon::now()->format('d-M-Y');

            // Calculate the start_date by subtracting 365 days from the end_date
            $startTimestamp = Carbon::now()->subDays(7)->format('d-M-Y');

            $apiEndpoint = "https://mapi.indiamart.com/wservce/crm/crmListing/v2/?glusr_crm_key={$crmKey}&start_time={$startTimestamp}&end_time={$endTimestamp}";
            // $apiEndpoint = "https://mapi.indiamart.com/wservce/crm/crmListing/v2/?glusr_crm_key={$crmKey}";

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
            return response()->json($data);

            // return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}