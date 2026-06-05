<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index(): string
    {
        $data = [
            'mesej' => session()->getFlashdata('mesej'),
        ];
        return view('admin/dashboard', $data);
    }


}
