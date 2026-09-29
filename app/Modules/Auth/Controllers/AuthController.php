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
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('App\Modules\Auth\Views\login');
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

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}