<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>

<?php $request = \Config\Services::request(); ?>

<div class="wrapper_shadow min-h-[90vh]">
    <div  >
        <form action="/private/ticket/management/edit/<?= encrypt_url($TicketManagementMain ? $TicketManagementMain['id'] : null); ?>" method="post" class="wrapper_shadow xl:!w-[30%]">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="status" value="to_all_date">
            <h1>Quota Ticket Per Day</h1>
            <p class="text-sm font-light">This Will Be Apply To All Day</p>
            <div class="pt-2 flex flex-col gap-4">
                <?= component(
                    'Private/TextInput',
                    [
                        'type' => 'number',
                        'name' => 'quota_per_day',
                        'label' => 'Quota Per Day',
                        'value' => $TicketManagementMain['quota_per_day'] ?? null
                    ]
                ); ?>

                <div class='mb-5 flex justify-end gap-4'>
                    <div>
                        <button type='submit' class='btn-sm btn bg-blue-400'>Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="my-4">
            <?= PrivatePages('Ticket/TicketManagement/addTicketManagement',['ticketManagementMain' => $TicketManagementMain]); ?>
        </div>
    </div>


    <div class="wrapper_shadow">
        <div class="overflow-x-auto h-[60vh] min-w-full">
            <table id="table" class="">
                <thead>
                    <tr class="text-gray-500 !text-sm">
                        <th>Quota Per Day</th>
                        <th>Status</th>
                        <th>Specific Day To Appyl</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($listTicketManagements as $key => $listTicketManagement) : ?>
                        <tr class="text-gray-800 font-semibold">
                            <td>
                                <div class="flex flex-col ">
                                    <p><?= $listTicketManagement['quota_per_day']; ?></p>
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-col ">
                                    <p><?= $listTicketManagement['status']; ?></p>
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-col ">
                                    <p><?= format_datetime($listTicketManagement['the_day']); ?></p>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <?= PrivatePages('Ticket/TicketManagement/editTicketManagement', ['key' => $key, 'listTicketManagement' => $listTicketManagement ,'ticketManagementMain' => $TicketManagementMain]); ?>
                                </div>
                                <div>
                                    delete
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
</div>


<?= $this->endSection('content'); ?>