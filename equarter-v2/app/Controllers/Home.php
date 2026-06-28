<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use App\Models\AdminModel;
use App\Models\KetuaModel;
use App\Models\PenggunaModel;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'mesej' => session()->getFlashdata('mesej'),
        ];
        return view('depan/login', $data);
    }

    /**
     * @throws \ReflectionException
     */
    public function login(): RedirectResponse
    {
        $model = new AdminModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->asObject()->where('username', $username)->first();

        if ($user && password_verify($password, $user->password)) {
            session()->set([
                'id'         => $user->id,
                'isLoggedIn' => true,
                'username'   => $user->username,
                'role'       => 'admin'
            ]);
            return redirect()->to('admin');
        }

        // Cuba Ketua
        $ketuaModel = new KetuaModel();
        $ketua = $ketuaModel->asObject()->where('no_kp', $username)->first();

        if ($ketua && password_verify($password, $ketua->password)) {
            if ($ketua->status === 'sekat') {
                return redirect()->to('/')->with('mesej', [
                    'tajuk' => 'Akses Disekat',
                    'warna' => 'bg-warning',
                    'isi' => 'Akaun anda telah disekat. Sila hubungi pentadbir.',
                ]);
            }
            session()->set([
                'id'         => $ketua->id,
                'isLoggedIn' => true,
                'username'   => $ketua->nama_penuh,
                'role'       => 'ketua'
            ]);
            $ketuaModel->update($ketua->id, ['last_login' => date('Y-m-d H:i:s')]);
            return redirect()->to('ketua');
        }

        // Cuba Pengguna (Kerani/Pengurusan)
        $penggunaModel = new PenggunaModel();
        $pengguna = $penggunaModel->asObject()->where('no_kp', $username)->first();

        if ($pengguna && password_verify($password, $pengguna->password)) {
            if ($pengguna->status === 'sekat') {
                return redirect()->to('/')->with('mesej', [
                    'tajuk' => 'Akses Disekat',
                    'warna' => 'bg-warning',
                    'isi' => 'Akaun anda telah disekat. Sila hubungi pentadbir e-Quarter.',
                ]);
            }
            session()->set([
                'id'         => $pengguna->id,
                'isLoggedIn' => true,
                'username'   => $pengguna->nama_penuh,
                'role'       => $pengguna->role
            ]);
            $penggunaModel->update($pengguna->id, ['last_login' => date('Y-m-d H:i:s')]);
            return redirect()->to($pengguna->role);
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
