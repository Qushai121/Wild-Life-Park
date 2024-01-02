<?php

namespace App\Controllers\LandingPages;

use App\Controllers\BaseController;
use App\Models\TicketManagementModel;
use App\Models\TicketModel;
use App\Models\TicketQrCodeModel;

class Ticket extends BaseController
{
    private $encryption;
    public function __construct(
        private $tickeModel = new TicketModel(),
        private $ticketQrCodeModel = new TicketQrCodeModel(),
        private $ticketMagementModel = new TicketManagementModel(),
    ) {
        $this->encryption = \Config\Services::encrypter();
    }
    public function index()
    {
        $data['listTickets'] = $this->tickeModel->where('publish', 'publish')->findAll();
        $data['topbar'] = [
            'title' => 'List Ticket',
            'description' => 'Find & buy Your ticket to open the gate to the wild park'
        ];

        return view('Pages/LandingPages/Ticket/IndexTicket', $data);
    }

    public function detail($id)
    {
        $data['topbar'] = [
            'title' => 'List Ticket',
            'description' => 'Find & buy Your ticket to open the gate to the wild park'
        ];

        $data['ticket'] = $this->tickeModel->find($id);
        return view('Pages/LandingPages/Ticket/IndexTicket', $data);
    }

    public function checkTicketQuota()
    {
        $quotaPerDate = null;
        $dateInput = $this->request->getPost('dateInput');
        $getDataByDate = $this->ticketMagementModel->getDataByDate($dateInput);

        if ($getDataByDate != null) {
            $quotaPerDate = $getDataByDate['quota_per_day'];
        } else {
            $getMainQuotaToAllDate = $this->ticketMagementModel->getMainQuotaToAllDate();
            $quotaPerDate =  $getMainQuotaToAllDate['quota_per_day'];
        }


        $quotaAlreadyBooked = $this->ticketQrCodeModel->getTicketQrCodeByTimeInput($dateInput);

        if (($quotaPerDate - count($quotaAlreadyBooked)) == 0) {
            return $this->response->setStatusCode(401)->setJSON(['message' => "Quota E-Ticket For " . format_datetime($dateInput) . " Already Full"]);
        }

        // return $this->response->setStatusCode(200);
        return $this->response->setStatusCode(200)->setJSON(["message" => "Quota E-Ticket For " . format_datetime($dateInput) . " Only Left " . $quotaPerDate - count($quotaAlreadyBooked)]);
    }

    // public function checkTicketQuota()
    // {
    //     $quotaPerDate = 10;
    //     $dateInput = $this->request->getPost('dateInput');
    //     $quota = $this->ticketQrCodeModel->getTicketQrCodeByTimeInput($dateInput);

    //     // dd(count($quota) >= $quotaPerDate);
    //     if (($quotaPerDate - count($quota)) == 0) {
    //         return $this->response->setStatusCode(401)->setJSON(['message' => "Quota E-Ticket For " . format_datetime($dateInput) . " Already Full"]);
    //     }

    //     // return $this->response->setStatusCode(200);
    //     return $this->response->setStatusCode(200)->setJSON(["message"=> "Quota E-Ticket For " . format_datetime($dateInput) . " Only Left ". $quotaPerDate - count($quota) ]);
    // }
}
