<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>


<!-- jumlah pekerja -->
<!-- jumlah duit transaksi status settlement perbulan/pertahun-->
<!--  -->

<div class="wrapper_shadow min-h-[85vh]">
    <div>
        <div class="bg-info w-fit py-4 px-8 text-2xl text-stone-100 font-bold rounded-lg text-center">
            <p>Total Transaction </p>
            <?php if ($total_amount['total_amount']) : ?>
                <h1><?= toRupiah($total_amount['total_amount']); ?></h1>
            <?php else : ?>
                <h1><?= toRupiah(0); ?></h1>
            <?php endif ?>
            <?php
            $request = \Config\Services::request();
            $nowTime = new DateTime('now');
            $currentMonth = $nowTime->format('m');
            $currentYear = $nowTime->format('Y');

            $byMonth = $request->getGet('byMonth');
            $byYear = $request->getGet('byYear');

            if ($byMonth != 0 && empty($byMonth)) {
                $byMonth = $currentMonth;
            };

            if ($byYear != 0 && empty($byYear)) {
                $byYear = $currentYear;
            };
            ?>

            <form action="<?= current_url(); ?>" method="get">
                <div class="flex gap-4 my-4 px-3 text-black">
                    <div class="flex flex-col gap-2 items-center">
                        <label class="text-white" for="">By Year</label>
                        <input class="input w-28" value="<?= $byYear; ?>" type="number" name="byYear">
                    </div>
                    <div class="flex flex-col gap-2 items-center ">
                        <label class="text-white" for="">By Month</label>
                        <input class="input w-20" value="<?= $byMonth; ?>" type="number" name="byMonth">
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-full">Sort</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>