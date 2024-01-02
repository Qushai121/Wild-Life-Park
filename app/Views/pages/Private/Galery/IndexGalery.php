<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>
<?php $request = \Config\Services::request(); ?>

<div class="flex gap-6 w-full">

    <div class="wrapper_shadow !w-fit">
        <a href="<?= base_url('private/galery/new'); ?>">
            <div class="btn bg-green-400 text-gray-50">
                Add Galery
            </div>
        </a>
    </div>
    <form action="<?= current_url(); ?>" method="get" class="w-full flex gap-6">

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
</div>

<div class="wrapper_shadow">
    <div class="overflow-x-auto h-[60vh] min-w-full">
        <table id="table" class="">
            <thead>
                <tr class="text-gray-500 !text-sm">
                    <th>Title</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($listGalerys as $key => $listGalery) : ?>
                    <tr class="text-gray-800 font-semibold">
                        <td>
                            <div class="flex flex-col ">
                                <p><?= $listGalery['title']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="avatar">
                                <div class="w-24 rounded">
                                    <img src="<?= base_url('upload/galerys/' . $listGalery['images']); ?>" />
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p><?= $listGalery['description']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p><?= $listGalery['type']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <?= pages('Private/Galery/editGalery', ['key' => $key, 'listGalery' => $listGalery]); ?>
                            </div>
                            <div>
                                <?= pages('Private/Galery/deleteGalery', ['key' => $key, 'listGalery' => $listGalery]); ?>
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