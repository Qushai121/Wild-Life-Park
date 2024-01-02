<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>
<?php $request = \Config\Services::request(); ?>

<div class="flex xl:flex-row flex-col gap-6">
    <div class="flex gap-2 xl:flex-none">
        <div class="wrapper_shadow !max-w-max ">
            <a href="<?= base_url('private/galery/new'); ?>">
                <div class="btn bg-green-400 text-gray-50">
                    Add Galery
                </div>
            </a>
        </div>
        <form action="<?= current_url(); ?>">

    </div>
    <!-- <div> -->
    <div class="wrapper_shadow flex justify-end flex-shrink ">
        <?= component(
            'Private/Search',
            [
                'request' => $request
            ]
        ); ?>
    </div>
    <div class="wrapper_shadow flex justify-end flex-shrink ">
        <?= component(
            'Private/PerPageSelect',
            [
                'request' => $request
            ]
        ); ?>
    </div>
    </form>
    <!-- </div> -->

</div>

<div class="wrapper_shadow">
    <div class="overflow-x-auto h-[60vh] min-w-full">
        <table id="table" class="">
            <thead>
                <tr class="text-gray-500">
                    <th>Username</th>
                    <th>Avatar</th>
                    <th>nik</th>
                    <th>shift</th>
                    <th>Qr Code</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($listWorkers as $key => $listWorker) : ?>
                    <tr class="text-gray-100">
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listWorker['username']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="avatar">
                                <div class="w-24 rounded">
                                    <img src="<?= base_url('upload/avatars/' . $listWorker['avatar']); ?>" />
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listWorker['nik']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listWorker['shift']; ?></p>
                            </div>
                        </td>

                        <td>
                            <div class="avatar">
                                <div class="w-24 rounded">
                                    <img src="<?= $listWorker['qr_code']; ?>" />
                                </div>
                            </div>
                        </td>

                        <td>
                            <div>
                                asdads
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