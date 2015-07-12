<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;

class SendInviteEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $auth_user_email;
    private $auth_user_name;
    private $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->auth_user_email = \Auth::user()->email;
        $this->auth_user_name  = \Auth::user()->name;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailer->send('emails.invite', [
            'email' => $this->auth_user_email,
            'name'  => $this->auth_user_name
        ], function ($message) {
            $message->from($this->auth_user_email, $this->auth_user_name);
            $message->to($this->email)->subject('Invite to join Invite');
        });
    }
}
