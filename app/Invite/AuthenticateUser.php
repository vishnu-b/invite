<?php
namespace Invite;

use Laravel\Socialite\Contracts\Factory as Socialite;
use Invite\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard;

class AuthenticateUser
{
    /**
     * @var Invite\Repositories\UserRepository
     */
    private $users;

    /**
     * @var Laravel\Socialite\Contracts\Factory
     */
    private $socialite;

    /**
     * @var Illuminate\Contracts\Auth\Guard
     */
    private $guard;

    public function __construct(UserRepository $users, Socialite $socialite, Guard $guard)
    {

        $this->users = $users;
        $this->socialite = $socialite;
        $this->guard = $guard;
    }


    /**
     * @param $hasCode
     * @param $listener
     * @return mixed
     */
    public function execute($hasCode, $listener)
    {
        if (!$hasCode) {
            return $this->getAuthorizationFirst();
        }
        $googleUser = $this->getGoogleUser();
        $user = $this->users->findByUsernameOrCreate($googleUser);
        $this->guard->login($user, true);
        return $listener->userHasLoggedIn();

    }

    /**
     * Logs out user
     * @return mixed
     */
    public function logout()
    {

        \Auth::logout();

        return redirect('/');


    }

    /**
     * Authorizes user using Socialite
     * @return mixed
     */
    private function getAuthorizationFirst()
    {

        return \Socialite::with('google')->redirect();

    }

    /**
     * Get google user details
     * @return mixed
     */
    private function getGoogleUser()
    {

        return \Socialite::with('google')->user();
    }
}
