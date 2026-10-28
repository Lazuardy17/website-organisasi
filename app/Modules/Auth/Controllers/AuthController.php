<?php

namespace App\Modules\Auth\Controllers;

use App\Controllers\BaseController;
use App\Modules\Auth\Models\UserModel;

class AuthController extends BaseController
{
    /** Batas percobaan gagal sebelum akun dikunci. */
    private const MAKS_GAGAL = 5;

    /** Lama cooldown dalam detik (900 = 15 menit). */
    private const DURASI_KUNCI = 900;

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Cek apakah user sudah lengkapi identitas.
     * Pakai session — konsisten & cepat.
     */
    private function cekIdentitasLengkap()
    {
        return (bool) session()->get('identitas_lengkap');
    }

    public function login()
    {
        if (session()->get('is_logged_in')) {
            if (session()->get('peran_id') == 1) {
                return redirect()->to('/admin/dashboard');
            } else {
                $db  = \Config\Database::connect();
                $opd = $db->table('perangkat_daerah')
                    ->where('id', session()->get('opd_id'))
                    ->get()->getRowArray();

                // SET SESSION
                session()->set('identitas_lengkap', !empty($opd['identitas_lengkap']));

                if ($opd && empty($opd['identitas_lengkap'])) {
                    return redirect()->to('/opd/identitas');
                }

                return redirect()->to('/opd/dashboard');
            }
        }

        return view('App\Modules\Auth\Views\login');
    }

    public function attemptLogin()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->to('/')
                ->with('error', 'Username dan password wajib diisi.')
                ->with('username', $username);
        }

        $kunci = strtolower($username);
        $ip    = $this->request->getIPAddress();

        // 1. Sedang dalam masa cooldown?
        $sisaDetik = $this->sisaKunci($kunci, $ip);
        if ($sisaDetik > 0) {
            return redirect()->to('/')
                ->with('error', 'Terlalu banyak percobaan gagal. Coba lagi dalam ' . ceil($sisaDetik / 60) . ' menit.')
                ->with('username', $username);
        }

        // 2. Verifikasi kredensial.
        //    Username yang tidak ada juga dihitung sebagai percobaan gagal,
        //    dan pesannya sengaja sama agar username valid tidak bisa ditebak.
        $user = $this->userModel->findByUsername($username);

        if (!$user || !password_verify($password, $user['hash_kata_sandi'])) {
            $sisa = $this->catatGagal($kunci, $ip);

            $pesan = $sisa > 0
                ? 'Username atau password salah.'
                : 'Terlalu banyak percobaan gagal. Coba lagi dalam ' . (self::DURASI_KUNCI / 60) . ' menit.';

            return redirect()->to('/')
                ->with('error', $pesan)
                ->with('username', $username);
        }

        // 3. Berhasil: reset hitungan & ganti ID session (cegah session fixation)
        $this->resetPercobaan($kunci, $ip);
        session()->regenerate();

        // Set session dasar
        session()->set([
            'is_logged_in' => true,
            'user_id'      => $user['id'],
            'username'     => $user['nama_pengguna'],
            'peran_id'     => $user['peran_id'],
            'opd_id'       => $user['opd_id'],
        ]);

        // Set session identitas_lengkap
        if ($user['peran_id'] == 1) {
            session()->set('identitas_lengkap', true);
        } else {
            $db  = \Config\Database::connect();
            $opd = $db->table('perangkat_daerah')
                ->where('id', $user['opd_id'])
                ->get()->getRowArray();

            session()->set('identitas_lengkap', !empty($opd['identitas_lengkap']));
        }

        $this->userModel->update($user['id'], [
            'login_terakhir_pada' => date('Y-m-d H:i:s'),
        ]);

        // Redirect
        if ($user['peran_id'] == 1) {
            return redirect()->to('/admin/dashboard');
        } else {
            if (!session()->get('identitas_lengkap')) {
                return redirect()->to('/opd/identitas');
            }
            return redirect()->to('/opd/dashboard');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    /* =========================================================
     * PEMBATASAN PERCOBAAN LOGIN
     * Tabel: percobaan_login
     * ========================================================= */

    /**
     * Sisa detik masa cooldown. 0 = tidak sedang dikunci.
     */
    private function sisaKunci(string $kunci, string $ip): int
    {
        $row = \Config\Database::connect()->table('percobaan_login')
            ->where('nama_pengguna', $kunci)
            ->where('alamat_ip', $ip)
            ->get()->getRowArray();

        if (!$row || empty($row['terkunci_sampai'])) {
            return 0;
        }

        return max(0, strtotime($row['terkunci_sampai']) - time());
    }

    /**
     * Catat satu percobaan gagal.
     * Mengembalikan sisa percobaan (0 = baru saja terkunci).
     */
    private function catatGagal(string $kunci, string $ip): int
    {
        $db  = \Config\Database::connect();
        $now = date('Y-m-d H:i:s');

        $row = $db->table('percobaan_login')
            ->where('nama_pengguna', $kunci)
            ->where('alamat_ip', $ip)
            ->get()->getRowArray();

        $jumlah      = ($row ? (int) $row['jumlah_gagal'] : 0) + 1;
        $kunciSampai = null;

        if ($jumlah >= self::MAKS_GAGAL) {
            $kunciSampai = date('Y-m-d H:i:s', time() + self::DURASI_KUNCI);
            $jumlah      = 0; // setelah cooldown, hitungan mulai dari 0 lagi
        }

        $data = [
            'jumlah_gagal'       => $jumlah,
            'terkunci_sampai'    => $kunciSampai,
            'percobaan_terakhir' => $now,
        ];

        if ($row) {
            $db->table('percobaan_login')->where('id', $row['id'])->update($data);
        } else {
            $db->table('percobaan_login')->insert($data + [
                'nama_pengguna' => $kunci,
                'alamat_ip'     => $ip,
            ]);
        }

        return $kunciSampai ? 0 : self::MAKS_GAGAL - $jumlah;
    }

    /**
     * Hapus catatan percobaan setelah login berhasil.
     */
    private function resetPercobaan(string $kunci, string $ip): void
    {
        \Config\Database::connect()->table('percobaan_login')
            ->where('nama_pengguna', $kunci)
            ->where('alamat_ip', $ip)
            ->delete();
    }

    /* =========================================================
     * UBAH PASSWORD
     * ========================================================= */

    public function ubahPassword()
    {
        if (!$this->cekIdentitasLengkap()) {
            return redirect()->to('/opd/identitas')->with('error', 'Lengkapi identitas terlebih dahulu.');
        }

        $data = [
            'title' => 'Ubah Password',
        ];

        return view('App\Modules\Auth\Views\ubah_password', $data);
    }

    public function simpanPassword()
    {
        if (!$this->cekIdentitasLengkap()) {
            return redirect()->to('/opd/identitas')->with('error', 'Lengkapi identitas terlebih dahulu.');
        }

        $userId       = session()->get('user_id');
        $passwordLama = $this->request->getPost('password_lama');
        $passwordBaru = $this->request->getPost('password_baru');
        $konfirmasi   = $this->request->getPost('konfirmasi');

        if (empty($passwordLama) || empty($passwordBaru) || empty($konfirmasi)) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.');
        }

        if (strlen($passwordBaru) < 8) {
            return redirect()->back()->with('error', 'Password baru minimal 8 karakter.');
        }

        if ($passwordBaru !== $konfirmasi) {
            return redirect()->back()->with('error', 'Password baru dan konfirmasi tidak sama.');
        }

        $user = $this->userModel->find($userId);

        if (!$user || !password_verify($passwordLama, $user['hash_kata_sandi'])) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        $this->userModel->update($userId, [
            'hash_kata_sandi' => password_hash($passwordBaru, PASSWORD_DEFAULT),
            'diperbarui_pada' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/ubah-password')->with('success', 'Password berhasil diubah.');
    }
}