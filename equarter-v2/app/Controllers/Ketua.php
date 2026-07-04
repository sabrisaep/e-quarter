<?php

namespace App\Controllers;

use App\Models\KetuaModel;
use App\Models\PenggunaModel;
use CodeIgniter\HTTP\RedirectResponse;

class Ketua extends BaseController
{
    private function pengguna(): object
    {
        return (new KetuaModel())->asObject()->find(session()->get('id'));
    }

    public function index(): RedirectResponse
    {
        return redirect()->to('/ketua/kategori');
    }

    public function kategori(): string
    {
        $data = [
            'mesej' => session()->get('mesej'),
            'pengguna' => $this->pengguna(),
        ];
        return view('ketua/kategori', $data);
    }

    public function sukuan(): string
    {
        $data = [
            'mesej' => session()->get('mesej'),
            'pengguna' => $this->pengguna(),
        ];
        return view('ketua/sukuan', $data);
    }

    public function nota_minta(): string
    {
        $data = [
            'mesej' => session()->get('mesej'),
            'pengguna' => $this->pengguna(),
        ];
        return view('ketua/nota_minta', $data);
    }

    public function profil(): string
    {
        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'pengguna' => $this->pengguna(),
        ];
        return view('pengguna/profil', $data);
    }
}
