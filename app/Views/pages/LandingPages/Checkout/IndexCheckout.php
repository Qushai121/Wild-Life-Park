<?= $this->extend('templates/LandingPages') ?>
<?= $this->section('content'); ?>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= env('MIDTRANS.CLIENT_KEY'); ?>"></script>
<link rel="stylesheet" href="<?= base_url('css/flatpickr.min.css'); ?>">

<div class="w-full ">
    <?= component('LandingPages/TopBar'); ?>
</div>


<?php
$checkOutEmpty = count($listTickets) == 0;

?>

<pre><div id="result-json"><br></div></pre>
<div class="xl:px-64">

    <div role="alert" class="alert bg-stone-200">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-lg text-stone-800 font-semibold items-center flex">After Succesfully Pay The Ticket Check <a href="mypurchase/ticket/invoice" class="btn btn-sm btn-success mx-2">My Purchase</a>Menu</span>
    </div>

</div>
<div class="flex flex-col relative xl:flex-row w-full xl:px-64">
    <?php if ($checkOutEmpty) : ?>
        <div class=" w-full text-center flex flex-col mt-10 gap-5">
            <p class="text-2xl font-bold">List CheckOut Have 0 Value </p>
            <div class="w-full">
                <a href="/ticket" class="btn btn-info text-white">Check Out Ticket Here</a>
            </div>
        </div>
    <?php else : ?>
        <div class="flex flex-col gap-6 w-full xl:w-[70%] mt-10 xl:mb-1 mb-20">
            <?php foreach ($listTickets as $key => $listTicket) : ?>
                <div class="bg-stone-200 text-lg font-semibold rounded-xl xl:h-fit pb-4 mx-6">
                    <div class="flex flex-col xl:flex-row gap-4 w-full xl:mt-3">
                        <div class="w-full xl:w-[70%] xl:ml-4">
                            <img class="h-56 w-full object-center object-cover" src="<?= base_url("upload/tickets/$listTicket[image]"); ?>" alt="">
                        </div>
                        <div class="w-[80vw] mx-4 ">
                            <h1 class="text-xl font-bold ">
                                <?= $listTicket['name']; ?>
                            </h1>
                            <h1 class="xl:mt-2 text-md font-normal">
                                <?= $listTicket['description']; ?>
                            </h1>
                            <h1 class="text-md font-normal">
                                Access to : <?= $listTicket['access']; ?>
                            </h1>

                            <div class="flex gap-2 xl:my-1">
                                <div class="relative h-12 w-fit">
                                    <p class="<?= $listTicket['discount'] > 0 ? 'line-through text-md font-light' : ''; ?> "><?= toRupiah($listTicket['price']); ?></p>
                                    <?php if ($listTicket['discount'] > 0) : ?>
                                        <p class="absolute bottom-1 whitespace-nowrap"><?= $listTicket['discount']; ?>% OFF</p>
                                    <?php endif ?>
                                </div>
                                <?php if ($listTicket['discount'] > 0) : ?>
                                    <p><?= toRupiah($listTicket['total_price_discount']); ?></p>
                                <?php endif ?>
                            </div>
                            <div class="flex justify-between">
                                <div>
                                    <?= form_open("checkout/delete/$listTicket[id]"); ?>
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="tickets btn text-stone-800"><i class="fa fa-trash"></i></button>
                                    <?= form_close() ?>
                                </div>
                                <div class="float-right flex gap-2">
                                    <?= form_open("checkout/update/$listTicket[id]"); ?>
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" class="input" name="quantityminus" id="quantity" min="1" value="-1">
                                    <input type="hidden" name="product_id" id="" value="<?= $listTicket['id']; ?>">
                                    <button type="submit" class="tickets btn ">-</button>
                                    <?= form_close() ?>
                                    <?= form_open("checkout/update/$listTicket[id]"); ?>
                                    <?= csrf_field(); ?>
                                    <div class="flex flex-col justify-center items-center gap-2">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="number" class="w-24 input" class="input" name="quantity" id="quantity" value="<?= $listTicket['quantity'] ?>">
                                        <input type="hidden" name="product_id" id="" value="<?= $listTicket['id']; ?>">
                                        <button type="submit" class="tickets btn ">Edit By Input</button>
                                    </div>
                                    <?= form_close() ?>
                                    <?= form_open("checkout/update/$listTicket[id]"); ?>
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" class="input" name="quantityplus" id="quantity" min="1" value="1">
                                    <input type="hidden" name="product_id" id="" value="<?= $listTicket['id']; ?>">
                                    <button type="submit" class="tickets btn ">+</button>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>


    <div class="w-full relative top-10 z-10 text-black">
        <div class="xl:sticky fixed xl:top-72 bottom-0 w-full">
            <div class="hidden xl:flex flex-col gap-2 my-2">

                <?php
                $totalQrCode = 0;
                foreach ($listTickets as $key => $listTicket) : ?>
                    <?php $totalQrCode += $listTicket['totalqrcode'] * $listTicket['quantity']; ?>
                    <div class="h-fit py-1 px-4 flex justify-between bg-stone-200 border-[1px] rounded-lg border-stone-400">
                        <div>
                            <h1><?= $listTicket['name'] ?></h1>
                            <div class="flex gap-2 ">
                                <div class="relative h-12 w-fit">
                                    <p class="<?= $listTicket['discount'] > 0 ? 'line-through text-md font-light' : ''; ?> "><?= toRupiah($listTicket['price']) . ' ' . ' x ' . ' ' . $listTicket['quantity']; ?></p>
                                    <?php if ($listTicket['discount'] > 0) : ?>
                                        <p class="absolute bottom-1 whitespace-nowrap"><?= $listTicket['discount']; ?>% OFF</p>
                                    <?php endif ?>
                                </div>
                                <?php if ($listTicket['discount'] > 0) : ?>
                                    <p><?= toRupiah($listTicket['total_price_discount']) . ' ' . ' x ' . ' ' . $listTicket['quantity']; ?></p>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="flex flex-col justify-end items-end">
                            <p>Total</p>
                            <p>
                                <?= toRupiah($listTicket['total_price_discount'] * $listTicket['quantity']) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            <div>

            </div>
            <div class="w-full xl:border-2  xl:rounded-md h-14 top-12 border-t-[1px] border-stone-400 bg-stone-50 px-4">
                <div class="flex w-full h-full items-center justify-between gap-2 px-6">
                    <div class="text-start  text-md font-semibold">
                        <p>Total</p>
                        <p><?= toRupiah($total); ?></p>
                    </div>
                    <div>
                        <!-- The button to open modal -->
                        <label for="my_modal_6" class="btn !bg-green-400 text-white disabled:!bg-stone-400">Pay</label>

                        <!-- Put this part before </body> tag -->
                        <input type="checkbox" id="my_modal_6" class="modal-toggle" />
                        <div class="modal" role="dialog">
                            <div class="modal-box">
                                <div class="text-start flex w-full justify-between mb-2 text-md font-semibold">
                                    <p id="infoAboutTicket" class=" w-full text-white btn btn-info "></p>
                                </div>
                                <div class="text-start flex justify-between text-md font-semibold">
                                    <p>E-Ticket You Get </p>
                                    <p><?= $totalQrCode . "x"; ?></p>
                                </div>
                                <div class="text-start flex justify-between text-md font-semibold">
                                    <p>Total</p>
                                    <p><?= toRupiah($total); ?></p>
                                </div>
                                <?php
                                $currentDateTime = new DateTime();

                                $oneYearLaterDateTime = clone $currentDateTime;
                                
                                $oneYearLaterDateTime->add(new DateInterval('P1Y'));
                                ?>
                                <div class="flex flex-col gap-2 mt-4">
                                    <p class="font-semibold text-xl">What Time You Want Check In</p>
                                    <input type="time" value="<?= $currentDateTime->format('Y-m-d H:i:s'); ?>" min="<?= $currentDateTime->format('Y-m-d'); ?>" max="<?= $oneYearLaterDateTime->format('Y-m-d'); ?>" id="time_input" class="border-gray-400" name="time" required>
                                </div>
                                <div class="modal-action">
                                    <button <?= $checkOutEmpty ? "disabled " : ''  ?> onclick="pay()" class="btn !bg-green-400 text-white disabled:!bg-stone-400">Pay<span>(<?= $qtyTotal; ?>)</span></button>
                                    <label for="my_modal_6" class="btn btn-error">Close!</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="<?= base_url('js/flatpickr.min.js'); ?>"></script>
<script>
    flatpickr("#time_input", {
        maxDate:"<?= $oneYearLaterDateTime->format("Y-m-d") ?>",
        minDate:"today",
        locale: "id",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    })
</script>

<?php if (!$checkOutEmpty && auth()->user()) : ?>
    <script>
        let spinnerComponent = '<span class="loading loading-spinner loading-lg"></span>'
        
        let infoAboutTicket = document.getElementById('infoAboutTicket')
        let dateInput = document.getElementById('time_input')
        <?php
        $data = [];
        foreach ($listTickets as $key => $listTicket) {
            $data[] = [
                'productid' => $listTicket['id'],
                'qty' => $listTicket['quantity'],
            ];
        } ?>

        var data = <?= json_encode($data) ?>;

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

        function pay() {
            infoAboutTicket.classList.remove("animate-horizontal-shaking")
            infoAboutTicket.innerHTML = spinnerComponent

            <?php if (session()->getFlashdata("authMessage") || !auth()->user()) : ?>
                showModalMustLogin()
            <?php endif ?>



            $.ajax({
                url: "<?= base_url('payment/ticket') ?>",
                type: "POST",
                dataType: 'json',
                data: {
                    productData: data,
                    dateInput: dateInput.value,
                    csrf_token_name: "<?= csrf_hash() ?>",
                },
                success: function(res) {
                    midtransSnap(res.result)
                },
                complete: function(res) {

                },
                error: function(res) {
                    if (res.responseJSON.message) {
                        infoAboutTicket.innerHTML = res.responseJSON.message
                        infoAboutTicket.classList.add('animate-horizontal-shaking')
                    };
                }
            });
        }

        function midtransSnap(token) {
            snap.pay(token);
        }

        function deleteCheckout() {
            $.ajax({
                url: "<?= base_url('delete/checkout/all') ?>",
                type: "POST",
                dataType: 'json',
                complete: function(res) {
                    location.reload()
                },
            });
        }

        function createTransactionTicket(order_id, token, dateInput) {
            $.ajax({
                url: "<?= base_url('payment/ticket/create/transaction') ?>",
                type: "POST",
                dataType: 'json',
                data: {
                    productData: data,
                    order_id: order_id,
                    snap_token: token,
                    dateInput: dateInput,
                    csrf_token_name: "<?= csrf_hash() ?>",
                },
                complete: function(res) {
                    deleteCheckout();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle error
                    console.error("AJAX Error: ", textStatus, errorThrown);
                },

            });
        }
    </script>
<?php else : ?>
    <script>
        function pay() {
            <?php if (session()->getFlashdata("authMessage") || !auth()->user()) : ?>
                showModalMustLogin()
            <?php endif ?>
        }
    </script>
<?php endif ?>
<?= $this->endSection('content'); ?>