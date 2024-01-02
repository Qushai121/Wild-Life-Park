<div class="mt-2">
    <!-- The button to open modal -->
    <label for="delete<?= $key; ?>" class=" btn bg-red-400 btn-sm">Hapus</label>
    <input type="checkbox" id="delete<?= $key; ?>" class="modal-toggle" />
    <div class="modal" id="delete<?= $key; ?>">
        <div class="modal-box">
            <h3 class="text-lg text-black font-bold">Apakah Anda Yakin Menghapus ?</h3>
            <p class="py-4 text-blue-500"><?= $listTicket['name']; ?></p>
            <form action="<?= base_url("private/ticket/{$listTicket['id']}"); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="DELETE">
                <div class="modal-action">
                    <button type="submit" class="btn btn-error  ">Hapus</button>
                    <label for="delete<?= $key; ?>" class="btn btn-info">X</label>
                </div>
            </form>
        </div>
    </div>
</div>