<?php
namespace Invite;

use Laravel\Socialite\Contracts\Factory as Socialite;
use Invite\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard;

class AuthenticateUser
{

    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var Socialite
     */
    private $socialite;
    /**
     * @var Guard
     */
    private $guard;

    private $token;

    public function __construct(UserRepository $users, Socialite $socialite, Guard $guard)
    {

        $this->users = $users;
        $this->socialite = $socialite;
        $this->guard = $guard;
    }


    /**
     * @param $hasCode
     * @param AuthenticateUserListener $listener
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

    public function logout()
    {

        \Auth::logout();

        return redirect('/');


    }

    private function getAuthorizationFirst()
    {

        return \Socialite::with('google')->redirect();

    }

    private function getGoogleUser()
    {

        return \Socialite::with('google')->user();
    }
}
