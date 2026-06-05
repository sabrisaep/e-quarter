<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use App\Models\AdminModel;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'mesej' => session()->getFlashdata('mesej'),
        ];
        return view('depan/login', $data);
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

        return redirect()->to('/')->with('mesej', [
            'tajuk' => 'Login Gagal',
            'warna' => 'bg-danger',
            'isi' => 'ID pengguna atau kata laluan salah.',
        ]);
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
