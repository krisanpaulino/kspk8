<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Profile extends BaseController
{
    /**
     * Display the change password form
     */
    public function index()
    {
        $data = [
            'title' => 'Ubah Password'
        ];
        return view('admin/profile_password', $data);
    }

    /**
     * Process the change password request
     */
    public function changePassword()
    {
        // Check if user is logged in
        if (!session()->has('user')) {
            return redirect()->to('auth')->with('danger', 'Anda harus login terlebih dahulu');
        }

        $validation = \Config\Services::validation();

        // Set validation rules
        $validation->setRules([
            'current_password' => [
                'label' => 'Password Lama',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 6 karakter'
                ]
            ],
            'new_password' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'min_length' => '{field} minimal 6 karakter'
                ]
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'matches' => '{field} tidak sama dengan Password Baru'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Get form data
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        // Get current user from session
        $currentUser = session()->get('user');

        // Load user model and get current user data
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($currentUser->user_id);

        if (!$user) {
            return redirect()->back()->with('danger', 'User tidak ditemukan');
        }

        // Verify current password
        if (!password_verify($currentPassword, $user->user_password)) {
            return redirect()->back()->with('danger', 'Password lama tidak sesuai');
        }

        // Update password in database using the model's allowed fields
        $updateData = [
            'user_password' => $newPassword // This will be auto-hashed by the model's beforeUpdate callback
        ];

        if ($userModel->update($user->user_id, $updateData)) {
            return redirect()->to('admin/profile')->with('success', 'Password berhasil diubah');
        } else {
            return redirect()->back()->with('danger', 'Gagal mengubah password. Silakan coba lagi.');
        }
    }
}
