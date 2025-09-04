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
        $model = new UserModel();
        $username = $this->request->getPost('user_email');
        $password = $this->request->getPost('user_password');
        $user = $model->getLoginData($username);
        // dd($user->user_password);
        if ($user == null) {
            return redirect()->to(previous_url())
                ->with('danger', 'Username tidak ditemukan!');
        }

        if (!password_verify($password, $user->user_password)) {
            return redirect()->to(previous_url())
                ->with('danger', 'Password Salah!');
        }


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
