<div class="mt-2">
    <!-- The button to open modal -->
    <label for="delete<?= $key; ?>" class=" btn bg-red-400 btn-sm">Delete</label>
    <input type="checkbox" id="delete<?= $key; ?>" class="modal-toggle" />
    <div class="modal" id="delete<?= $key; ?>">
        <div class="modal-box">
            <h3 class="text-lg text-black font-bold">Are You Sure Delete ?</h3>
            <p class="py-4 text-blue-500"><?= $listNews['title']; ?></p>
            <form action="<?= base_url("private/news/{$listNews['news_id']}"); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="DELETE">
                <div class="modal-action">
                    <button type="submit" class="btn btn-error ">Delete</button>
                    <label for="delete<?= $key; ?>" class="btn btn-info">X</label>
                </div>
            </form>
        </div>
    </div>
</div>