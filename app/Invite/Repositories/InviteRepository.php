<?php

namespace Invite\Repositories;

use App\Invite;

class InviteRepository
{
    public function findByUserIDandEmail($user_id, $email)
    {
        return Invite::where('user_id', $user_id)
                       ->where('email', $email)
                       ->first();
    }
}
