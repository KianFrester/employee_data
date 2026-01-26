<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function dashboard()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You must log in first.');
        }
        $data = [
            'username' => $session->get('username')
        ];

        return view('/pages/dashboard', $data);
    }
}
