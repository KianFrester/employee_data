<?php

namespace App\Controllers;

class Create extends BaseController
{
    public function create()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You must log in first.');
        }
        $data = [
            'username' => $session->get('username')
        ];

        return view('/pages/create', $data);
    }
}
