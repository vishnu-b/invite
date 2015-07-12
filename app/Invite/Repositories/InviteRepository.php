<?php

namespace Invite\Repositories;

use App\Invite;
use Auth;
use Mail;

class InviteRepository
{
    public function store($email)
    {
        $auth_user_id = Auth::user()->id;
        $auth_user_email = Auth::user()->email;
        $auth_user_name = Auth::user()->name;

        $invite = new Invite;
        $invite->user_id = $auth_user_id;
        $invite->email = $email;
        $invite->save();

         /*Mail::send('emails.invite', [
            'email' => $auth_user_email,
            'name'  => $auth_user_name
        ], function ($message) use ($invite, $auth_user_email, $auth_user_name) {
            $message->from($auth_user_email, $auth_user_name);
            $message->to($invite->email)->subject('Invite to join Invite');
        });*/

        return "Invite sent.";
    }

    public function findByUserIDandEmail($user_id, $email)
    {
        return Invite::where('user_id', $user_id)
                       ->where('email', $email)
                       ->first();
    }
}
