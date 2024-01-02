<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>

<div class="wrapper_shadow h-[80vh] ">
    <!-- ?= validation_list_errors('alert_list'); ?> -->
    <?= form_open('private/galery', ["method" => "post", "enctype" => "multipart/form-data"]); ?>
    <div class='flex flex-col gap-4 items-center '>
        <div class='w-fit flex flex-col gap-3'>
            <div class='my-4 p-2 rounded-lg bg-base_secondary bg-opacity-25'>
                <h1 class='text-xl font-semibold text-center'>Add Galery</h1>
            </div>
            <div class='flex flex-col xl:flex-row mx-auto gap-4'>
                <div class='xl:w-[25vw] flex flex-col gap-3'>
                    <?= component(
                        'Private/TextInput',
                        [
                            'name' => 'title',
                            'label' => 'Title',
                            'value' => old('title')
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'name' => 'description',
                            'label' => 'Description',
                            'value' => old('description')
                        ]
                    ); ?>
                    <?= component(
                        'pRivate/SelectInputAll',
                        [
                            'label' => 'Type',
                            'name' => 'type',
                            'options' => [
                                [
                                    'value' => 'human',
                                    'label' => 'Human'
                                ],
                                [
                                    'value' => 'animal',
                                    'label' => 'Animal'
                                ],
                            ]
                        ]
                    ); ?>
                </div>
                <?= component(
                    'Private/ImageInput',
                    [
                        'name' => 'images'
                    ]
                ); ?>
            </div>
            <div class='mb-5 flex justify-end gap-4'>
                <div>
                    <button type='submit' class='btn-sm btn bg-blue-400'>Add Product</button>
                </div>
            </div>
        </div>
    </div>
    <?= form_close(); ?>
</div>

<?= $this->endSection('content'); ?>