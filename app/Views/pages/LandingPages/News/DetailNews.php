<?= $this->extend('templates/LandingPages') ?>
<?= $this->section('content'); ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">


<div class="w-full ">
    <?= component('LandingPages/TopBar'); ?>
</div>



<div class="xl:w-[60vw] min-h-[60vh] flex flex-col justify-between my-4 w-full px-4 xl:mx-auto ">
    <div><a href="/news" class="btn btn-sm"><i class="fa fa-chevron-left"></i>Back</a></div>
    <div class="flex gap-10 flex-col-reverse xl:flex-row-reverse">
        <div class="w-[20vw]">
            <h1>
                
            </h1>
        </div>
        <div class="flex flex-col my-6 w-full">
            <div class="h-[35vh] xl:h-[60vh] overflow-hidden rounded-lg">
                <img class="h-full object-cover" src="<?= base_url("upload/news/$newsData[background_image]"); ?>" alt="">
            </div>
            <div class="mt-4">
                <h1 class="text-3xl font-bold"><?= $newsData['title']; ?></h1>
                <div class="flex justify-between">
                    <p class="text-green-600 font-semibold">News <span class="text-stone-500"> - Wild Life Park</span></p>
                    <div class="flex gap-2">
                        <p>uploaded By <span><?= $newsData['username']; ?></span></p>
                    </div>
                </div>
            </div>
            <p><?= format_datetime($newsData['created_at']); ?></p>
            <div class=" w-full !border-none my-4" id="editor-container">
            </div>
        </div>
    </div>
    <div>
        <div>
            <div class="flex flex-col gap-4 xl:flex-row my-6 ">
                <?php foreach ($cardNewsDatas as $cardNewsData) : ?>
                    <a href="/news/<?= encrypt_url($cardNewsData['news_id']); ?>" class="border-2 w-[15vw] flex flex-col h-full rounded-lg overflow-hidden border-gray-200 gap-4">
                        <div class="xl:h-[18vh] w-full mx-auto">
                            <img class=" h-full object-cover" src="<?= base_url("upload/news/$cardNewsData[background_image]"); ?>" alt="">
                        </div>
                        <div class="pb-4 px-2">
                            <h1 class="text-xl font-bold line-clamp-2 "><?= $cardNewsData['title'] ?></h1>
                            <p class="text-sm font-light"><span>Uploaded By </span><?= $cardNewsData['username']; ?></p>
                            <p><?= format_datetime( $cardNewsData['created_at']); ?></p>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="<?= base_url('js/purifydom.js'); ?>"></script>

<script>
    var quill = new Quill('#editor-container', {
        modules: {
            // formula: true,
            // syntax: true,

            toolbar: false
        },
        readOnly: true,
        theme: 'snow'
    });

    document.querySelector('.ql-editor').classList.add('!px-0')
    <?php $newsData['content'] ? $quillData = $newsData['content'] : $quillData = ''; ?>

    let quillData = <?= json_encode($newsData['content']) ?>;
    quill.root.innerHTML = DOMPurify.sanitize(quillData);
</script>

<?= $this->endSection('content'); ?>