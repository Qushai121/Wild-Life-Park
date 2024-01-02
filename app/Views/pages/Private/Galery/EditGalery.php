<div class="mt-2">
    <!-- The button to open modal -->
    <label for="edit<?= $listGalery['id']; ?>" class=" btn bg-blue-400 text-white btn-sm">Detail & Edit</label>
    <input type="checkbox" id="edit<?= $listGalery['id']; ?>" class="modal-toggle" />
    <div class="modal <?= session()->get("errors" . $listGalery["id"]) ? 'modal-open' : 'modal-close' ?> " id="edit<?= $listGalery['id']; ?>">
        <div class="modal-box text-black ">
            <h3 class="text-lg font-bold">Apakah Anda Yakin Mengedit ?</h3>
            <p class="py-4"><?= $listGalery['title']; ?></p>
            <?= form_open("private/galery/$listGalery[id]", ['method' => 'POST', "enctype" => "multipart/form-data"]); ?>
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="flex flex-col gap-6">
                <?= component(
                    'Private/TextInput',
                    [
                        'name' => 'title',
                        'label' => 'Title',
                        'value' => $listGalery['title'],
                        'id' => $listGalery['id']
                    ]
                ); ?>
                <?= component(
                    'Private/TextInput',
                    [
                        'name' => 'description',
                        'label' => 'Description',
                        'value' => $listGalery['description'],
                        'id' => $listGalery['id']
                    ]
                ); ?>
                <?= component(
                    'Private/SelectInputAll',
                    [
                        'label' => 'Type',
                        'name' => 'type',
                        'selected' => $listGalery['type'],
                        'id' => $listGalery['id'],
                        'options' => [
                            [
                                'value' => 'human',
                                'label' => 'Human'
                            ],
                            [
                                'value' => 'animal',
                                'label' => 'Animal'
                            ],
                        ],
                    ]
                ); ?>

                <div class="">
                    <input type="hidden" value="<?= $listGalery['images']; ?>" name="imagesOld">
                    <?= component(
                        'Private/ImageInput',
                        [
                            'label' => 'Image',
                            'name' => 'images',
                            'src' => base_url('upload/galerys/' . $listGalery['images']),
                            'id' => $listGalery['id']
                        ]
                    ); ?>
                </div>
            </div>
            <div class="modal-action">
                <button type="submit" class="btn btn-success">Edit</button>
                <div>
                    <label for="edit<?= $listGalery['id']; ?>" class="btn btn-error">X</label>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>