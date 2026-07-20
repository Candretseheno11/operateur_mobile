<?php

namespace App\Controllers;

use App\Models\UserModel;
// use App\Models\UserObjectifModel;
use App\Models\HealthModel;
use App\Models\ObjectifModel;
use App\Models\UserObjectifModel;
use App\Models\SuggestionModel;
use App\Models\WalletModel;
use App\Models\PassageGoldModel;
class User extends BaseController
{
    public function profile(): string
    {
        $model = new HealthModel();
        $id = session()->get('user')['id'];
        $walletModel = new WalletModel();
        $wallet = $walletModel->getWalletByUser($id);
        $info_user = $model->getHealthByUser($id);
        $objectifModel = new ObjectifModel();
        $userObjectifModel = new UserObjectifModel();
        $userObjectif = $userObjectifModel->getObjectifsByUser($id);
        $liste_objectifs = $objectifModel->getAllObjectifs();
        $suggestionModel = new SuggestionModel();
        $suggestions = $suggestionModel->getSuggestionsByUser($id);

        return view('User/profile', [
            'info' => $info_user,
            'objectif' => $userObjectif,
            'liste_objectifs' => $liste_objectifs,
            'suggestions' => $suggestions,
            'wallet' => $wallet
        ]);
    }

    public function calculateIMC()
    {
        $model = new HealthModel();
        $data = $this->request->getPost();

        $id = session()->get('user')['id'];
        $info = $model->getHealthByUser($id);
        $imc = $model->updateHealth($id, $data);

        return redirect()->to('/profile');
    }

    public function saveObjectifs()
    {
        $model = new UserObjectifModel();
        $objectif_id = $this->request->getPost('objectif_id');
        $user_id = session()->get('user')['id'];
        $save = $model->addObjectifToUser($user_id, $objectif_id);

        return redirect()->to('/profile')->with('success', 'Objectif mis à jour !');
    }

    public function requestGold()
    {
        $userId = session()->get('user')['id'];

        $passageModel = new PassageGoldModel();

        $request = $passageModel->createRequest($userId);

        if (!$request) {
            return redirect()->back()->with('error', 'Une demande est déjà en attente');
        }

        return redirect()->back()->with('success', 'Demande envoyée');
    }


    public function seeprofile()
    {
        $userId = session()->get('user')['id'];
        $passageModel = new PassageGoldModel();
        $passage = $passageModel->where('user_id', $userId)->first();
        $walletModel = new WalletModel();
        $wallet = $walletModel->getWalletByUser($userId);

        $userModel = new UserModel();
        $user = $userModel->getProfile($userId);

        return view('User/seeprofile', [
            'user' => $user,
            'wallet' => $wallet,
            'passage' => $passage
        ]);
    }
    public function updateProfile()
    {
        $sessionUser = session()->get('user');

        if (!$sessionUser) {
            return redirect()->to('/login');
        }

        $userId = $sessionUser['id'];

        $data = [
            'nom' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'genre' => $this->request->getPost('genre'),
        ];

        $userModel = new UserModel();

        // 🔄 update en base
        $userModel->updateProfile($userId, $data);

        // 🔄 refresh user depuis DB (important)
        $updatedUser = $userModel->getUserById($userId);

        // 🔄 mise à jour session
        session()->set('user', [
            'id' => $updatedUser['id'],
            'nom' => $updatedUser['nom'],
            'email' => $updatedUser['email'],
            'genre' => $updatedUser['genre'],
            'role' => $updatedUser['role'],
            'is_gold' => $updatedUser['is_gold'],
        ]);

        return redirect()->back()->with('success', 'Profil mis à jour avec succès');
    }

    public function changePassword()
    {
        $sessionUser = session()->get('user');

        if (!$sessionUser) {
            return redirect()->to('/login');
        }

        $userId = $sessionUser['id'];

        $oldPassword = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->getUserById($userId);

        // 1. vérifier ancien mot de passe (simple comme tu veux)
        if ($oldPassword !== $user['password']) {
            return redirect()->back()->with('error', 'Ancien mot de passe incorrect');
        }


        // 3. update password
        $userModel->update($userId, [
            'password' => $newPassword
        ]);

        // 4. update session
        $sessionUser['password'] = $newPassword;
        session()->set('user', $sessionUser);

        return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès');
    }
}