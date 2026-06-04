<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index(): string
    {
        # sementara saja, utk tujuan pengujian
        session()->setFlashdata('mesej', [
            'tajuk' => 'Selamat Datang',
            'isi' => 'Anda telah berjaya log masuk sebagai admin',
        ]);

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
        ];
        return view('admin/dashboard', $data);
    }
}
