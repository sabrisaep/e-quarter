<?php

namespace App\Controllers;

use App\Models\PenggunaModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RedirectResponse;

class Pengurusan extends BaseController
{
    private function pengguna(): object
    {
        return (new PenggunaModel())->asObject()->find(session()->get('id'));
    }

    public function index(): RedirectResponse
    {
        return redirect()->to('pengurusan/perbelanjaan');
    }

    public function perbelanjaan(): string
    {
        $data = [
            'mesej' => session()->get('mesej'),
            'pengguna' => $this->pengguna(),
        ];
        return view('pengurusan/perbelanjaan', $data);
    }

    public function subsidiari(): string
    {
        $data = [
            'mesej' => session()->get('mesej'),
            'pengguna' => $this->pengguna(),
        ];
        return view('pengurusan/subsidiari', $data);
    }

    public function analisis(): string
    {
        $data = [
            'mesej' => session()->get('mesej'),
            'pengguna' => $this->pengguna(),
        ];
        return view('pengurusan/analisis', $data);
    }

    public function profil(): string
    {
        $data = [
            'mesej' => session()->get('mesej'),
            'pengguna' => $this->pengguna(),
        ];
        return view('pengurusan/profil', $data);
    }
}
