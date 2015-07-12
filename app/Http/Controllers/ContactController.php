<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Invite\UserContacts;
use Invite\Repositories\InviteRepository;
use App\Jobs\SendInviteEmail;

class ContactController extends Controller
{
    private $userContacts;
    private $invites;

    public function __construct(
        UserContacts $userContacts,
        InviteRepository $invites
    ) {
        $this->userContacts = $userContacts;
        $this->invites = $invites;
    }
    public function getContacts(Request $request)
    {
        return $this->userContacts->get($request);
    }

    public function viewContacts()
    {
        $contacts = \Session::get('contacts');
        // return $contacts;
        return view('contacts')->with('contacts', $contacts);
    }

    public function invite($email)
    {
        $this->invites->store($email);
        $this->dispatch(new SendInviteEmail($email));
        return "Invite sent";
    }
}
