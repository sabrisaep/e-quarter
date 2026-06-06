<?php

namespace App\Controllers;

use App\Models\PenggunaModel;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

class Admin extends BaseController
{
    public function index(): string
    {
        $penggunaModel = new PenggunaModel();

        $jumlahKerani = $penggunaModel->where(['role' => 'kerani', 'status' => 'aktif'])->countAllResults();
        $jumlahKetua = $penggunaModel->where(['role' => 'ketua', 'status' => 'aktif'])->countAllResults();
        $jumlahPengurusan = $penggunaModel->where(['role' => 'pengurusan', 'status' => 'aktif'])->countAllResults();

        $kerani = $penggunaModel->asObject()->where(['role' => 'kerani', 'status' => 'aktif'])->orderBy('nama_penuh', 'ASC')->findAll();
        $ketua = $penggunaModel->asObject()->where(['role' => 'ketua', 'status' => 'aktif'])->orderBy('nama_penuh', 'ASC')->findAll();
        $pengurusan = $penggunaModel->asObject()->where(['role' => 'pengurusan', 'status' => 'aktif'])->orderBy('nama_penuh', 'ASC')->findAll();

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'jumlahKerani' => $jumlahKerani,
            'jumlahKetua' => $jumlahKetua,
            'jumlahPengurusan' => $jumlahPengurusan,
            'kerani' => $kerani,
            'ketua' => $ketua,
            'pengurusan' => $pengurusan,
        ];
        return view('admin/dashboard', $data);
    }

    public function kerani(): string
    {
        $keraniModel = new PenggunaModel();

        $syaratAktif = ['role' => 'kerani', 'status' => 'aktif'];
        $syaratDisekat = ['role' => 'kerani', 'status' => 'sekat'];
        $keraniAktif = $keraniModel->asObject()->where($syaratAktif)->orderBy('nama_penuh', 'ASC')->findAll();
        $keraniDisekat = $keraniModel->asObject()->where($syaratDisekat)->orderBy('nama_penuh', 'ASC')->findAll();

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'keraniAktif' => $keraniAktif,
            'keraniDisekat' => $keraniDisekat,
        ];
        return view('admin/kerani', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function kerani_simpan(): RedirectResponse
    {
        $penggunaModel = new PenggunaModel();

        $id = $this->request->getPost('id');
        $data = [
            'nama_penuh' => $this->request->getPost('nama_penuh'),
            'email'      => $this->request->getPost('email'),
            'no_kp'      => $this->request->getPost('no_kp'),
            'role'       => 'kerani',
            'status'     => 'aktif'
        ];

        // Jika tiada ID, ini adalah pendaftaran baru, tetapkan kata laluan
        if (!$id) {
            $data['password'] = $this->request->getPost('no_kp');
        }

        // Gunakan save() untuk mengendalikan insert/update secara automatik
        // atau semak hasil pulangan insert/update
        $simpan = $id ? $penggunaModel->update($id, $data) : $penggunaModel->insert($data);

        if (!$simpan) {
            return redirect()->back()->withInput()->with('mesej', [
                'tajuk' => 'Ralat Simpan',
                'warna' => 'bg-danger',
                'isi'   => 'Gagal menyimpan data. Sila pastikan Email dan No. KP belum didaftarkan.',
            ])->with('errors', $penggunaModel->errors());
        }

        return redirect()->to(base_url('admin/kerani'))->with('mesej', [
            'tajuk' => 'Simpan Data Kerani',
            'warna' => 'bg-success',
            'isi' => 'Data kerani berhasil disimpan.',
        ]);
    }

    public function kerani_padam(int $id): RedirectResponse
    {
        $penggunaModel = new PenggunaModel();
        $penggunaModel->delete($id);

        return redirect()->to(base_url('admin/kerani'))->with('mesej', [
            'tajuk' => 'Padam Data Kerani',
            'warna' => 'bg-danger',
            'isi' => 'Data kerani berhasil dipadam.',
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function kerani_reset(int $id): RedirectResponse
    {
        $penggunaModel = new PenggunaModel();
        $pengguna = $penggunaModel->find($id);

        if ($pengguna) {
            $penggunaModel->update($id, [
                'password' => $pengguna['no_kp']
            ]);
        }

        return redirect()->to(base_url('admin/kerani'))->with('mesej', [
            'tajuk' => 'Reset Kata Laluan',
            'warna' => 'bg-info',
            'isi' => 'Kata laluan kerani telah diresetkan kepada No. KP.',
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function kerani_sekat(int $id): RedirectResponse
    {
        $penggunaModel = new PenggunaModel();
        $penggunaModel->update($id, ['status' => 'sekat']);

        return redirect()->to(base_url('admin/kerani'))->with('mesej', [
            'tajuk' => 'Sekat Akaun Kerani',
            'warna' => 'bg-warning',
            'isi' => 'Akaun kerani telah disekat.',
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function kerani_aktifkan(int $id): RedirectResponse
    {
        $penggunaModel = new PenggunaModel();
        $penggunaModel->update($id, ['status' => 'aktif']);

        return redirect()->to(base_url('admin/kerani'))->with('mesej', [
            'tajuk' => 'Aktifkan Akaun Kerani',
            'warna' => 'bg-success',
            'isi' => 'Akaun kerani telah diaktifkan semula.',
        ]);
    }
}
