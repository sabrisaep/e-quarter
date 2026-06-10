<?php

namespace App\Controllers;

use App\Models\JabatanModel;
use App\Models\KetuaModel;
use App\Models\MataPelajaranModel;
use App\Models\PenggunaModel;
use App\Models\ProgramModel;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

class Admin extends BaseController
{
    // Helper to get role title
    private function getRoleTitle(string $role): string
    {
        $roleTitles = [
            'kerani' => 'Kerani Kewangan',
            'ketua' => 'Ketua Program / Jabatan',
            'pengurusan' => 'Pihak Pengurusan',
        ];
        return $roleTitles[$role] ?? ucfirst($role);
    }

    public function index(): string
    {
        $penggunaModel = new PenggunaModel();
        $ketuaModel = new KetuaModel();
        $jabatanModel = new JabatanModel();
        $programModel = new ProgramModel();
        $mataPelajaranModel = new MataPelajaranModel();

        $jumlahJabatan = $jabatanModel->countAllResults();
        $jumlahProgram = $programModel->countAllResults();
        $jumlahMataPelajaran = $mataPelajaranModel->countAllResults();

        $jumlahKerani = $penggunaModel->where(['role' => 'kerani', 'status' => 'aktif'])->countAllResults();
        $jumlahPengurusan = $penggunaModel->where(['role' => 'pengurusan', 'status' => 'aktif'])->countAllResults();
        $jumlahKetua = $ketuaModel->where(['status' => 'aktif'])->countAllResults();

        $kerani = $penggunaModel->asObject()->where(['role' => 'kerani', 'status' => 'aktif'])->orderBy('nama_penuh', 'ASC')->findAll();
        $pengurusan = $penggunaModel->asObject()->where(['role' => 'pengurusan', 'status' => 'aktif'])->orderBy('nama_penuh', 'ASC')->findAll();
        $ketua = $ketuaModel->asObject()->where(['status' => 'aktif'])->orderBy('nama_penuh', 'ASC')->findAll();

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'jumlahJabatan' => $jumlahJabatan,
            'jumlahProgram' => $jumlahProgram,
            'jumlahMataPelajaran' => $jumlahMataPelajaran,
            'jumlahKerani' => $jumlahKerani,
            'jumlahKetua' => $jumlahKetua,
            'jumlahPengurusan' => $jumlahPengurusan,
            'kerani' => $kerani,
            'pengurusan' => $pengurusan,
            'ketua' => $ketua,
        ];
        return view('admin/dashboard', $data);
    }

    public function manageUsers(string $role): string
    {
        $penggunaModel = new PenggunaModel();

        $syaratAktif = ['role' => $role, 'status' => 'aktif'];
        $syaratDisekat = ['role' => $role, 'status' => 'sekat'];
        $activeUsers = $penggunaModel->asObject()->where($syaratAktif)->orderBy('nama_penuh', 'ASC')->findAll();
        $blockedUsers = $penggunaModel->asObject()->where($syaratDisekat)->orderBy('nama_penuh', 'ASC')->findAll();

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'role' => $role,
            'roleTitle' => $this->getRoleTitle($role),
            'activeUsers' => $activeUsers,
            'blockedUsers' => $blockedUsers,
        ];
        return view('admin/user_management', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function user_simpan(string $role): RedirectResponse
    {
        $penggunaModel = new PenggunaModel();

        $id = $this->request->getPost('id');
        $data = [
            'nama_penuh' => $this->request->getPost('nama_penuh'),
            'email' => $this->request->getPost('email'),
            'no_kp' => $this->request->getPost('no_kp'),
            'role' => $role,
            'status' => 'aktif'
        ];

        // Jika tiada ID, ini adalah pendaftaran baru, tetapkan kata laluan
        if (!$id) {
            $data['password'] = $this->request->getPost('no_kp');
        }

        $simpan = $id ? $penggunaModel->update($id, $data) : $penggunaModel->insert($data);

        if (!$simpan) {
            return redirect()->back()->withInput()->with('mesej', [
                'tajuk' => 'Ralat Simpan',
                'warna' => 'bg-danger',
                'isi' => 'Gagal menyimpan data. Sila pastikan Email dan No. KP belum didaftarkan.',
            ])->with('errors', $penggunaModel->errors());
        }

        return redirect()->to(base_url('admin/manage/' . $role))->with('mesej', [
            'tajuk' => 'Simpan Data ' . $this->getRoleTitle($role),
            'warna' => 'bg-success',
            'isi' => 'Data ' . strtolower($this->getRoleTitle($role)) . ' berhasil disimpan.',
        ]);
    }

    public function user_padam(string $role, int $id): RedirectResponse
    {
        $penggunaModel = new PenggunaModel();
        $penggunaModel->delete($id);

        return redirect()->to(base_url('admin/manage/' . $role))->with('mesej', [
            'tajuk' => 'Padam Data ' . $this->getRoleTitle($role),
            'warna' => 'bg-danger',
            'isi' => 'Data ' . strtolower($this->getRoleTitle($role)) . ' berhasil dipadam.',
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function user_reset(string $role, int $id): RedirectResponse
    {
        $penggunaModel = new PenggunaModel();
        $pengguna = $penggunaModel->find($id);

        if ($pengguna) {
            $penggunaModel->update($id, [
                'password' => $pengguna['no_kp']
            ]);
        }

        return redirect()->to(base_url('admin/manage/' . $role))->with('mesej', [
            'tajuk' => 'Reset Kata Laluan',
            'warna' => 'bg-info',
            'isi' => 'Kata laluan ' . strtolower($this->getRoleTitle($role)) . ' telah diresetkan kepada No. KP.',
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function user_sekat(string $role, int $id): RedirectResponse
    {
        $penggunaModel = new PenggunaModel();
        $penggunaModel->update($id, ['status' => 'sekat']);

        return redirect()->to(base_url('admin/manage/' . $role))->with('mesej', [
            'tajuk' => 'Sekat Akaun ' . $this->getRoleTitle($role),
            'warna' => 'bg-warning',
            'isi' => 'Akaun ' . strtolower($this->getRoleTitle($role)) . ' telah disekat.',
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function user_aktifkan(string $role, int $id): RedirectResponse
    {
        $penggunaModel = new PenggunaModel();
        $penggunaModel->update($id, ['status' => 'aktif']);

        return redirect()->to(base_url('admin/manage/' . $role))->with('mesej', [
            'tajuk' => 'Aktifkan Akaun ' . $this->getRoleTitle($role),
            'warna' => 'bg-success',
            'isi' => 'Akaun ' . strtolower($this->getRoleTitle($role)) . ' telah diaktifkan semula.',
        ]);
    }

    public function jabatan(): string
    {
        $jabatanModel = new JabatanModel();

        $jabatan = $jabatanModel->asObject()->orderBy('nama_jabatan', 'ASC')->findAll();

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'jabatan' => $jabatan,
        ];
        return view('admin/jabatan', $data);
    }
}