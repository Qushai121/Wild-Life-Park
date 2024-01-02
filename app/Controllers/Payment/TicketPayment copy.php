<?php

namespace App\Controllers\Payment;

use App\Controllers\BaseController;
use App\Models\GaleryModel;
use App\Models\TicketModel;
use App\Models\TicketQrCodeModel;
use App\Models\TransactionModel;
use DateTime;

class TicketPayment extends BaseController
{
    public function __construct(
        private $galeryModel = new GaleryModel(),
        private $ticketModel = new TicketModel(),
        private $transactionModel = new TransactionModel(),
        private $ticketQrCodeModel = new TicketQrCodeModel(),
    ) {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS.SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    }


    public function paySingle()
    {
        $dataReq = $this->request->getPost('productData');
        $dateInput = $this->request->getPost('dateInput');
        $quotaPerDate = 1;

        $quota = $this->ticketQrCodeModel->getTicketQrCodeByTimeInput($dateInput);

        if (($quotaPerDate - count($quota)) == 0) {
            return $this->response->setStatusCode(401)->setJSON(['message' => "Quota E-Ticket For  " . format_datetime($dateInput) . " Is Already Full"]);
        }

        session()->set('TicketPayment', $dataReq);

        $productQuantities  = array_column($dataReq, 'qty', 'productid');

        $tickets = $this->ticketModel->getTicketByManyIds(
            array_keys($productQuantities) ?: 0,
            'id,discount,price,name,totalqrcode'
        );

        $ticketList = [];
        $ticketListQty = 0;
        $order_id = rand();
        $currentDateTime = new DateTime();
        $newDateTime = $currentDateTime->modify('+7 days');
        $expired_at = $newDateTime->format('Y-m-d H:i:s');


        foreach ($tickets as $item) {
            $quantity = $productQuantities[$item['id']];
            $ticketListQty += $item['totalqrcode'] * $quantity;
            $ticketList[] = [
                'id' => $item['id'],
                'quantity' => $quantity,
                'price' => discountPrice($item['price'], $item['discount']),
                'name' => $item['name'],
            ];
        }

        if (($ticketListQty + count($quota)) > $quotaPerDate) {
            return $this->response->setStatusCode(401)->setJSON(['message' => "Quota For E-Ticket " . format_datetime($dateInput) . " Is Only Left " . $quotaPerDate - count($quota)]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
            ],
            'customer_details' => [
                'user_id' => auth()->user()->id,
                'first_name' => auth()->user()->username,
                'email' => auth()->user()->email,
            ],
            'item_details' => $ticketList
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return $this->response->setJSON(['result' => $snapToken]);
    }

    public function transactionCreate()
    {
        $dataReq = $this->request->getPost(['order_id', 'snap_token', 'dateInput']);

        // $quota = $this->transactionModel->getTransactionByTimeInput($dataReq['dateInput']);

        // if ($quota >= 1) {
        //     return $this->response->setStatusCode(401);
        // }

        $productQuantities  = array_column(session()->get('TicketPayment'), 'qty', 'productid');


        $tickets = $this->ticketModel->getTicketByManyIds(
            array_keys($productQuantities) ?: 0,
            'id,discount,price,name'
        );

        $transactionDatas = [];

        foreach ($tickets as $item) {
            $quantity = $productQuantities[$item['id']];

            $transactionDatas[] = [
                'user_id' => auth()->user()->id,
                'status' => 'settlement',
                'product_id' => $item['id'],
                'order_id' => $dataReq['order_id'],
                'quantity' => $quantity,
                'price_then' => $item['price'],
                'discount_then' => $item['discount'],
                'total_price_then' => discountPrice($item['price'], $item['discount']) * $quantity,
                'snap_token' => $dataReq['snap_token'],
                'product_category' => 'ticket',
                'checkin_at' => $dataReq['dateInput']
            ];
        }

        $response = $this->transactionModel->insertBatch($transactionDatas);

        session()->set('TicketPayment', null);

        setcookie('products', null, time() - 3600 * 60, '/');

        if ($response) {
            $this->eTicketCreate($dataReq['order_id']);
        }

        return $this->response->setStatusCode(200);
    }


    public function invoiceViewAll()
    {
        if (!auth()->user()) {
            return redirect()->back()->with("authMessage", true);
        }
        
        $data['topbar'] = [
            'title' => 'List My Purchase Item',
            'description' => 'Find Your Purchase Items transaction'
        ];

        $data['invoiceDatas'] =  $this->transactionModel->getTransactionByUserIdWithTicket(
            auth()->user()->id,
            'order_id,status,
            SUM(quantity) as total_quantity_all,SUM(total_price_then) as total_price_then_all,created_at,'
        );

        return LandingPages('Invoice/InvoiceTicket/IndexInvoiceTicket', $data);
    }

    public function invoiceDetail($order_id)
    {
        $data['topbar'] = [
            'title' => 'Invoice My Purchase Item',
            'description' => 'Invoice Your Purchase Items transaction'
        ];

        $invoiceDatas =  $this->transactionModel->getTransactionByOrderIdWithTicket(
            $order_id,
            'transactions.*,tickets.image,tickets.description,tickets.name'
        );

        $invoiceDataIds = [];

        foreach ($invoiceDatas as $invoiceData) {
            $invoiceDataIds[] = $invoiceData['transaction_id'];
        }


        $ticketQrCodeDatas = $this->ticketQrCodeModel->getTicketQrCodeByTransactionIds($invoiceDataIds);

        $data['transactionTickets'] = [];

        foreach ($invoiceDatas as $key => $invoiceData) {
            $data['transactionTickets'][] = $invoiceData;
            foreach ($ticketQrCodeDatas as $index => $ticketQrCodeData) {
                if ($invoiceData['transaction_id'] == $ticketQrCodeData['transaction_id']) {
                    $data['transactionTickets'][$key]['hasManyQrCode'][$index] = $ticketQrCodeData;
                }
            }
        }

        return LandingPages('Invoice/InvoiceTicket/DetailInvoiceTicket', $data);
    }

    private function eTicketCreate($order_id)
    {

        $transactionDatas = $this->transactionModel->getTransactionByOrderIdWithTicket(
            $order_id,
            '*',
        );
        $currentDateTime = new DateTime();

        $ticketQrcodeDatas = [];

        foreach ($transactionDatas as $transactionData) {
            // dd($transactionData['created_at']);
            $currentDateTime->setTimestamp(strtotime($transactionData['created_at']));
            $newDateTime = $currentDateTime->modify('+7 days');
            $expired_at = $newDateTime->format('Y-m-d H:i:s');


            $totalTicketCostumerGet = $transactionData['quantity'] * $transactionData['totalqrcode'];


            for ($i = 0; $i < $totalTicketCostumerGet; $i++) {

                $qrcodeIdUnique = mt_rand() . rand(rand($i, $i * rand()), rand());

                $qrCodeDataParams = [
                    'transaction_id' => $transactionData['transaction_id'],
                    'qrcode_token' => $qrcodeIdUnique,
                    'access' => $transactionData['access'],
                ];

                $ticketQrcodeDatas[] = [
                    'transaction_id' => $transactionData['transaction_id'],
                    'qrcode_token' => $qrcodeIdUnique,
                    'status' => 'unused',
                    'qrcode' =>  generateQRCode($qrCodeDataParams, "upload/tickets/" . $transactionData['image'], $transactionData['name'])->getDataUri(),
                    'expired_at' => $transactionData['checkin_at']
                ];
            }
        }

        $this->ticketQrCodeModel->insertBatch($ticketQrcodeDatas);

        // $this->sendETicketToMail($ticketQrcodeDatas);
    }

    public function sendETicketToMail($ticketQrcodeDatas)
    {

        $emailService = service('email');
        $emailService->setTo(auth()->user()->email);
        $emailService->setFrom('binomodelesol@gmail.com', 'Wisata Bedengan');

        $emailService->setSubject('Your Ticket From Wild LIfe Park');
        $emailService->setMessage($ticketQrcodeDatas);
    }
}

// <?php

// namespace App\Controllers\Payment;

// use App\Controllers\BaseController;
// use App\Models\GaleryModel;
// use App\Models\TicketModel;
// use App\Models\TicketQrCodeModel;
// use App\Models\TransactionModel;
// use DateTime;

// class TicketPayment extends BaseController
// {
//     public function __construct(
//         private $galeryModel = new GaleryModel(),
//         private $ticketModel = new TicketModel(),
//         private $transactionModel = new TransactionModel(),
//         private $ticketQrCodeModel = new TicketQrCodeModel(),
//     ) {
//         // Set your Merchant Server Key
//         \Midtrans\Config::$serverKey = env('MIDTRANS.SERVER_KEY');
//         // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
//         \Midtrans\Config::$isProduction = false;
//         // Set sanitization on (default)
//         \Midtrans\Config::$isSanitized = true;
//         // Set 3DS transaction for credit card to true
//         \Midtrans\Config::$is3ds = true;
//     }

//     public function paySingle()
//     {
//         $dataReq = $this->request->getPost('productData');

//         session()->set('TicketPayment', $dataReq);

//         $productQuantities  = array_column($dataReq, 'qty', 'productid');

//         $tickets = $this->ticketModel->getTicketByManyIds(
//             array_keys($productQuantities) ?: 0,
//             'id,discount,price,name'
//         );

//         $ticketList = [];
//         $order_id = rand();
//         $currentDateTime = new DateTime();
//         $newDateTime = $currentDateTime->modify('+7 days');
//         $expired_at = $newDateTime->format('Y-m-d H:i:s');


//         foreach ($tickets as $item) {
//             $quantity = $productQuantities[$item['id']];

//             $ticketList[] = [
//                 'id' => $item['id'],
//                 'quantity' => $quantity,
//                 'price' => discountPrice($item['price'], $item['discount']),
//                 'name' => $item['name'],
//             ];
//         }

//         $params = [
//             'transaction_details' => [
//                 'order_id' => $order_id,
//             ],
//             'customer_details' => [
//                 'user_id' => auth()->user()->id,
//                 'first_name' => auth()->user()->username,
//                 'email' => auth()->user()->email,
//             ],
//             'item_details' => $ticketList
//         ];

//         $snapToken = \Midtrans\Snap::getSnapToken($params);


//         return $this->response->setJSON(['result' => $snapToken]);
//     }

//     public function transactionCreate()
//     {
//         $dataReq = $this->request->getPost(['order_id', 'snap_token','dateInput']);

//         $productQuantities  = array_column(session()->get('TicketPayment'), 'qty', 'productid');

//         $tickets = $this->ticketModel->getTicketByManyIds(
//             array_keys($productQuantities) ?: 0,
//             'id,discount,price,name'
//         );

//         $transactionDatas = [];

//         foreach ($tickets as $item) {
//             $quantity = $productQuantities[$item['id']];

//             $transactionDatas[] = [
//                 'user_id' => auth()->user()->id,
//                 'status' => 'settlement',
//                 'product_id' => $item['id'],
//                 'order_id' => $dataReq['order_id'],
//                 'quantity' => $quantity,
//                 'price_then' => $item['price'],
//                 'discount_then' => $item['discount'],
//                 'total_price_then' => discountPrice($item['price'], $item['discount']) * $quantity,
//                 'snap_token' => $dataReq['snap_token'],
//                 'product_category' => 'ticket',
//                 'checkin_at' => $dataReq['dateInput']
//             ];
//         }

//         $response = $this->transactionModel->insertBatch($transactionDatas);

//         session()->set('TicketPayment', null);

//         setcookie('products', null, time() - 3600 * 60, '/');

//         if ($response) {
//             $this->eTicketCreate($dataReq['order_id']);
//         }

//         return $this->response->setStatusCode(200);
//     }


//     public function invoiceViewAll()
//     {
//         $data['topbar'] = [
//             'title' => 'List My Purchase Item',
//             'description' => 'Find Your Purchase Items transaction'
//         ];

//         $data['invoiceDatas'] =  $this->transactionModel->getTransactionByUserIdWithTicket(
//             auth()->user()->id,
//             'order_id,status,
//             SUM(quantity) as total_quantity_all,SUM(total_price_then) as total_price_then_all,created_at,'
//         );

//         return LandingPages('Invoice/InvoiceTicket/IndexInvoiceTicket', $data);
//     }

//     public function invoiceDetail($order_id)
//     {
//         $data['topbar'] = [
//             'title' => 'Invoice My Purchase Item',
//             'description' => 'Invoice Your Purchase Items transaction'
//         ];

//         $invoiceDatas =  $this->transactionModel->getTransactionByOrderIdWithTicket(
//             $order_id,
//             'transactions.*,tickets.image,tickets.description,tickets.name'
//         );

//         $invoiceDataIds = [];

//         foreach ($invoiceDatas as $invoiceData) {
//             $invoiceDataIds[] = $invoiceData['transaction_id'];
//         }


//         $ticketQrCodeDatas = $this->ticketQrCodeModel->getTicketQrCodeByTransactionIds($invoiceDataIds);

//         $data['transactionTickets'] = [];

//         foreach ($invoiceDatas as $key => $invoiceData) {
//             $data['transactionTickets'][] = $invoiceData;
//             foreach ($ticketQrCodeDatas as $index => $ticketQrCodeData) {
//                 if ($invoiceData['transaction_id'] == $ticketQrCodeData['transaction_id']) {
//                     $data['transactionTickets'][$key]['hasManyQrCode'][$index] = $ticketQrCodeData;
//                 }
//             }
//         }

//         return LandingPages('Invoice/InvoiceTicket/DetailInvoiceTicket', $data);
//     }

//     private function eTicketCreate($order_id)
//     {

//         $transactionDatas = $this->transactionModel->getTransactionByOrderIdWithTicket(
//             $order_id,
//             '*',
//         );
//         $currentDateTime = new DateTime();

//         $ticketQrcodeDatas = [];

//         foreach ($transactionDatas as $transactionData) {
//             // dd($transactionData['created_at']);
//             $currentDateTime->setTimestamp(strtotime($transactionData['created_at']));
//             $newDateTime = $currentDateTime->modify('+7 days');
//             $expired_at = $newDateTime->format('Y-m-d H:i:s');


//             $totalTicketCostumerGet = $transactionData['quantity'] * $transactionData['totalqrcode'];


//             for ($i = 0; $i < $totalTicketCostumerGet; $i++) {

//                 $qrcodeIdUnique = mt_rand() . rand(rand($i, $i * rand()), rand());

//                 $qrCodeDataParams = [
//                     'transaction_id' => $transactionData['transaction_id'],
//                     'qrcode_token' => $qrcodeIdUnique,
//                     'access' => $transactionData['access'],
//                 ];

//                 $ticketQrcodeDatas[] = [
//                     'transaction_id' => $transactionData['transaction_id'],
//                     'qrcode_token' => $qrcodeIdUnique,
//                     'status' => 'unused',
//                     'qrcode' =>  generateQRCode($qrCodeDataParams, "upload/tickets/" . $transactionData['image'], $transactionData['name'])->getDataUri(),
//                     'expired_at' => $
//                 ];
//             }
//         }

//         $this->ticketQrCodeModel->insertBatch($ticketQrcodeDatas);

//         // $this->sendETicketToMail($ticketQrcodeDatas);
//     }

//     public function sendETicketToMail($ticketQrcodeDatas)
//     {

//         $emailService = service('email');
//         $emailService->setTo(auth()->user()->email);
//         $emailService->setFrom('binomodelesol@gmail.com', 'Wisata Bedengan');

//         $emailService->setSubject('Your Ticket From Wild LIfe Park');
//         $emailService->setMessage($ticketQrcodeDatas);
//     }
// }
