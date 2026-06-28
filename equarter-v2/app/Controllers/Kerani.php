<?php

namespace App\Controllers;

use App\Models\PenggunaModel;
use CodeIgniter\HTTP\RedirectResponse;

class Kerani extends BaseController
{
    private function pengguna(): object
    {
        return (new PenggunaModel())->asObject()->find(session()->get('id'));
    }

    public function index(): RedirectResponse
    {
        return redirect()->to('kerani/sukuan');
    }

    public function sukuan(): string
    {
        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'pengguna' => $this->pengguna(),
        ];
        return view('kerani/sukuan', $data);
    }

    public function subsidiari(): string
    {
        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'pengguna' => $this->pengguna(),
        ];
        return view('kerani/subsidiari', $data);
    }

    public function profil(): string
    {
        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'pengguna' => $this->pengguna(),
        ];
        return view('kerani/profil', $data);
    }
}
