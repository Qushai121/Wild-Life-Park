<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>

<?php $request = \Config\Services::request(); ?>

<!-- Include Quill stylesheet -->
<link href="<?= base_url("node_modules/quill/dist/quill.snow.css"); ?>" rel="stylesheet">


<div  class="wrapper_shadow">
    <div>
        <a class="btn btn-success text-gray-50" href="/private/news">< Back</a>
    </div>
</div>

<div class="wrapper_shadow min-h-[80vh] ">
    <div class="flex xl:flex-row justify-center flex-col gap-8">
        <form action="<?= base_url("private/news/") . encrypt_url($news["id"]) ?>" method="post" class="formAddNews" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <div class='flex flex-col mx-auto gap-4'>
                <div class='xl:w-[25vw] flex flex-col gap-3'>
                    <?= component(
                        'Private/TextInput',
                        [
                            'name' => 'title',
                            'label' => 'Title',
                            'value' => $news['title']
                        ]
                    ); ?>
                    <?= component(
                        'Private/SelectInputAll',
                        [
                            'label' => 'Publish / No',
                            'name' => 'publish',
                            'selected' => $news['publish'],
                            'options' => [
                                [
                                    'value' => 'publish',
                                    'label' => 'Publish'
                                ],
                                [
                                    'value' => 'no',
                                    'label' => 'No'
                                ],
                            ]
                        ]
                    ); ?>
                </div>
                <div>
                    <input type="hidden" name="background_imageOld" value="<?= $news['background_image']; ?>">
                    <?= component(
                        'Private/ImageInput',
                        [
                            'src' => base_url('upload/news/' . $news['background_image']),
                            'name' => 'background_image',
                            'label' => 'Background Image'
                        ]
                    ); ?>
                </div>
                <input type="hidden" name="content" id="">
                <div class='mb-5 mt-4 flex justify-end gap-4'>
                    <div>
                        <button type='submit' class='btn-sm btn-info btn text-gray-50'>Edit News</button>
                    </div>
                </div>
        </form>
    </div>
    <div id="standalone-container">
        <div id="toolbar-container">
            <span class="ql-formats">
                <select class="ql-font"></select>
                <select class="ql-size"></select>
            </span>
            <span class="ql-formats">
                <button class="ql-bold"></button>
                <button class="ql-italic"></button>
                <button class="ql-underline"></button>
                <button class="ql-strike"></button>
            </span>
            <span class="ql-formats">
                <select class="ql-color"></select>
                <select class="ql-background"></select>
            </span>
            <span class="ql-formats">
                <button class="ql-script" value="sub"></button>
                <button class="ql-script" value="super"></button>
            </span>
            <span class="ql-formats">
                <button class="ql-header" value="1"></button>
                <button class="ql-header" value="2"></button>
                <button class="ql-blockquote"></button>
                <button class="ql-code-block"></button>
            </span>
            <span class="ql-formats">
                <button class="ql-list" value="ordered"></button>
                <button class="ql-list" value="bullet"></button>
                <button class="ql-indent" value="-1"></button>
                <button class="ql-indent" value="+1"></button>
            </span>
            <span class="ql-formats">
                <button class="ql-direction" value="rtl"></button>
                <select class="ql-align"></select>
            </span>
            <span class="ql-formats">
                <button class="ql-link"></button>
                <button class="ql-image"></button>
                <button class="ql-video"></button>
                <button class="ql-formula"></button>
            </span>
            <span class="ql-formats">
                <button class="ql-clean"></button>
            </span>
        </div>
        <div class="min-h-[50vh]" id="editor-container"></div>
    </div>
</div>


<!-- Include the Quill library -->
<script src="<?= base_url("node_modules/quill/dist/quill.js"); ?>"></script>
<script src="<?= base_url("node_modules/quill-image-resize/image-resize.min.js"); ?>"></script>
<script src="<?= base_url('js/purifydom.js'); ?>"></script>
<!-- Initialize Quill editor -->
<script>
    var quill = new Quill('#editor-container', {
        modules: {
            // formula: true,
            // syntax: true,
            toolbar: '#toolbar-container',
            imageResize: {
                    displaySize: true
                }
        },
        placeholder: 'Compose an epic...',
        theme: 'snow'
    });

    <?php $news['content'] ? $quillData = $news['content'] : $quillData = ''; ?>

    let quillData = <?= json_encode($news['content']) ?>;

    // Assuming quill is your Quill instance

    quill.root.innerHTML = quillData;
    let content = document.querySelector('[name="content"]')
    content.value = quillData

    quill.on('text-change', function(delta, oldDelta, source) {
        let content = document.querySelector('[name="content"]')
        content.value = quill.root.innerHTML
    })
</script>

<?= $this->endSection('content'); ?>