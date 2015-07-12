<?php

namespace Invite;

use Invite\Repositories\UserRepository;
use Invite\Repositories\InviteRepository;
use Artdarek\OAuth\OAuth;
use Invite\UserContacts;
use Auth;

class UserContacts
{
    private $users;
    private $invites;
    private $oAuth;

    public function __construct(
        UserRepository $users,
        InviteRepository $invites,
        OAuth $oAuth
    ) {
        $this->users = $users;
        $this->invites = $invites;
        $this->oAuth = $oAuth;
    }

    public function get($request)
    {
        $googleService = $this->oAuth->consumer('Google');

        $code = $request->code;
        if (!is_null($code)) {
            $token = $googleService->requestAccessToken($code);
            $result = json_decode($googleService->request("https://www.google.com/m8/feeds/contacts/default/full?alt=json&max-results=400"), true);
            $contacts = [];
            foreach ($result['feed']['entry'] as $contact) {
                if (isset($contact['gd$email'])) {
                    $contacts[] = [
                        'email' => $contact['gd$email'][0]['address'],
                        'title' => $contact['title']['$t']
                    ];

                }
            }

            $contacts = $this->categorize($contacts);
            // return $contacts;
            \Session::set('contacts', $contacts);
            return redirect()->route('contacts');
        } else {
            $url = $googleService->getAuthorizationUri();
            return redirect((string)$url);
        }
    }

    public function categorize($contacts)
    {
        $auth_user_id = Auth::user()->id;
        $filtered_contacts = [];

        foreach ($contacts as $contact) {
            $email = $contact['email'];
            if ($this->users->findByUsername($email)) {
                $filtered_contacts['member'][] = $contact;
            } else if ($this->invites->findByUserIDandEmail(
                $auth_user_id,
                $email
            )) {
                $filtered_contacts['invited'][] = $contact;
            } else {
                $filtered_contacts['not_invited'][] = $contact;
            }
        }

        return $filtered_contacts;
    }
}
