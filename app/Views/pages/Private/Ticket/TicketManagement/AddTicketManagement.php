<div class="mt-2">
    <!-- The button to open modal -->
    <label for="addModal" class=" btn bg-blue-400 text-white btn-sm">Add Specific Quota By Date</label>
    <input type="checkbox" id="addModal" class="modal-toggle" />
    <div class="modal <?= session()->get("errors") ? 'modal-open' : 'modal-close' ?> " id="addModal">
        <div class="modal-box !w-fit !max-w-none text-black ">
            <h3 class="text-lg font-bold mb-4">Add Specific Quota By DateTime</h3>
            <?= form_open("/private/ticket/management/add", ['method' => 'POST']); ?>
            <?= csrf_field(); ?>
            <div class='flex flex-col justify-center w-[50vw] items-center xl:items-start xl:flex-row-reverse mx-auto gap-4'>
                <div class='w-full flex flex-col items-center gap-3'>
                    <?= component(
                        'Private/TimeInput',
                        [
                            'placeholder' => '',
                            'name' => 'the_day',
                            'value' => ''
                        ]
                    ); ?>
                </div>
                <div class='w-full flex flex-col items-center gap-3 '>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => 'Inoout Number ',
                            'type' => 'number',
                            'name' => 'quota_per_day',
                            'label' => 'Quota Per Day',
                            'value' => ''
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
                    }
                    ?>
                    <?= component(
                        'Private/SelectInputAll',
                        [
                            'label' => 'Status',
                            'name' => 'status',
                            'selected' => 'no',
                            'options' => $options
                        ]
                    ); ?>
                </div>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn btn-success">Add</button>
                <div>
                    <label for="addModal" class="btn btn-error">X</label>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>