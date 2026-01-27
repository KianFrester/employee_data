<?php

namespace App\Controllers;

class Search extends BaseController
{
    public function search()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You must log in first.');
        }
        $data = [
            'username' => $session->get('username')
        ];

        return view('/pages/search', $data);
    }
}
