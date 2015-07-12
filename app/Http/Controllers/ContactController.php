<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Invite\UserContacts;

class ContactController extends Controller
{
    private $userContacts;

    public function __construct(UserContacts $userContacts)
    {
        $this->userContacts = $userContacts;
    }
    public function getContacts(Request $request)
    {
        return $this->userContacts->get($request);
    }

    public function viewContacts()
    {
        $contacts = \Session::get('contacts');
        return view('contacts')->with('contacts', $contacts);
    }
}
