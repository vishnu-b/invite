<?php

namespace Invite\Repositories;

use App\User;

class UserRepository
{
    /**
     * @param  String $email
     * @return mixed
     */
    public function findByUsername($email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * @param  Array $userData
     * @return mixed
     */
    public function findByUsernameOrCreate($userData)
    {
        $user = User::where('email', $userData->email)->first();

        if (!$user) {
            return User::create([
                'name' => $userData->name,
                'email' => $userData->email,
                'avatar' => $userData->avatar
            ]);
        }

        return $user;
    }
}
