<?php

namespace App\Modules\Auth\Controllers;

use App\Controllers\BaseController;
use App\Modules\Auth\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        // Kalau sudah login, arahkan ke dashboard
        if (session()->get('is_logged_in')) {
            if (session()->get('peran_id') == 1) {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/opd/dashboard');
            }
        }

        // Kalau belum login, arahkan ke landing page
        return redirect()->to('/');
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan password wajib diisi.');
        }

        $user = $this->userModel->findByUsername($username);

        if (!$user) {
            return redirect()->back()->with('error', 'Username atau password salah.');
        }

        if (!password_verify($password, $user['hash_kata_sandi'])) {
            return redirect()->back()->with('error', 'Username atau password salah.');
        }

        session()->set([
            'is_logged_in' => true,
            'user_id'      => $user['id'],
            'username'     => $user['nama_pengguna'],
            'peran_id'     => $user['peran_id'],
            'opd_id'       => $user['opd_id'],
        ]);

        $this->userModel->update($user['id'], [
            'login_terakhir_pada' => date('Y-m-d H:i:s'),
        ]);

        if ($user['peran_id'] == 1) {
            return redirect()->to('/admin/dashboard');
        } else {
            return redirect()->to('/opd/dashboard');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

        /* =========================================================
     * UBAH PASSWORD
     * ========================================================= */

    public function ubahPassword()
    {
        $data = [
            'title' => 'Ubah Password',
        ];

        return view('App\Modules\Auth\Views\ubah_password', $data);
    }

    public function simpanPassword()
    {
        $userId         = session()->get('user_id');
        $passwordLama   = $this->request->getPost('password_lama');
        $passwordBaru   = $this->request->getPost('password_baru');
        $konfirmasi     = $this->request->getPost('konfirmasi');

        // ============ Validasi ============
        if (empty($passwordLama) || empty($passwordBaru) || empty($konfirmasi)) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.');
        }

        if (strlen($passwordBaru) < 8) {
            return redirect()->back()->with('error', 'Password baru minimal 8 karakter.');
        }

        if ($passwordBaru !== $konfirmasi) {
            return redirect()->back()->with('error', 'Password baru dan konfirmasi tidak sama.');
        }

        // ============ Cek password lama ============
        $user = $this->userModel->find($userId);

        if (!$user || !password_verify($passwordLama, $user['hash_kata_sandi'])) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        // ============ Simpan password baru ============
        $this->userModel->update($userId, [
            'hash_kata_sandi' => password_hash($passwordBaru, PASSWORD_DEFAULT),
            'diperbarui_pada' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/ubah-password')->with('success', 'Password berhasil diubah.');
    }
}