<?php

namespace App\Console\Commands;

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
        // Adjust the URL as needed
        $url = 'http://localhost/work/qfsApi/get-lead-data';

        $response = Http::get($url);

        // Handle the response if needed
        $this->info('Lead data fetched successfully!');
    }
}