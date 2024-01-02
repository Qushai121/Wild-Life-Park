<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>
<?php $request = \Config\Services::request(); ?>

<div class="flex gap-6 w-full">

    <div class="wrapper_shadow !w-fit">
        <a href="<?= base_url('private/news/new'); ?>">
            <div class="btn bg-green-400 text-gray-50">
                Add News
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
                    <th>Author</th>
                    <th>Content</th>
                    <th>Background Image</th>
                    <th>Publish / No</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($listNewss as $key => $listNews) : ?>
                    <tr class="text-gray-800 font-semibold">
                        <td>
                            <div class="flex flex-col ">
                                <p><?= $listNews['title']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p><?= $listNews['username']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <a href="">Detail Blog </a>
                            </div>
                        </td>
                        <td>
                            <div class="avatar">
                                <div class="w-24 rounded">
                                    <img src="<?= base_url('upload/news/' . $listNews['background_image']); ?>" />
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p><?= $listNews['publish']; ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p><?= format_datetime($listNews['created_at']); ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col ">
                                <p><?= format_datetime($listNews['updated_at']); ?></p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <a href="/private/news/<?= encrypt_url($listNews['news_id']); ?>/edit" class="btn btn-info btn-sm">Edit</a>
                            </div>
                            <div>
                                <?= pages('Private/News/deleteNews', ['key' => $key, 'listNews' => $listNews]); ?>
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