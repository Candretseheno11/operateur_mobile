<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\HealthModel;
class Auth extends BaseController
{
    public function login(): string
    {
        return view('Auth/login');
    }
    public function loginUser()
    {
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();


        if (!$user) {
            return redirect()->back()->with('error', 'Email non repertorié ! Veuillez vous inscrire');
        }
        if ($password !== $user['password']) {
            return redirect()->back()->with('error', 'Mot de passe incorrect');
        }

        session()->set('user', [
            'id' => $user['id'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'genre' => $user['genre'],
            'is_gold' => $user['is_gold'],
            'role' => $user['role'],
            'password' => $user['password']
        ]);
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin');
        }
        return redirect()->to('/profile');
    }

    public function logoutUser()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        return view('Auth/register');
    }

    public function saveUser()
    {
        $model = new UserModel();
        $data = $this->request->getPost();

        if (!$model->createUser($data)) {
            // Retourne vers le formulaire avec les erreurs
            return view('register', [
                'error' => $model->errors()
            ]);
        }

        // Recuperation du dernier ID inséré
        $id = $model->getInsertID();

        // Mise en session du ID en temp 
        session()->set('temp', [
            'id' => $id
        ]);

        return redirect()->to('/register/health');
    }

    public function healthForm()
    {
        return view('Auth/register_health');
    }

    public function saveHealth()
    {
        $model = new HealthModel();
        $data = $this->request->getPost();
        $model->saveHealth($data);
        session()->remove('temp');
        return redirect()->to('/')
            ->with('success', 'Utilisateur ajouter avec succès');

    }
}