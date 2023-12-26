<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FollowUp;
use Illuminate\Support\Facades\Mail;

class FollowUpReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'followup:reminder';

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
        // return Command::SUCCESS;
        $followUps = FollowUp::all();
        $this->info('strat');

        foreach ($followUps as $followUp) {
            if (now()->isSameDay($followUp->date_time)) {
                $recipientEmail = $followUp->user->email;
                $this->info($followUp->date_time);
                $data['lead_name'] = $followUp->lead->name;
                Mail::send('email.email_followup', $data, function ($msg) use ($recipientEmail) {
                    $msg->from(env('MAIL_FROM_ADDRESS'));
                    $msg->to($recipientEmail, env('MAIL_FROM_NAME'));
                    $msg->subject('QFS MANAGEMENT SYSTEM LLP.');
                });
            }
        }
        $this->info('end');
    }
}
