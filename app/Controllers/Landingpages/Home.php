<?php

namespace App\Controllers\Landingpages;

use App\Controllers\BaseController;
use App\Models\TransactionModel;

class Home extends BaseController
{
    public function __construct(
        public $transactionModel = new TransactionModel()
    ) {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS.SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        \Midtrans\Config::$overrideNotifUrl = base_url("payment/ticket/transaction/callback");
    }

    public function index()
    {

        // $status = \Midtrans\Transaction::status(779982878);
        // var_dump($status);
        // $transactionDatas = $this->transactionModel->where('order_id', 424153690)->get()->getResultArray();
        // $transactionData=[];

        // foreach ($transactionDatas as $item) {
        //    $transactionData[] =  [
        //         'status' => 'pen',
        //         'order_id' => 424153690,
        //     ];
        // }
        // $this->transactionModel->updateBatch($transactionData,'order_id');
        // session()->set('TicketPayment', null);

        // setcookie('products', null, time() - 3600 * 60, '/');
        // dd(session()->get('TicketPayment'));
        // dd([$this->request->getCookie('products'), session()->get('TicketPayment')]);


       
        return view('Pages/LandingPages/Home/HomeView');
    }

    public function deleteCheckout()
    {
        session()->set('TicketPayment', null);

        setcookie('products', null, time() - 3600 * 60, '/');

        return $this->response->setStatusCode(200);
    }

    public function modalAuth()
    {
        if (!auth()->user()) {
            $data['html'] = component('LandingPages/ModalAuth');
            return $this->response->setJSON($data);
        }
    }
}
