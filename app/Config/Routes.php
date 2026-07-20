<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */// AUTH

$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginUser');

// INSCRIPTION (2 étapes)
$routes->get('/register', 'Auth::register');
$routes->post('/register/save', 'Auth::saveUser');

$routes->get('/register/health', 'Auth::healthForm');
$routes->post('/register/health/save', 'Auth::saveHealth');




$routes->group('', ['filter' => 'auth'], function ($routes) {
    // DASHBOARD USER
    $routes->get('/profile', 'User::profile');
    $routes->get('/logout', 'Auth::logoutUser');
    $routes->get('/viewprofile', 'User::seeProfile');
    $routes->post('/profile/update', 'User::updateProfile');
    $routes->post('/profile/change-password', 'User::changePassword');
    $routes->post('/profile/gold', 'User::upgradeGold');

    // IMC
    $routes->post('/imc/calculate', 'User::calculateIMC');
    $routes->get('/imc', 'User::showIMC');

    // ACTIVITES - Routes de consultation (tous les utilisateurs)
    $routes->get('/activites/calories/filter', 'Activite::getByCalories');
    $routes->get('/activites/(:num)', 'Activite::show/$1');
    $routes->get('/activites', 'Activite::index');


    // OBJECTIFS

    $routes->get('/objectifs', 'User::objectifs');
    $routes->post('/objectifs/save', 'User::saveObjectifs');
    // SUGGESTIONS
    //$routes->get('/suggestions', 'Suggestion::index');
    $routes->post('/suggestions/generate', 'Suggestion::generate');
    $routes->get('/suggestions/(:num)', 'Suggestion::show/$1');
    $routes->post('/suggestions/(:num)/buy', 'Suggestion::buy/$1');
    $routes->get('/suggestions/(:num)/export', 'Suggestion::exportPdf/$1');

    // WALLET
    $routes->get('/wallet', 'Wallet::index');
    $routes->post('/wallet/add', 'Wallet::addMoney');
    // SUGGESTIONS
    $routes->get('/suggestions', 'Suggestion::index');
    $routes->post('/suggestions/generate', 'Suggestion::generate');

    // WALLET
    $routes->get('/wallet', 'Wallet::index');
    $routes->post('/wallet/add', 'Wallet::addMoney');


    //demande de devenir gold
    $routes->post('/gold/request', 'User::requestGold');
});


// SUGGESTIONS
$routes->get('/suggestions', 'Suggestion::index');
$routes->post('/suggestions/generate', 'Suggestion::generate');

// WALLET
$routes->get('/wallet', 'Wallet::index');
$routes->post('/wallet/add', 'Wallet::addMoney');


// ADMIN PANEL
$routes->get('/admin', 'Admin::index');

$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    // Dashboard Admin
    $routes->get('/', 'Admin::index');

    // GESTION DES ACTIVITÉS (Admin seulement)
    $routes->get('activite', 'Admin::activity');

    $routes->get('activity/create', 'Admin::createActivity');
    $routes->post('activity/save', 'Admin::saveActivity');
    $routes->get('activity/(:num)/edit', 'Admin::editActivity/$1');
    $routes->post('activity/(:num)/update', 'Admin::updateActivity/$1');
    $routes->get('activity/(:num)/delete', 'Admin::deleteActivity/$1');
    $routes->post('activity/(:num)/delete', 'Admin::deleteActivity/$1');
    $routes->get('activity/(:num)/view', 'Admin::viewActivity/$1');

    /*Regime*/

    $routes->get('regime', 'Regime::index');

    $routes->get('regime/show/(:num)', 'Regime::show/$1');

    $routes->get('regime/create', 'Regime::create');
    $routes->post('regime/store', 'Regime::store');

    $routes->get('regime/edit/(:num)', 'Regime::edit/$1');
    $routes->post('regime/update/(:num)', 'Regime::update/$1');

    $routes->get('regime/delete/(:num)', 'Regime::delete/$1');
    $routes->post('regime/delete/(:num)', 'Regime::delete/$1');


    /**Wallet */
    $routes->get('wallet-requests', 'Admin::walletRequests');
    $routes->post('wallet-requests/accept/(:num)', 'Admin::acceptWalletRequest/$1');
    $routes->post('wallet-requests/refuse/(:num)', 'Admin::refuseWalletRequest/$1');


    /**CODE */
    $routes->get('code', 'Code::index');
    $routes->get('code/create', 'Code::create');
    $routes->post('code/store', 'Code::store');
    $routes->get('code/edit/(:num)', 'Code::edit/$1');
    $routes->post('code/update/(:num)', 'Code::update/$1');
    $routes->post('code/delete/(:num)', 'Code::delete/$1');

    // GOLD
    $routes->get('gold/pending', 'Admin::goldPending');
    $routes->get('gold/approve/(:num)', 'Admin::approveGold/$1');
    $routes->get('gold/reject/(:num)', 'Admin::rejectGold/$1');
    $routes->post('gold/update-price', 'Admin::updatePrice');
});



// PDF
$routes->get('/export/pdf', 'User::exportPDF');