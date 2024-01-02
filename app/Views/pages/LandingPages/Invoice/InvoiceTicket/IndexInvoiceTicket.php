<?= $this->extend('templates/LandingPages') ?>
<?= $this->section('content'); ?>


<div class="w-full ">
    <?= component('LandingPages/TopBar'); ?>
</div>


<div class="overflow-x-auto ">
    <table class="table">
        <!-- head -->
        <thead>
            <tr class="text-gray-500 text-xl">
                <th>Transaction Time</th>
                <th>Order Id</th>
                <th>Status</th>
                <th>Total Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoiceDatas as $invoiceData) : ?>
                <tr class="text-stone-800 text-lg">
                    <td>
                        <div class="flex flex-col ">
                            <p><?= format_datetime($invoiceData['created_at']); ?></p>
                        </div>
                    </td>
                    <td>
                        <div class="flex flex-col ">
                            <a href="/mypurchase/ticket/invoice/<?= $invoiceData['order_id']; ?>" class="text-blue-400"><?= $invoiceData['order_id']; ?></a>
                        </div>
                    </td>
                    <td>
                        <div class="flex flex-col ">
                            <p><?= $invoiceData['status']; ?></p>
                        </div>
                    </td>
                    <td>
                        <div class="flex flex-col ">
                            <p><?= $invoiceData['total_quantity_all']; ?></p>
                        </div>
                    </td>
                    <td>
                        <div class="flex flex-col ">
                            <p><?= toRupiah($invoiceData['total_price_then_all']); ?></p>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


<?= $this->endSection('content'); ?>