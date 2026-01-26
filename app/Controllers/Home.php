<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function authenticate()
{
    $session = session();
    $userModel = new \App\Models\UserModel();

    $username = trim($this->request->getPost('username'));
    $password = trim($this->request->getPost('password'));

    $user = $userModel->where('username', $username)->first();

    if ($user && password_verify($password, $user['password'])) {
        // Store session
        $session->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'isLoggedIn' => true
        ]);
        return redirect()->to('/dashboard');
    } else {
        return redirect()->to('/')->with('error', 'Invalid username or password');
    }
}
}