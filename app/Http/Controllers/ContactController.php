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
    /**
     * @var Invite\UserContacts
     */
    private $userContacts;

    /**
     * @var Invite\Repositories\InviteRepository
     */
    private $invites;

    public function __construct(
        UserContacts $userContacts,
        InviteRepository $invites
    ) {
        $this->userContacts = $userContacts;
        $this->invites = $invites;
    }

    /**
     * Get contacts using Google contacts API
     * @param  Request $request
     * @return mixed
     */
    public function getContacts(Request $request)
    {
        return $this->userContacts->get($request);
    }

    /**
     * Display the contacst
     * @return mixed
     */
    public function viewContacts()
    {
        $contacts = \Session::get('contacts');
        // return $contacts;
        return view('contacts')->with('contacts', $contacts);
    }

    /**
     * Invites a contact to join Invite
     * @param  string $email
     * @return mixed
     */
    public function invite($email)
    {
        $this->invites->store($email);
        $this->dispatch(new SendInviteEmail($email));
        return "Invite sent";
    }
}
