<div class=" w-full py-10 bg-cover bg-center h-52 bg-stone-700 bg-blend-normal text-white" style="background-image: url('<?= base_url('assets/images/bg-fixed.png'); ?>');">
    <div class="flex flex-col gap-4 xl:mx-20 mx-10 h-full justify-between xl:flex-row bg-stone-700 bg-opacity-60 xl:px-6 px-3 rounded-xl  ">
        <div class="flex flex-col justify-center">
            <h1 class="text-2xl font-semibold ">
                <?= $topbar['title']; ?>
            </h1>
            
            <p class="font-light"><?= $topbar['description']; ?></p>
            <Divider width="w-[15%]" color="bg-blueSecondary" class="h-2 -mt-[0.1px]" />
        </div>
        <div class="flex gap-1  justify-end xl:justify-start text-lg items-center">
            <a href="/home">home</a>
            <span> / </span>
            <a href='<?= current_url(); ?>' class="whitespace-nowrap"><?= $topbar['title']; ?></a>
        </div>
    </div>
</div>