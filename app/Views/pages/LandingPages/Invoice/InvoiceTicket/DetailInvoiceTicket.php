<?= $this->extend('templates/LandingPages') ?>
<?= $this->section('content'); ?>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= env('MIDTRANS.CLIENT_KEY'); ?>"></script>
<link rel="stylesheet" href="<?= base_url('css/flatpickr.min.css'); ?>">

<div class="w-full ">
    <?= component('LandingPages/TopBar'); ?>
</div>
<?php
$snapToken = $transactionTickets[0]['snap_token'];
$checkInTime = $transactionTickets[0]['checkin_at'];
$totalQrCodeUserGet = 0;
$allTotalPrice = 0;
$totalQty = 0
?>
<div class="flex my-8">
    <div class="flex flex-col gap-4 xl:px-36 ">
        <?php foreach ($transactionTickets as $transactionTicket) : ?>
            <?php
            $totalQrCodeUserGet += $transactionTicket['quantity'] * $transactionTicket['totalqrcode'];
            $allTotalPrice += $transactionTicket['total_price_then'] * $transactionTicket['quantity'];
            $totalQty += $transactionTicket['quantity'];
            ?>
            <div class="w-full border-2 border-stone-400 p-4">
                <h1 class="text-lg font-bold my-2"><?= $transactionTicket['order_id']; ?> <span class="text-sm font-semibold "> Order Id #</span></h1>
                <div class="flex gap-8">
                    <div class="border-2 border-stone-400 p-4 rounded-md">
                        <h1 class="text-xl font-bold"><?= $transactionTicket['product_category']; ?> Detail : </h1>
                        <div class="flex gap-4 my-2">
                            <div class="flex flex-col justify-between">
                                <div>
                                    <h1 class="font-semibold text-lg"><?= $transactionTicket['name']; ?></h1>
                                    <div class="w-64">
                                        <p><?= $transactionTicket['description']; ?></p>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium ">Status Payment :</p>
                                    <button class="btn btn-info"><?= $transactionTicket['status']; ?></button>
                                </div>
                            </div>
                            <div class=" rounded-lg h-[40vh] w-[20vw]">

                                <img class="rounded-lg" src="<?= base_url('upload/tickets/') . $transactionTicket['image']; ?>" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="border-2 border-stone-400 p-4 rounded-md ">
                        <h1 class="text-xl font-bold">Payment Ticket Detail : </h1>
                        <table class="my-2">
                            <tbody class="divide-y my-5">
                                <tr>
                                    <td class="w-64">Quantity</td>
                                    <td><?= $transactionTicket['quantity']; ?></td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td><?= toRupiah($transactionTicket['price_then']); ?></td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td><?= $transactionTicket['discount_then']; ?>%</td>
                                </tr>
                                <tr>
                                    <td>Total Price</td>
                                    <td><?= toRupiah($transactionTicket['total_price_then']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if (!empty($transactionTicket['hasManyQrCode'])) : ?>
                    <div class="mt-4 mb-2">
                        <h1 class="text-xl font-bold my-2">Item Your Get : </h1>
                        <div class="border-2 border-stone-300 rounded-md p-2">
                            <div class="flex xl:flex-row flex-col xl:flex-wrap  gap-4 justify-center py-4">
                                <?php foreach ($transactionTicket['hasManyQrCode'] as $qrCodeData) : ?>
                                    <div class="w-[18vw] border-2 border-gray-400 shadow-md p-4 rounded-lg">
                                        <div class="flex gap-4 items-center">
                                            <p class="text-xl font-bold">Status <span class="text-base font-semibold"><?= $qrCodeData['status']; ?> </span></p>
                                        </div>
                                        <div class=" py-4 h-80 w-full">
                                            <div class="mx-8 h-full">
                                                <img src="<?= $qrCodeData['qrcode']; ?>" alt="">
                                            </div>
                                        </div>
                                        <div>
                                            <p>QrCode Token</p>
                                            <p><?= $qrCodeData['qrcode_token']; ?></p>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    </div>


    <div>
        <div>
            <!-- The button to open modal -->
            <label for="my_modal_6" class="btn !bg-green-400 text-white disabled:!bg-stone-400">Pay All</label>

            <!-- Put this part before </body> tag -->
            <input type="checkbox" id="my_modal_6" class="modal-toggle" />
            <div class="modal" role="dialog">
                <div class="modal-box">
                    <div class="text-start flex w-full justify-between mb-2 text-md font-semibold">
                        <p id="infoAboutTicket" class=" w-full text-white btn btn-info "></p>
                    </div>
                    <div class="text-start flex justify-between text-md font-semibold">
                        <p>E-Ticket You Get </p>
                        <p><?= $totalQrCodeUserGet . "x"; ?></p>
                    </div>
                    <div class="text-start flex justify-between text-md font-semibold">
                        <p>Total</p>
                        <p><?= toRupiah($allTotalPrice); ?></p>
                    </div>
                    <?php
                    $currentDateTime = new DateTime();

                    $oneYearLaterDateTime = clone $currentDateTime;

                    $oneYearLaterDateTime->add(new DateInterval('P1Y'));
                    ?>
                    <div class="flex flex-col gap-2 mt-4">
                        <p class="font-semibold text-xl">Check In Time</p>
                        <div role="alert" class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="font-semibold text-sm ">Make Sure This Check In Time Is Correct If not go make another transaction</p>
                        </div>
                        <input type="time" disabled value="<?= $checkInTime; ?>" min="<?= $currentDateTime->format('Y-m-d'); ?>" max="<?= $oneYearLaterDateTime->format('Y-m-d'); ?>" id="time_input" class="border-gray-400" name="time" required>
                    </div>
                    <div class="modal-action">
                        <button onclick="midtransSnap('<?= $snapToken ?>')" class="btn !bg-green-400 text-white disabled:!bg-stone-400">Pay<span>(<?= $totalQty; ?>)</span></button>
                        <label for="my_modal_6" class="btn btn-error">Close!</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?= base_url('js/flatpickr.min.js'); ?>"></script>
<script>
    flatpickr("#time_input", {
        maxDate: "<?= $oneYearLaterDateTime->format("Y-m-d") ?>",
        minDate: "today",
        locale: "id",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    })

    function midtransSnap(token) {
        snap.pay(token);
    }

    let spinnerComponent = '<span class="loading loading-spinner loading-lg"></span>'

    let infoAboutTicket = document.getElementById('infoAboutTicket')
    let dateInput = document.getElementById('time_input')


    $(document).ready(function() {

        checkQuotaByDateInput(dateInput.value)
        dateInput.addEventListener('input', function(e) {
            checkQuotaByDateInput(e.target.value)
        })

    })


    function checkQuotaByDateInput(dateInput) {
        infoAboutTicket.classList.remove("animate-horizontal-shaking")
        infoAboutTicket.innerHTML = spinnerComponent

        $.ajax({
            url: "<?= base_url('ticket/quota/check') ?>",
            type: "POST",
            dataType: 'json',
            data: {
                dateInput: dateInput,
                csrf_token_name: "<?= csrf_hash() ?>",
            },
            success: function(res) {
                console.log(res);
                if (res.status = 200) {
                    infoAboutTicket.innerHTML = res.message
                    infoAboutTicket.classList.add('animate-horizontal-shaking')
                };
            },
            complete: function(res) {

            },
            error: function(res) {
                if ((res.status = 401) && res.responseJSON) {
                    infoAboutTicket.innerHTML = res.responseJSON.message
                    infoAboutTicket.classList.add('animate-horizontal-shaking')
                };
            }
        });
    }
</script>
<?= $this->endSection('content'); ?>