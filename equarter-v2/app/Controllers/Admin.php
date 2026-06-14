<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\JabatanModel;
use App\Models\KetuaModel;
use App\Models\MataPelajaranModel;
use App\Models\PenggunaModel;
use App\Models\ProgramModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
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
            'id' => $id,
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

        // Pastikan email atau no_kp belum wujud dalam table ketua
        $ketuaModel = new KetuaModel();
        $wujudKetua = $ketuaModel->groupStart()
            ->where('email', $data['email'])
            ->orWhere('no_kp', $data['no_kp'])
            ->groupEnd()
            ->first();

        if ($wujudKetua) {
            return redirect()->back()->withInput()->with('mesej', [
                'tajuk' => 'Ralat Simpan',
                'warna' => 'bg-danger',
                'isi' => 'Gagal menyimpan. Email atau No. KP telah didaftarkan dalam senarai Ketua.',
            ]);
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
                'password' => password_hash($pengguna['no_kp'], PASSWORD_DEFAULT)
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
        $ketuaModel = new KetuaModel();
        $programModel = new ProgramModel();

        $jabatan = $jabatanModel->asObject()->orderBy('nama_jabatan', 'ASC')->findAll();

        foreach ($jabatan as $j) {
            $j->ketua = $ketuaModel->where('jabatan_id', $j->id)->countAllResults();
            $j->bilangan_program = $programModel->where('jabatan_id', $j->id)->countAllResults();
        }

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'jabatan' => $jabatan,
        ];
        return view('admin/jabatan', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function jabatan_simpan(): RedirectResponse
    {
        $jabatanModel = new JabatanModel();

        $id = $this->request->getPost('id');
        $data = [
            'id' => $id,
            'nama_jabatan' => strtoupper(trim($this->request->getPost('nama_jabatan'))),
        ];

        $simpan = $id ? $jabatanModel->update($id, $data) : $jabatanModel->insert($data);

        if (!$simpan) {
            return redirect()->back()->withInput()->with('mesej', [
                'tajuk' => 'Ralat Simpan',
                'warna' => 'bg-danger',
                'isi' => 'Gagal menyimpan data jabatan. Sila pastikan nama jabatan tidak bertindih.',
            ]);
        }

        return redirect()->to(base_url('admin/jabatan'))->with('mesej', [
            'tajuk' => 'Simpan Data Jabatan',
            'warna' => 'bg-success',
            'isi' => 'Data jabatan berhasil disimpan.',
        ]);
    }

    public function jabatan_padam(int $id): RedirectResponse
    {
        $jabatanModel = new JabatanModel();
        $jabatanModel->delete($id);

        return redirect()->to(base_url('admin/jabatan'))->with('mesej', [
            'tajuk' => 'Padam Data Jabatan',
            'warna' => 'bg-danger',
            'isi' => 'Data jabatan berhasil dipadam.',
        ]);
    }

    public function ketua(): string
    {
        $jabatanModel = new JabatanModel();
        $ketuaModel = new KetuaModel();

        $jabatan = $jabatanModel->asObject()->orderBy('nama_jabatan', 'ASC')->findAll();

        foreach ($jabatan as $j) {
            $j->ketua_aktif = $ketuaModel->asObject()->where(['jabatan_id' => $j->id, 'status' => 'aktif'])->orderBy('nama_penuh', 'ASC')->findAll();
            $j->ketua_sekat = $ketuaModel->asObject()->where(['jabatan_id' => $j->id, 'status' => 'sekat'])->orderBy('nama_penuh', 'ASC')->findAll();
        }

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'jabatan' => $jabatan,
        ];
        return view('admin/ketua', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function ketua_simpan(): RedirectResponse
    {
        $ketuaModel = new KetuaModel();
        $id = $this->request->getPost('id');
        $data = [
            'id' => $id,
            'nama_penuh' => $this->request->getPost('nama_penuh'),
            'email' => $this->request->getPost('email'),
            'no_kp' => $this->request->getPost('no_kp'),
            'jabatan_id' => $this->request->getPost('jabatan_id'),
            'status' => 'aktif'
        ];

        if (!$id) {
            $data['password'] = $this->request->getPost('no_kp');
        }

        // Pastikan email atau no_kp belum wujud dalam table ketua jika ini adalah ketua baru
        $queryKetua = $ketuaModel->groupStart()
            ->where('email', $data['email'])
            ->orWhere('no_kp', $data['no_kp'])
            ->groupEnd();
        if ($id) $queryKetua->where('id !=', $id);
        $wujudKetua = $queryKetua->first();

        if ($wujudKetua) {
            return redirect()->back()->withInput()->with('mesej', [
                'tajuk' => 'Ralat Simpan',
                'warna' => 'bg-danger',
                'isi' => 'Gagal menyimpan. Email atau No. KP telah didaftarkan dalam senarai Ketua.',
            ]);
        }

        // Pastikan no_kp & email tidak wujud dalam table pengguna
        $penggunaModel = new PenggunaModel();
        $wujud = $penggunaModel->groupStart()
            ->where('email', $data['email'])
            ->orWhere('no_kp', $data['no_kp'])
            ->groupEnd()
            ->first();

        if ($wujud) {
            return redirect()->back()->withInput()->with('mesej', [
                'tajuk' => 'Ralat Simpan',
                'warna' => 'bg-danger',
                'isi' => 'Gagal menyimpan. Email atau No. KP telah didaftarkan sebagai Kerani atau Pengurusan.',
            ]);
        }

        $simpan = $id ? $ketuaModel->update($id, $data) : $ketuaModel->insert($data);

        if (!$simpan) {
            return redirect()->back()->withInput()->with('mesej', [
                'tajuk' => 'Ralat Simpan',
                'warna' => 'bg-danger',
                'isi' => 'Gagal menyimpan data Ketua. Sila pastikan email dan nombor kad pengenalan belum didaftarkan.',
            ])->with('errors', $ketuaModel->errors());
        }

        return redirect()->to(base_url('admin/ketua'))->with('mesej', [
            'tajuk' => 'Simpan Data Ketua',
            'warna' => 'bg-success',
            'isi' => 'Data ketua program / jabatan berhasil disimpan.',
        ]);
    }

    public function ketua_padam(int $id): RedirectResponse
    {
        $ketuaModel = new KetuaModel();
        $ketuaModel->delete($id);

        return redirect()->to(base_url('admin/ketua'))->with('mesej', [
            'tajuk' => 'Padam Data Ketua',
            'warna' => 'bg-danger',
            'isi' => 'Data ketua program / jabatan berhasil dipadam.',
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function ketua_reset(int $id): RedirectResponse
    {
        $ketuaModel = new KetuaModel();
        $ketua = $ketuaModel->find($id);

        # password kena hash dulu
        if ($ketua) {
            $ketuaModel->update($id, [
                'password' => password_hash($ketua['no_kp'], PASSWORD_DEFAULT)
            ]);
        }

        return redirect()->to(base_url('admin/ketua'))->with('mesej', [
            'tajuk' => 'Reset Kata Laluan',
            'warna' => 'bg-info',
            'isi' => 'Kata laluan ketua telah diresetkan kepada No. KP.',
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function ketua_sekat(int $id): RedirectResponse
    {
        $ketuaModel = new KetuaModel();
        $ketuaModel->update($id, ['status' => 'sekat']);

        return redirect()->to(base_url('admin/ketua'))->with('mesej', [
            'tajuk' => 'Sekat Akaun Ketua',
            'warna' => 'bg-warning',
            'isi' => 'Akaun ketua program / jabatan telah disekat.',
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function ketua_aktifkan(int $id): RedirectResponse
    {
        $ketuaModel = new KetuaModel();
        $ketuaModel->update($id, ['status' => 'aktif']);

        return redirect()->to(base_url('admin/ketua'))->with('mesej', [
            'tajuk' => 'Aktifkan Akaun Ketua',
            'warna' => 'bg-success',
            'isi' => 'Akaun ketua program / jabatan telah diaktifkan semula.',
        ]);
    }

    public function program(): string
    {
        $jabatanModel = new JabatanModel();
        $programModel = new ProgramModel();
        $mataPelajaranModel = new MataPelajaranModel();

        $jabatan = $jabatanModel->asObject()->orderBy('nama_jabatan', 'ASC')->findAll();

        foreach ($jabatan as $j) {
            $j->program = $programModel->asObject()->where(['jabatan_id' => $j->id])->orderBy('nama_program', 'ASC')->findAll();
            foreach ($j->program as $p) {
                $p->bilangan_mata_pelajaran = $mataPelajaranModel->where(['program_id' => $p->id])->countAllResults();
            }
        }

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'jabatan' => $jabatan,
        ];
        return view('admin/program', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function program_simpan(): RedirectResponse
    {
        $programModel = new ProgramModel();
        $id = $this->request->getPost('id');
        $data = [
            'id' => $id,
            'nama_program' => strtoupper(trim($this->request->getPost('nama_program'))),
            'jabatan_id' => $this->request->getPost('jabatan_id'),
        ];

        $simpan = $id ? $programModel->update($id, $data) : $programModel->insert($data);

        if (!$simpan) {
            return redirect()->back()->withInput()->with('mesej', [
                'tajuk' => 'Ralat Simpan',
                'warna' => 'bg-danger',
                'isi' => 'Gagal menyimpan data program. Sila pastikan nama program tidak bertindih.',
            ]);
        }

        return redirect()->to(base_url('admin/program'))->with('mesej', [
            'tajuk' => 'Simpan Data Program',
            'warna' => 'bg-success',
            'isi' => 'Data program berhasil disimpan.',
        ]);
    }

    public function program_padam(int $id): RedirectResponse
    {
        $programModel = new ProgramModel();
        $programModel->delete($id);

        return redirect()->to(base_url('admin/program'))->with('mesej', [
            'tajuk' => 'Padam Data Program',
            'warna' => 'bg-danger',
            'isi' => 'Data program berhasil dipadam.',
        ]);
    }

    public function mata_pelajaran(): string
    {
        $jabatanModel = new JabatanModel();
        $programModel = new ProgramModel();
        $mataPelajaranModel = new MataPelajaranModel();

        $selectedJabatan = $this->request->getGet('jabatan_id');
        $selectedProgram = $this->request->getGet('program_id');

        $jabatan = $jabatanModel->asObject()->orderBy('nama_jabatan', 'ASC')->findAll();
        $programs = [];
        $subjects = [];

        if ($selectedJabatan) {
            $programs = $programModel->asObject()->where('jabatan_id', $selectedJabatan)->orderBy('nama_program', 'ASC')->findAll();
        }

        if ($selectedProgram) {
            $subjects = $mataPelajaranModel->asObject()->where('program_id', $selectedProgram)->orderBy('nama_mp', 'ASC')->findAll();
        }

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'jabatan' => $jabatan,
            'programs' => $programs,
            'subjects' => $subjects,
            'selectedJabatan' => $selectedJabatan,
            'selectedProgram' => $selectedProgram,
        ];
        return view('admin/mata_pelajaran', $data);
    }

    public function mata_pelajaran_semua(): string
    {
        $jabatanModel = new JabatanModel();
        $programModel = new ProgramModel();
        $mataPelajaranModel = new MataPelajaranModel();

        $jabatan = $jabatanModel->asObject()->orderBy('nama_jabatan', 'ASC')->findAll();
        foreach ($jabatan as $j) {
            $j->program = $programModel->asObject()->where('jabatan_id', $j->id)->orderBy('nama_program', 'ASC')->findAll();
            foreach ($j->program as $p) {
                $p->mata_pelajaran = $mataPelajaranModel->asObject()->where('program_id', $p->id)->orderBy('nama_mp', 'ASC')->findAll();
            }
        }

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'jabatan' => $jabatan,
        ];
        return view('admin/mata_pelajaran_semua', $data);
    }

    /**
     * @param int $jabatan_id
     * @return ResponseInterface
     */
    public function getProgramByJabatan(int $jabatan_id): ResponseInterface
    {
        $programModel = new ProgramModel();
        $programs = $programModel->where('jabatan_id', $jabatan_id)->orderBy('nama_program', 'ASC')->findAll();
        return $this->response->setJSON($programs);
    }

    public function getMataPelajaranByProgram(int $program_id): ResponseInterface
    {
        $mataPelajaranModel = new MataPelajaranModel();
        $subjects = $mataPelajaranModel->where('program_id', $program_id)->orderBy('nama_mp', 'ASC')->findAll();
        return $this->response->setJSON($subjects);
    }

    /**
     * @throws ReflectionException
     */
    public function mata_pelajaran_simpan(): RedirectResponse
    {
        $mataPelajaranModel = new MataPelajaranModel();
        $id = $this->request->getPost('id');
        $jabatan_id = $this->request->getPost('jabatan_id');
        $data = [
            'id' => $id,
            'program_id' => $this->request->getPost('program_id'),
            'nama_mp' => strtoupper(trim($this->request->getPost('nama_mp'))),
        ];

        $simpan = $id ? $mataPelajaranModel->update($id, $data) : $mataPelajaranModel->insert($data);

        if (!$simpan) {
            return redirect()->back()->withInput()->with('mesej', [
                'tajuk' => 'Ralat Simpan',
                'warna' => 'bg-danger',
                'isi' => 'Gagal menyimpan data mata pelajaran. Sila pastikan kod mata pelajaran tidak bertindih.',
            ]);
        }

        return redirect()->to(base_url("admin/mata_pelajaran?jabatan_id=$jabatan_id&program_id={$data['program_id']}"))->with('mesej', [
            'tajuk' => 'Simpan Data Mata Pelajaran',
            'warna' => 'bg-success',
            'isi' => 'Data mata pelajaran berhasil disimpan.',
        ]);
    }

    public function mata_pelajaran_padam(int $id): RedirectResponse
    {
        $mataPelajaranModel = new MataPelajaranModel();
        $mataPelajaranModel->delete($id);

        return redirect()->to(base_url('admin/mata_pelajaran'))->with('mesej', [
            'tajuk' => 'Padam Data Mata Pelajaran',
            'warna' => 'bg-danger',
            'isi' => 'Data mata pelajaran berhasil dipadam.',
        ]);
    }

    public function kata_laluan(): string
    {
        $adminModel = new AdminModel();
        $admin = $adminModel->asObject()->where('id', session()->get('id'))->first();

        $data = [
            'mesej' => session()->getFlashdata('mesej'),
            'admin' => $admin,
        ];
        return view('admin/kata_laluan', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function kata_laluan_simpan(): RedirectResponse
    {
        $adminModel = new AdminModel();
        $id = session()->get('id');
        $old_password = $this->request->getPost('kata_laluan_lama');
        $new_password = $this->request->getPost('kata_laluan_baru');
        $password_confirm = $this->request->getPost('sahkan_kata_laluan');

        if ($new_password !== $password_confirm) {
            return redirect()->back()->with('mesej', [
                'tajuk' => 'Ralat',
                'warna' => 'bg-danger',
                'isi' => 'Kata laluan dan pengesahan kata laluan tidak sepadan.',
            ]);
        }

        $admin = $adminModel->asObject()->find($id);

        if (!$admin || !password_verify($old_password, $admin->password)) {
            return redirect()->back()->with('mesej', [
                'tajuk' => 'Ralat',
                'warna' => 'bg-danger',
                'isi' => 'Kata laluan lama tidak tepat.',
            ]);
        }

        $simpan = $adminModel->update($id, ['password' => password_hash($new_password, PASSWORD_DEFAULT)]);

        if (!$simpan) {
            return redirect()->back()->with('mesej', [
                'tajuk' => 'Ralat',
                'warna' => 'bg-danger',
                'isi' => 'Gagal mengemaskini kata laluan.',
            ]);
        }

        return redirect()->to(base_url('admin/kata_laluan'))->with('mesej', [
            'tajuk' => 'Berjaya',
            'warna' => 'bg-success',
            'isi' => 'Kata laluan berjaya dikemaskini.',
        ]);
    }
}
