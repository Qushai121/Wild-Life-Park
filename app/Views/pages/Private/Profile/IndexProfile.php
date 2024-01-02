<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>
<div class="flex gap-8 xl:flex-row flex-col wrapper_shadow">
    <div class="wrapper_shadow">
        <div class="flex flex-col gap-2">
            <h1 class="text-lg font-semibold"><?= auth()->user()->username; ?></h1>
            <div class="wrapperImagePreview flex flex-col gap-2">


                <?= validation_list_errors('alert_list'); ?>
                <?= form_open('private/profile', ["method" => "post", "enctype" => "multipart/form-data"]); ?>
                <?= csrf_field(); ?>
                <div class="flex flex-col gap-2 mt-4">
                    <input type="hidden" name="avatar_old" value="<?= auth()->user()->avatar; ?>" class="fileInput file-input file-input-bordered file-input-sm w-full max-w-xs" />
                    <?= component('Private/ImageInput', ['name' => 'avatar', 'src' => base_url("upload/avatars/" . auth()->user()->avatar)]); ?>
                    <div>
                        <h2 class="text-sm text-gray-500">Username</h2>
                        <input type="text" placeholder="Username" value="<?= auth()->user()->username; ?>" name="username" class="input input-bordered input-sm w-full max-w-xs" />
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-info">Edit</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <?php
    // ini khusu untuk para pekerja biar bisa bikin qr code
    // dan untuk smisal ada update data yang harus diisi bisa di tambah sendiri 
    // tanpa suuruh admin input satu satu jika terjadi update semisalnya  perlu bpjs dan npwp
    if (auth()->user()->inGroup('superadmin', 'dataentry', 'ticketguard', 'worker')) : ?>
        <div class="wrapper_shadow">
            <?= form_open('private/updateMyInfoWorker'); ?>
            <input type="hidden" name="_method" value="PUT">
            <div>
                <div class="flex flex-col gap-2 xl:w-[25vw]">
                    <div>
                        <p>Your Personal Information</p>
                    </div>
                    <div class="avatar">
                        <div class="w-56 rounded">
                            <img src="<?= $worker['qr_code'] ?? ' '; ?>" />
                        </div>
                    </div>
                    <div class="">
                        <?= component(
                            'Private/TextInput',
                            [
                                'name' => 'nik',
                                'label' => 'nik',
                                'attributes' => ['required'],
                                'value' => $worker['nik'] ?? '',
                            ]
                        ); ?>
                    </div>
                    <?= component(
                        'Private/SelectInputAll',
                        [
                            'name' => 'shift',
                            'options' => [
                                [
                                    'value' => 'morning',
                                    'label' => 'Morning'
                                ],
                                [
                                    'value' => 'night',
                                    'label' => 'Night'
                                ]
                            ],
                            'label' => 'Your Shift Now',
                            'selected' => $worker['shift'] ?? '',
                        ]
                    ); ?>
                    <div>
                        <button class="btn btn-info">Update Qr Code</button>
                    </div>
                </div>
            </div>
            <?php form_close() ?>
        </div>
    <?php endif; ?>
</div>
<?php if (auth()->user()->inGroup('superadmin', 'dataentry', 'ticketguard', 'worker')) : ?>
    <div class="wrapper_shadow">
        <div>
            <div id='calendar' class="w-full"></div>
        </div>
    </div>
<?php endif ?>

<script>
    let events = [];

    <?php foreach ($absents as $key => $absent) : ?>
        events.push({
            id: <?= $key ?>,
            title: <?= json_encode($absent['shift']) ?>,
            start: <?= json_encode($absent['created_at']) ?>,
            color: 'red',
            status: <?= json_encode($absent['status']) ?>,
            // Add more properties as needed
        });
    <?php endforeach ?>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events,
            eventContent: function(info) {
                return {
                    html: `<div class="${info.event.extendedProps.status == 'Present' || info.event.extendedProps.status == 'To Fast' ? 'bg-blue-200' : 'bg-red-200' } flex flex-col gap-4  w-full font-bold rounded-lg items-center py-2">
                    <div class='flex gap-1'>
                    ${info.event.title == 'night' ? 
                            `
                            <div class="flex items-center gap-2" >
                            <img src="<?= base_url('assets/icons/night.svg'); ?>" alt="" srcset="">
                            <p class="text-lg">${info.event.title}</p>
                            </div>
                            `
                            : 
                            `
                            <div class="flex items-center gap-2">
                            <img src="<?= base_url('assets/icons/morning.svg'); ?>" alt="" srcset="">
                            <p class="text-lg">${info.event.title}</p>
                            </div>
                            `
                    }
                </div>
                <div class='flex gap-1'>
                <h3>status: </h3>
                <p> ${info.event.extendedProps.status}</p>
                </div>
                </div>
                `
                };
            }
        });
        calendar.getOption('locale', 'id');
        calendar.render();
    });
</script>

<?= $this->endSection('content'); ?>


<!-- $this->extend('templates/PrivatePages') ?>
$this->section('content'); ?>
<div class="wrapper_shadow">
    <div class="flex flex-col gap-2">
        <h1 class="text-lg font-semibold">auth()->user()->username; ?></h1>
        <div class="wrapperImagePreview flex flex-col gap-2">
            <
            $image = auth()->user()->avatar ? "upload/avatars/" . auth()->user()->avatar : "assets/images/avatar-default.svg";
            ?>

            validation_list_errors('alert_list'); ?>
            <img src="base_url($image) ?>" alt="" class="removeable h-40 w-40 object-cover overflow-hidden">
            <img src="base_url($image) ?>" alt="" class="imagePreview h-40 w-40 object-cover overflow-hidden">
            form_open('private/profile', ["method" => "post", "enctype" => "multipart/form-data"]); ?>
            csrf_field(); ?>
            <div class="flex flex-col gap-2 mt-4">
                <div>
                    <h2 class="text-sm text-gray-500">Avatar</h2>
                    <input type="file" name="avatar" class="fileInput file-input file-input-bordered file-input-sm w-full max-w-xs" />
                    <input type="hidden" name="avatar_old" value="auth()->user()->avatar; ?>" class="fileInput file-input file-input-bordered file-input-sm w-full max-w-xs" />
                </div>
                <div>
                    <h2 class="text-sm text-gray-500">Username</h2>
                    <input type="text" placeholder="Username" value="auth()->user()->username; ?>" name="username" class="input input-bordered input-sm w-full max-w-xs" />
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn">Edit</button>
            </div>
            form_close(); ?>
        </div>
    </div>
</div>

$this->endSection('content'); ?> -->