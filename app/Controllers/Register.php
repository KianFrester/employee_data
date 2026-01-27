<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function index()
{
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/')->with('error', 'You must log in first.');
    }

    return view('/pages/register');
}

    public function store()
    {
         $userModel = new \App\Models\UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('confirm_password');

         // Basic validation
        if (!$username || !$password || !$confirm) {
            return redirect()->to('/register')->with('error', 'All fields are required.');
        }

        if ($password !== $confirm) {
            return redirect()->to('/register')->with('error', 'Passwords do not match.');
        }

        // Check if username exists
        if ($userModel->where('username', $username)->first()) {
            return redirect()->to('/register')->with('error', 'Username already exists.');
        }

         // Save user
        $userModel->insert([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/')->with('success', 'Account created. You can now log in.');
    }
}
