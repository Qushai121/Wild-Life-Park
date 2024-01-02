<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>

<div class="wrapper_shadow h-[80vh] ">
    <?= form_open('private/ticket', ["method" => "post", "enctype" => "multipart/form-data"]); ?>
    <div class='flex flex-col gap-4 items-center '>
        <div class=' flex flex-col gap-3'>
            <div class='my-4 rounded-lg bg-base_secondary bg-opacity-25'>
                <h1 class='text-xl font-semibold text-start'>Add Ticket</h1>
            </div>
            <div class='flex flex-col justify-center w-[50vw] items-center xl:items-start xl:flex-row mx-auto gap-4'>
                <div class='w-full flex flex-col items-center gap-3'>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'name' => 'name',
                            'label' => 'Name',
                            'value' => old('name')
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'name' => 'description',
                            'label' => 'Description',
                            'value' => old('description')
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'name' => 'access',
                            'label' => 'Access',
                            'value' => old('access')
                        ]
                    ); ?>
                    <?= component(
                        'Private/ImageInput',
                        [
                            'name' => 'image'
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
                            'value' => old('discount')
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'type' => 'number',
                            'name' => 'price',
                            'label' => 'Price',
                            'value' => old('price')
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'type' => 'number',
                            'name' => 'qty',
                            'label' => 'Quantity',
                            'value' => old('qty')
                        ]
                    ); ?>

                    <?= component(
                        'Private/TextInput',
                        [
                            'placeholder' => '',
                            'type' => 'number',
                            'name' => 'totalqrcode',
                            'label' => 'Total Of Qr Code User Get',
                            'value' => old('totalqrcode')
                        ]
                    ); ?>
                    <?= component(
                        'Private/SelectInputAll',
                        [
                            'label' => 'publish',
                            'name' => 'publish',
                            'options' => [
                                [
                                    'value' => 'publish',
                                    'label' => 'Publish Now'
                                ],
                                [
                                    'value' => 'no',
                                    'label' => 'No Later'
                                ],
                            ]
                        ]
                    ); ?>
                </div>
            </div>

            <div class='mb-5 flex justify-end gap-4'>
                <div>
                    <button type='submit' class='btn-sm btn bg-blue-400 text-gray-50 '>Save Ticket</button>
                </div>
            </div>
        </div>
    </div>
    <?= form_close(); ?>
</div>

<?= $this->endSection('content'); ?>