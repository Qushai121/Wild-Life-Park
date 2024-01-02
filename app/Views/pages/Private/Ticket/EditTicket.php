<div class="mt-2">
    <!-- The button to open modal -->
    <label for="edit<?= $listTicket['id']; ?>" class=" btn bg-blue-400 text-white btn-sm">Detail & Edit</label>
    <input type="checkbox" id="edit<?= $listTicket['id']; ?>" class="modal-toggle" />
    <div class="modal <?= session()->get("errors" . $listTicket["id"]) ? 'modal-open' : 'modal-close' ?> " id="edit<?= $listTicket['id']; ?>">
        <div class="modal-box !w-fit !max-w-none text-black ">
            <h3 class="text-lg font-bold">Apakah Anda Yakin Mengedit ?</h3>
            <p class="py-4"><?= $listTicket['name']; ?></p>
            <?= form_open("private/ticket/$listTicket[id]", ['method' => 'POST', "enctype" => "multipart/form-data"]); ?>
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <div class='flex flex-col justify-center w-[50vw] items-center xl:items-start xl:flex-row mx-auto gap-4'>
                <div class='w-full flex flex-col items-center gap-3'>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'type' => 'text',
                            'name' => 'name',
                            'label' => 'Name',
                            'value' => $listTicket['name'],
                            'id' => $listTicket['id']
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'type' => 'text',
                            'name' => 'description',
                            'label' => 'Description',
                            'value' => $listTicket['description'],
                            'id' => $listTicket['id']

                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'type' => 'text',
                            'name' => 'access',
                            'label' => 'Access',
                            'value' => $listTicket['access'],
                            'id' => $listTicket['id']

                        ]
                    ); ?>
                    <input type="hidden" value="<?= $listTicket['image']; ?>" name="imageOld">
                    <?= component(
                        'Private/ImageInput',
                        [
                            'src' => base_url('upload/tickets/' . $listTicket['image']),
                            'name' => 'image',
                            'id' => $listTicket['id']
                        ]
                    ); ?>
                </div>
                <div class='w-full flex flex-col items-center gap-3 '>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => 'input 10 will convert to 10%',
                            'type' => 'number',
                            'name' => 'discount',
                            'label' => 'discount',
                            'value' => $listTicket['discount']
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'type' => 'number',
                            'name' => 'price',
                            'label' => 'Price',
                            'value' => $listTicket['price']
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'type' => 'number',
                            'name' => 'qty',
                            'label' => 'Quantity',
                            'value' => $listTicket['qty']
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'type' => 'number',
                            'name' => 'totalqrcode',
                            'label' => 'Total Qr Code User Will Get',
                            'value' => $listTicket['totalqrcode']
                        ]
                    ); ?>
                    <?= component(
                        'Private/SelectInputAll',
                        [
                            'label' => 'publish',
                            'name' => 'publish',
                            'id' => $listTicket['id'],
                            'selected' => $listTicket['publish'],
                            'options' => [
                                [
                                    'value' => 'publish',
                                    'label' => 'Publish Now'
                                ],
                                [
                                    'value' => 'no',
                                    'label' => 'Later'
                                ],
                            ]
                        ]
                    ); ?>
                </div>
            </div>
            <div class="modal-action">
                <button type="submit" class="btn btn-success">Edit</button>
                <div>
                    <label for="edit<?= $listTicket['id']; ?>" class="btn btn-error">X</label>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>