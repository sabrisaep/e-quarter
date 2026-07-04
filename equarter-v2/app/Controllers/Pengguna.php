<?php

namespace App\Controllers;

use App\Models\KetuaModel;
use App\Models\PenggunaModel;
use CodeIgniter\HTTP\RedirectResponse;

class Pengguna extends BaseController
{
    /**
     * @throws \ReflectionException
     */
    public function kemaskini(): RedirectResponse
    {
        $role = $this->request->getPost('role');
        $id = $this->request->getPost('id');
        $data = [
            'id' => $id,
            'nama_penuh' => $this->request->getPost('nama_penuh'),
            'email' => $this->request->getPost('email'),
        ];

        $penggunaModel = new PenggunaModel();
        $ketuaModel = new KetuaModel();

        // Check if email exists in the opposite table
        $existsInPengguna = $penggunaModel->where('email', $data['email'])->first();
        $existsInKetua = $ketuaModel->where('email', $data['email'])->first();

        if (($role == 'ketua' && $existsInPengguna) || ($role != 'ketua' && $existsInKetua)) {
            return redirect()->back()->with('mesej', [
                'tajuk' => 'Ralat',
                'warna' => 'bg-danger',
                'isi' => 'Emel sudah didaftarkan dalam peranan lain.',
            ]);
        }

        if ($role == 'ketua') {
            $model = $ketuaModel;
        } else {
            $model = $penggunaModel;
        }

        if (!$model->update($id, $data)) {
            return redirect()->back()->with('mesej', [
                'tajuk' => 'Ralat',
                'warna' => 'bg-danger',
                'isi' => 'Gagal mengemaskini data: ' . implode(', ', $model->errors()),
            ]);
        }

        return redirect()->back()->with('mesej', [
            'tajuk' => 'Berjaya',
            'warna' => 'bg-success',
            'isi' => 'Data berjaya dikemaskini.',
        ]);
    }

    /**
     * @throws \ReflectionException
     */
    public function tukarPassword(): RedirectResponse
    {
        $role = $this->request->getPost('role');
        $id = $this->request->getPost('id');
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('mesej', [
                'tajuk' => 'Ralat',
                'warna' => 'bg-danger',
                'isi' => 'Kata laluan baharu dan pengesahan tidak sepadan.',
            ]);
        }

        if ($role == 'ketua') {
            $model = new KetuaModel();
        } else {
            $model = new PenggunaModel();
        }

        $user = $model->asObject()->where('id', $id)->first();
        #dd($user);

        if (!$user || !password_verify($currentPassword, $user->password)) {
            return redirect()->back()->with('mesej', [
                'tajuk' => 'Ralat',
                'warna' => 'bg-danger',
                'isi' => 'Kata laluan semasa adalah salah.',
            ]);
        }

        $data = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
        ];

        if (!$model->update($id, $data)) {
            return redirect()->back()->with('mesej', [
                'tajuk' => 'Ralat',
                'warna' => 'bg-danger',
                'isi' => 'Gagal menukar kata laluan: ' . implode(', ', $model->errors()),
            ]);
        }

        return redirect()->back()->with('mesej', [
            'tajuk' => 'Berjaya',
            'warna' => 'bg-success',
            'isi' => 'Kata laluan berjaya ditukar.',
        ]);
    }
}
