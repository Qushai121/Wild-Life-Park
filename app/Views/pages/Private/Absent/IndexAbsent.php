<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>


<?php $request = \Config\Services::request(); ?>

<div class="flex xl:flex-row flex-col gap-6">
    <div class="flex gap-2 xl:flex-none">
        
        <form action="<?= current_url(); ?>">
            <div class="wrapper_shadow">
                <?= component(
                    'Private/TimeSearch',
                    [
                        'request' => $request
                    ]
                ); ?>
            </div>
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
                    <th>Employee Name</th>
                    <th>Avatar</th>
                    <th>Shift</th>
                    <th>Status</th>
                    <th>Absent Time</th>
                    
                </tr>
            <tbody>
                <?php foreach ($listAbsents as $key => $listAbsent) : ?>
                    </thead>
                    <tr class="text-gray-100">
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listAbsent['username']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="avatar">
                                <div class="w-24 rounded">
                                    <img src="<?= base_url('upload/avatars/') . $listAbsent['avatar']; ?>" />
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listAbsent['shift']; ?></p>
                            </div>
                        </td>

                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= $listAbsent['status']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p class="badge "><?= format_datetime($listAbsent['created_at']); ?></p>
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