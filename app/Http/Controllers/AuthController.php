<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Invite\AuthenticateUser;

class AuthController extends Controller
{
    /**
     * @param  AuthenticateUser $authenticateUser
     * @param  Request          $request
     * @return mixed
     */
    public function login(AuthenticateUser $authenticateUser, Request $request)
    {
        return $authenticateUser->execute($request->has('code'), $this);
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        \Auth::logout();
        return redirect()->to('\invite');
    }

    /**
     * Checks if a user is already loggeg in or not
     * @return mixed
     */
    public function userHasLoggedIn()
    {
        return redirect('invite/');
    }

}
