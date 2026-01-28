<?php

namespace App\Controllers;

use App\Models\UserModel;

class ChangePassword extends BaseController
{
    // 🔹 SHOW CHANGE PASSWORD PAGE (GET)
    public function index()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'You must log in first.');
        }

        return view('pages/change_password');
    }

    // 🔹 HANDLE PASSWORD UPDATE (POST)
    public function update()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'Session expired. Please log in again.');
        }

        $userId = $session->get('user_id');

        // Validation
        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('error', implode('<br>', $this->validator->getErrors()))
                ->withInput();
        }

        $currentPassword = $this->request->getPost('current_password');
        $newPassword     = $this->request->getPost('new_password');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        // Update password
        $userModel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        // ✅ Set flashdata BEFORE destroying session
        $session->setFlashdata('password_changed', true);

        // Redirect back to the change_password page so modal can show
        return redirect()->to('/change_password');
    }
}
