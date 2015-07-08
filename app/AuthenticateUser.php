<?php

namespace Invite;

use Invite\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use Laravel\Socialite\Contracts\Factory as Socialite;

class AuthenticateUser
{
    private $user;
    private $socialite;
    private $guard;

    public function __construct(UserRepository $users, Socialite $socialite, Guard $guard)
    {
        $this->users = $users;
        $this->socialite = $socialite;
        $this->guard = $guard;
    }

    public function execute($hasCode, $listener)
    {
        if (!$hasCode) {
            return $this->getAuthorizationFirst();
        }
        $user = $this->users->findByUsernameOrCreate($this->getGoogleUser());
        $this->guard->login($user, true);

        return $listener->userHasLoggedIn();
    }

    private function getAuthorizationFirst()
    {
        return $this->socialite->with('google')->redirect();
    }

    private function getGoogleUser()
    {
        return $this->socialite->with('google')->user();
    }
}
