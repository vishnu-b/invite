<?php

namespace Invite\Repositories;

use App\Invite;
use Auth;
use Mail;

class InviteRepository
{
    /**
     * Creates new invite
     * @param  string $email
     * @return mixed
     */
    public function store($email)
    {
        $auth_user_id = Auth::user()->id;
        $auth_user_email = Auth::user()->email;
        $auth_user_name = Auth::user()->name;

        $invite = new Invite;
        $invite->user_id = $auth_user_id;
        $invite->email = $email;
        $invite->save();
    }

    /**
     * @param  integer $user_id
     * @param  string $email
     * @return mixed
     */
    public function findByUserIDandEmail($user_id, $email)
    {
        return Invite::where('user_id', $user_id)
                       ->where('email', $email)
                       ->first();
    }
}
