<?php

namespace App\Console\Commands;

use App\Models\ApiLead;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetLeadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-lead-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch lead data from Indiamart route every 6 minutes';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $crmKey = 'mRyzEbts7HrEQfei4XGD7l+IqlTFnzQ=';

        $latestApiLead = ApiLead::latest()->first();
        $carbonDate = Carbon::parse($latestApiLead->query_time);

        $startTimestamp = $carbonDate->format('d-M-Y');
        $endTimestamp = $carbonDate->addDays(7)->format('d-M-Y');
        logger($latestApiLead);
        logger($carbonDate);
        // logger($startTimestamp);


        $apiEndpoint = "https://mapi.indiamart.com/wservce/crm/crmListing/v2/?glusr_crm_key={$crmKey}&start_time={$startTimestamp}&end_time={$endTimestamp}";

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
        $this->info('Lead data fetched successfully!');
    }
}