<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>

<div class="wrapper_shadow h-[80vh] ">
    <?= form_open('private/worker', ["method" => "post", "enctype" => "multipart/form-data"]); ?>
    <div class='flex flex-col gap-4 items-center '>
        <div class=' flex flex-col gap-3'>
            <div class='my-4 rounded-lg bg-base_secondary bg-opacity-25'>
                <h1 class='text-xl font-semibold text-start'>Add Worker</h1>
            </div>
            <div class='flex flex-col justify-center w-[50vw] items-center xl:items-start xl:flex-row mx-auto gap-4'>
                <div class='w-full flex flex-col items-center gap-3'>
                    <?= component(
                        'Private/TextInput',
                        [
                            'name' => 'nik',
                            'label' => 'nik',
                            'attributes' => ['required'],
                            'value' => old('nik'),
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'name' => 'shift',
                            'label' => 'shift',
                            'attributes' => ['required'],
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'name' => 'username',
                            'label' => 'Username',
                            'attributes' => ['required'],
                            'value' => old('username'),
                        ]
                    ); ?>
                    <div class="w-full">
                        <?= component(
                            'Private/ImageInput',
                            [
                                'label' => 'avatar',
                                'name' => 'avatar',

                            ]
                        ); ?>
                    </div>
                </div>
                <div class='w-full flex flex-col items-center gap-3 '>
                    <?= component(
                        'Private/TextInput',
                        [
                            'name' => 'email',
                            'label' => 'email',
                            'type' => 'email',
                            'attributes' => ['required'],
                            'value' => old('email'),
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'name' => 'password',
                            'label' => 'Password',
                            'type' => 'password',
                            'attributes' => ['required']
                        ]
                    ); ?>
                    <?= component(
                        'Private/TextInput',
                        [
                            'name' => 'password_confirm',
                            'label' => 'Password',
                            'type' => 'password',
                            'attributes' => ['required']
                        ]
                    ); ?>
                    <?= component(
                        'Private/SelectInput',
                        [
                            'name' => 'role',
                            'options' => $role,
                            'values' => array_keys($role),
                            'labels' =>  array_values(array_column($role, 'title')),
                            'selected' => old('role'),
                        ]
                    ); ?>
                </div>
            </div>

            <div class='mb-5 flex justify-end gap-4'>
                <div>
                    <button type='submit' class='btn-sm btn bg-blue-400'>Add Worker</button>
                </div>
            </div>
        </div>
    </div>
    <?= form_close(); ?>
</div>

<?= $this->endSection('content'); ?>