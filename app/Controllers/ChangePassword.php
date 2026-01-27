<?php

namespace App\Controllers;

class ChangePassword extends BaseController
{
    public function change_password()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You must log in first.');
        }
        $data = [
            'username' => $session->get('username')
        ];

        return view('/pages/change_password', $data);
    }
}
