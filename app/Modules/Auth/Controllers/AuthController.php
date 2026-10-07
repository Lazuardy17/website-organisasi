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
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->to('/')
                ->with('error', 'Username dan password wajib diisi.')
                ->with('username', $username);
        }

        $user = $this->userModel->findByUsername($username);

        if (!$user) {
            return redirect()->to('/')
                ->with('error', 'Username atau password salah.')
                ->with('username', $username);
        }

        if (!password_verify($password, $user['hash_kata_sandi'])) {
            return redirect()->to('/')
                ->with('error', 'Username atau password salah.')
                ->with('username', $username);
        }

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
