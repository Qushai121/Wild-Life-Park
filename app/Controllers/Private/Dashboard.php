<?php

namespace App\Controllers\Private;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\WorkerModel;
use DateTime;

class Dashboard extends BaseController
{

    public function __construct(
        private $transactionModel = new TransactionModel(),
        private $workerModel = new WorkerModel(),
    ) {
    }

    public function indexAdmin()
    {
        $nowTime = new DateTime('now');
        $currentMonth = $nowTime->format('m');
        $currentYear = $nowTime->format('Y');

        $byMonth = $this->request->getGet('byMonth');
        $byYear = $this->request->getGet('byYear');

        if ($byMonth != 0 && empty($byMonth)) {
            $byMonth = $currentMonth;
        };

        if ($byYear != 0 && empty($byYear)) {
            $byYear = $currentYear;
        };

        $data['total_amount'] = $this->transactionModel->getTransactionTotalMoneyByPeriode('settlement', $byMonth, $byYear);

        $data['topbarData'] = [
            'title' => 'Admin Dashboard',
            "desc" => "Monitoring Your Website Here"
        ];

        return PrivatePages('Dashboard/AdminDashboard', $data);
    }
}
