<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PakarModel;
use App\Models\PetaniModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->has('user')) {
            return redirect()->to(session()->get('user')->user_type);
        }
        return view('login', ['title' => 'Login']);
    }

    public function login()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        // Rate limiting check (basic implementation)
        $clientIP = $this->request->getIPAddress();
        $cacheKey = 'login_attempts_' . md5($clientIP);
        $cache = \Config\Services::cache();

        $attempts = $cache->get($cacheKey) ?? 0;
        if ($attempts >= 5) {
            return redirect()->back()->with('danger', 'Terlalu banyak percobaan login. Coba lagi dalam 15 menit.');
        }

        // Validate and sanitize input
        $username = trim($this->request->getPost('user_email'));
        $password = $this->request->getPost('user_password');

        // Basic validation
        if (empty($username) || empty($password)) {
            $cache->save($cacheKey, $attempts + 1, 900); // 15 minutes
            return redirect()->to(previous_url())
                ->with('danger', 'Username dan password harus diisi!');
        }

        // Validate email format
        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $cache->save($cacheKey, $attempts + 1, 900);
            return redirect()->to(previous_url())
                ->with('danger', 'Format email tidak valid!');
        }

        $model = new UserModel();
        $user = $model->getLoginData($username);

        if ($user == null) {
            $cache->save($cacheKey, $attempts + 1, 900);
            return redirect()->to(previous_url())
                ->with('danger', 'Username tidak ditemukan!');
        }

        if (!password_verify($password, $user->user_password)) {
            $cache->save($cacheKey, $attempts + 1, 900);
            return redirect()->to(previous_url())
                ->with('danger', 'Password Salah!');
        }

        // Clear login attempts on successful login
        $cache->delete($cacheKey);


        switch ($user->user_type) {
            case 'admin':
                $data = [
                    'user' => $user,
                    'admin_logged_in' => 1,
                ];
                session()->set($data);
                return redirect()->to('admin');
                break;
            default:
                return redirect()->to('/');
                break;
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('auth');
    }

    public function signup()
    {
        $data['title'] = 'Registrasi Petani';
        return view('signup_petani', $data);
    }
}
