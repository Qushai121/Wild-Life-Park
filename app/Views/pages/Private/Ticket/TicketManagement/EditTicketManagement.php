<div class="mt-2">
    <!-- The button to open modal -->
    <label for="edit<?= $listTicketManagement['id']; ?>" class=" btn bg-blue-400 text-white btn-sm">Detail & Edit</label>
    <input type="checkbox" id="edit<?= $listTicketManagement['id']; ?>" class="modal-toggle" />
    <div class="modal <?= session()->get("errors" . $listTicketManagement["id"]) ? 'modal-open' : 'modal-close' ?> " id="edit<?= $listTicketManagement['id']; ?>">
        <div class="modal-box !w-fit !max-w-none text-black ">
            <h3 class="text-lg font-bold">Apakah Anda Yakin Mengedit Quota Tanggal ?</h3>
            <p class="py-4"><?= $listTicketManagement['the_day']; ?></p>
            <?= form_open("/private/ticket/management/edit/" . encrypt_url($listTicketManagement['id']), ['method' => 'POST']); ?>
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <div class='flex flex-col justify-center w-[50vw] items-center xl:items-start xl:flex-row-reverse mx-auto gap-4'>
                <div class='w-full flex flex-col items-center gap-3'>
                    <?= component(
                        'Private/TimeInput',
                        [
                            'placeholder' => '',
                            'name' => 'the_day',
                            'value' => $listTicketManagement['the_day'],
                            'id' => $listTicketManagement['id']
                        ]
                    ); ?>
                </div>
                <div class='w-full flex flex-col items-center gap-3 '>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => 'input 10 will convert to 10%',
                            'type' => 'number',
                            'name' => 'quota_per_day',
                            'label' => 'Quota Per Day',
                            'value' => $listTicketManagement['quota_per_day']
                        ]
                    ); ?>
                    <?php
                    $options = null;
                    if ($ticketManagementMain) {

                        $options = [
                            [
                                'value' => 'apply',
                                'label' => 'Apply'
                            ],
                            [
                                'value' => 'no',
                                'label' => 'No'
                            ],
                        ];
                    } else {
                        $options = [
                            [
                                'value' => 'apply',
                                'label' => 'Apply'
                            ],
                            [
                                'value' => 'no',
                                'label' => 'No'
                            ],
                            [
                                'value' => 'to_all_date',
                                'label' => 'to all Date',
                            ],
                        ];
                    } ?>
                    <?= component(
                        'Private/SelectInputAll',
                        [
                            'label' => 'Status',
                            'name' => 'status',
                            'id' => $listTicketManagement['id'],
                            'selected' => $listTicketManagement['status'],
                            'options' => $options
                        ]
                    ); ?>
                </div>
            </div>
            <div class="modal-action">
                <button type="submit" class="btn btn-success">Edit</button>
                <div>
                    <label for="edit<?= $listTicketManagement['id']; ?>" class="btn btn-error">X</label>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>