<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use App\Models\AdminModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('depan/login');
    }

    public function login(): RedirectResponse
    {
        $model = new AdminModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->asObject()->where('username', $username)->first();

        if ($user && password_verify($password, $user->password)) {
            session()->set([
                'isLoggedIn' => true,
                'username'   => $user->username,
                'role'       => 'admin'
            ]);
            return redirect()->to('admin');
        }

        return redirect()->to('/')->with('error', 'Username atau password salah.');
    }
}
