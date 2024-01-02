<?= $this->extend('templates/LandingPages') ?>
<?= $this->section('content'); ?>
<?php $request = \Config\Services::request(); ?>
<link rel="stylesheet" href="<?= base_url('css/flatpickr.min.css'); ?>">
<div class="w-full ">
    <?= component('LandingPages/TopBar'); ?>
</div>

<div class="xl:w-[65vw]  min-h-[60vh] ">
    <div class="flex flex-wrap my-6 text-center gap-4 mx-auto justify-between">
        <?php foreach ($listGalerys as $listHuman) : ?>
            <div class="border-2 group flex flex-col h-full w-[20vw] rounded-xl overflow-hidden border-gray-200 gap-4">
                <div class="xl:h-[30vh] duration-500 group-hover:scale-110 ease-out relative w-full overflow-hidden bg-center bg-contain" style="background-image: url(<?= base_url("upload/galerys/$listHuman[images]"); ?>);">
                    <div class="absolute bottom-0 py-2 duration-500 group-hover:-bottom-24 ease-out bg-opacity-50 backdrop-blur-sm px-4 w-[70%] overflow-x-auto rounded-t-lg bg-white">
                        <h1 class="text-2xl font-bold"><?= $listHuman['title'] ?></h1>
                        <p class="text-sm font-light"><?= $listHuman['description']; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>



<?= $this->endSection('content'); ?>