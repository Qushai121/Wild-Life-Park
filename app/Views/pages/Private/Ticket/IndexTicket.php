<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>

<?php $request = \Config\Services::request(); ?>


<div class="flex gap-6 w-full">

    <div class="wrapper_shadow !w-fit">
        <a href="<?= base_url('private/ticket/new'); ?>">
            <div class="btn bg-green-400 text-gray-50">
                Add Ticket
            </div>
        </a>
    </div>
    <form action="<?= current_url(); ?>" method="get" class="w-full">

        <div class="wrapper_shadow flex justify-end flex-shrink ">
            <?= component(
                'Private/Search',
                [
                    'request' => $request
                ]
            ); ?>
        </div>


    </form>
</div>


<div class="wrapper_shadow">
    <div class="overflow-x-auto h-[60vh] min-w-full">
        <table id="table" class="">
            <thead>
                <tr class="text-gray-500">
                    <th>Name Ticket</th>
                    <th>Description</th>
                    <th>Access</th>
                    <th>Discount</th>
                    <th>Price</th>
                    <th>Price + Discount</th>
                    <th>Quantity</th>
                    <th>Publish</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($listTickets as $key => $listTicket) : ?>
                    <tr class="text-gray-100">
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listTicket['name']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listTicket['description']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listTicket['access']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listTicket['discount']; ?>%</p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= toRupiah($listTicket['price']); ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge ">
                                    <?= toRupiah(discountPrice($listTicket['price'], $listTicket['discount'])); ?>
                                </p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listTicket['qty']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listTicket['publish']; ?></p>
                            </div>
                        </td>

                        <td>
                            <div>
                                <?= pages('Private/Ticket/editTicket', ['key' => $key, 'listTicket' => $listTicket]); ?>
                            </div>
                            <div>
                                <?= pages('Private/Ticket/DeleteTicket', ['key' => $key, 'listTicket' => $listTicket]); ?>
                            </div>
                        </td>


                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>


<div class="wrapper_shadow">
    <?= $pager->simpleLinks('default', 'private_full'); ?>
</div>

<?= $this->endSection('content'); ?>