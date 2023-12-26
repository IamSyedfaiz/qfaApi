<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;
use App\Models\FollowUp;
use App\Models\Certificate;
use Illuminate\Support\Facades\Mail;

class SendCertificationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'certification:send-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $leads = Lead::all();
        $mailSend = false;
        $this->info('strat');

        foreach ($leads as $lead) {
            $certificate = $lead->certificate;
            if ($certificate) {
                if (date('d-m-Y', strtotime($certificate->date_initia . ' -2 days')) == date('d-m-Y')) {
                    $mailSend = true;
                }
                if (date('d-m-Y', strtotime($certificate->first_surveillance_audit . ' -2 days')) == date('d-m-Y')) {
                    $mailSend = true;
                }
                if (date('d-m-Y', strtotime($certificate->second_surveillance_audit . ' -2 days')) == date('d-m-Y')) {
                    $mailSend = true;
                }
                if (date('d-m-Y', strtotime($certificate->certification_due_date . ' -2 days')) == date('d-m-Y')) {
                    $mailSend = true;
                }

                if ($mailSend == true) {
                    $recipientEmail = $lead->email;
                    $data['lead_name'] = $lead->name;
                    Mail::send('email.email_info', $data, function ($msg) use ($recipientEmail) {
                        $msg->from(env('MAIL_FROM_ADDRESS'));
                        $msg->to($recipientEmail, env('MAIL_FROM_NAME'));
                        $msg->subject('RICL Intervention Form');
                    });
                }

                $this->info('end');
            }
        }
    }
}
