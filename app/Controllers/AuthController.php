<?php

namespace App\Controllers;

use SebastianBergmann\Environment\Console;

class AuthController extends BaseController
{
    public function index()
    {
        // echo password_hash("B15m1LL4h_2026", PASSWORD_DEFAULT);
        
        // Check if the user is already logged in
        if (session()->get('log')) {
            // If logged in, redirect to their role's URL stored in the session
            return redirect()->to(base_url(session()->get('role_url')));
        }

        // If not logged in, show the login page
        return view('auth/login');
    }


    // Aksi Login
    public function loginAuth()
{
    // 1. Aturan Validasi Input
    $rules = [
        'username' => 'required',
        'password' => 'required'
    ];

    if (!$this->validate($rules)) {
        // Jika validasi gagal, kembalikan dengan pesan error
        return redirect()->to('login')->withInput()->with('errors', $this->validator->getErrors());
    }

    // Ambil data dari POST setelah divalidasi
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');
    $rememberme = $this->request->getPost('rememberme'); // Get remember me checkbox value

    // 2. Mengambil data user berdasarkan username
    // Menggunakan returnType 'array' dari model
    $user = $this->usersModel->where('username', $username)->first();

    // 3. Verifikasi User dan Password
    if ($user && password_verify($password, $user['password'])) {
        // Jika user ditemukan DAN password cocok (menggunakan hashing)
        
        // Ambil detail role
        $roleData = $this->usersModel->getUserRoleById($user['id']);
        if (!$roleData) {
            session()->setFlashdata('error', 'Role untuk user ini tidak ditemukan.');
            return redirect()->to('login');
        }
        
        // --- Remember Me Logic ---
        if ($rememberme) {
            // If "Remember Me" is checked, set session to last for 5 years (practically forever)
            $sessionExpiration = 60 * 60 * 24 * 365 * 5;
        } else {
            // If not checked, set session to expire at midnight
            $sessionExpiration = strtotime('tomorrow') - time();
        }
        // Dynamically set session cookie lifetime
        config('App')->sessionExpiration = $sessionExpiration;

        // 4. Buat Session
        $sessionData = [
            'log'       => true,
            'id_user'   => $user['id'],
            'id_role'   => $user['id_role'],
            'username'  => $user['username'],
            'role_name' => $roleData['name'],
            'role_url'  => $roleData['url'] 
        ];
        session()->set($sessionData);
        
        
        // 5. Redirect ke URL sesuai role (logika disederhanakan)
        return redirect()->to($roleData['url']);

    } else {
        // Jika username tidak ditemukan ATAU password salah
        session()->setFlashdata('error', 'Username atau Password salah.');
        return redirect()->to('login');
    }
}



    //=================================== Function Logout //===================================  
    public function logout()
        {
            session()->remove('log');
            session()->remove('id_role');
            session()->remove('id_user');
            session()->remove('username'); // Corrected typo from 'userame'
            session()->remove('role_name');
            session()->remove('role_url'); // Remove the role URL from session
            return redirect()->to('login');
        }


    //=================================== Function Set Session Hal //===================================  
    public function session($hal)
    {
        session()->set('hal', $hal);
        echo "SESSION SET : " . $hal;
    }
}
