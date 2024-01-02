<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

service('auth')->routes($routes);

$routes->get('/', static function () {
    return redirect()->to(base_url('home'));
});

$routes->get('home', 'LandingPages\Home::index');
$routes->get('ticket', 'LandingPages\ticket::index');
$routes->get('news', 'LandingPages\News::index');
$routes->get('news/(:any)', 'LandingPages\News::detail/$1');
$routes->get('galery/animal', 'LandingPages\Galery::indexAnimal');
$routes->get('galery/guest', 'LandingPages\Galery::indexHuman');
$routes->get('/park/information', 'LandingPages\Park::Information');
$routes->get('modalauth', 'LandingPages\Home::modalAuth');
$routes->post('ticket/quota/check', 'LandingPages\Ticket::checkTicketQuota');

$routes->group('private', ['namespace' => 'App\Controllers\Private'], function ($routes) {
    // < Profile Controllers ------------------------------------------- >
    $routes->get('profile', 'Profile');
    $routes->post('profile', 'Profile::avatarPost');
    $routes->put('updateMyInfoWorker', 'Profile::updateMyInfoWorker');
    // </ Profile Controllers ------------------------------------------- >

    $routes->resource('worker');

    // < Absent Controllers ------------------------------------------- >
    $routes->get('absent/indexScan', 'Absent::indexScan');
    $routes->post('absent/checkWorkerDataScan', 'Absent::checkWorkerDataScan');
    $routes->resource('absent', ['placeholder' => '(:num)']);
    // </ Absent Controllers ------------------------------------------- >

    $routes->resource('galery', ['filter' => 'RoleFilter:superadmin,dataentry']);
    $routes->resource('news', ['filter' => 'RoleFilter:superadmin,dataentry']);
    $routes->get('ticket/indexscan', 'Ticket::indexScan');
    $routes->post('ticket/scanUpdateData', 'Ticket::scanUpdateData');
    $routes->get('ticket/management', 'Ticket::indexTicketManagement');
    $routes->post('ticket/management/add', 'Ticket::addTicketManagement');
    $routes->put('ticket/management/edit/(:any)', 'Ticket::editTicketManagement/$1');
    $routes->resource('ticket', ['filter' => 'RoleFilter:superadmin,dataentry']);
});

$routes->post('checkout/create', 'Checkout::create');
$routes->get('checkout', 'Checkout::read');
$routes->put('checkout/update/(:any)', 'Checkout::update/$1');
$routes->delete('checkout/delete/(:any)', 'Checkout::delete/$1');
$routes->post('delete/checkout/all', 'Checkout::deleteCheckoutTicket');

$routes->group('payment', ['namespace' => 'App\Controllers\Payment'], ['filter' => 'IsLoggedIn'], function ($routes) {
    $routes->post('ticket', 'TicketPayment::paySingle');
});


// $routes->post('payment/ticket/create/transaction', 'Payment\TicketPayment::transactionCreate');

$routes->post('payment/ticket/transaction/callback', 'Payment\TicketPayment::transactionCallback');
$routes->post('qrcode/ticket/create', 'Payment\TicketPayment::eTicketCreate');

$routes->group('mypurchase', ['namespace' => 'App\Controllers\Payment'], ['filter' => 'IsLoggedIn'], function ($routes) {
    $routes->get('ticket/invoice', 'TicketPayment::invoiceViewAll');
    $routes->get('ticket/invoice/(:num)', 'TicketPayment::invoiceDetail/$1');
});



