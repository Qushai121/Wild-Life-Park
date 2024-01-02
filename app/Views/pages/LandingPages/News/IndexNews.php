<?= $this->extend('templates/LandingPages') ?>
<?= $this->section('content'); ?>
<?php $request = \Config\Services::request(); ?>
<link rel="stylesheet" href="<?= base_url('css/flatpickr.min.css'); ?>">
<div class="w-full ">
    <?= component('LandingPages/TopBar'); ?>
</div>


<div class="xl:w-[60vw] min-h-[60vh] flex flex-col justify-between my-4 w-full px-4 xl:mx-auto ">
    <div class="flex gap-10 flex-col-reverse xl:flex-row">
        <div class="w-[35vw]">
            <form action="" class="flex flex-col  items-center">
                <div class="flex flex-col items-center gap-2">
                    <input name="search" value="<?= $request->getGet('search'); ?>" type="text" id="search" placeholder="Search" class="input input-bordered w-full max-w-xs" />
                    <input type="time" value="<?= $request->getGet('time'); ?>" id="time_input" class="border-gray-400" name="time" required>
                </div>
                <div class="my-4" >
                    <button type="submit" class="btn btn-sm !px-6 group bg-blue-400">
                        <svg class="w-6 h-6 fill-blue-400 group-hover:fill-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path class="stroke-white group-hover:stroke-blue-400" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <div class="flex flex-col my-6 w-full gap-4">
            <?php foreach ($listNewss as $listNews) : ?>
                <a href="/news/<?= encrypt_url($listNews['news_id']); ?>" class="border-2 shadow-lg flex h-full flex-col xl:flex-row  w-full rounded-lg overflow-hidden border-gray-200 gap-4">
                    <div class=" xl:w-[10vw]">
                        <img class=" h-full object-cover" src="<?= base_url("upload/news/$listNews[background_image]"); ?>" alt="">
                    </div>
                    <div class=" pb-4 px-6 xl:w-[60%]">
                        <h1 class="text-2xl font-bold line-clamp-2 "><?= $listNews['title'] ?></h1>
                        <p class="text-sm font-light"><span>Uploaded By </span><?= $listNews['username']; ?></p>
                        <p><?= $listNews['created_at']; ?></p>
                    </div>
                </a>
            <?php endforeach ?>
        </div>
    </div>
    <div class="wrapper_shadow">
        <?= $pager->simpleLinks('default', 'private_full'); ?>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('js/flatpickr.min.js'); ?>"></script>
<script>
    flatpickr("#time_input", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    })
</script>
<?= $this->endSection('content'); ?>