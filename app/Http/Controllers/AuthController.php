<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Invite\AuthenticateUser;

class AuthController extends Controller
{
    public function login(AuthenticateUser $authenticateUser, Request $request)
    {
        return $authenticateUser->execute($request->has('code'), $this);
    }

    public function logout()
    {
        \Auth::logout();
        return redirect()->to('\invite');
    }

    public function userHasLoggedIn()
    {
        return redirect('invite/');
    }

    public function contacts(AuthenticateUser $authenticateUser, Request $request)
    {
        return $authenticateUser->getContacts($request);
    }
}
