<?php
$errorMsg;
if (isset($id)) {
    $errorMsg = isset(session()->get("errors$id")[$name]) ? session()->get("errors$id")[$name] : null;
} else {
    $errorMsg = isset(session()->get('errors')[$name]) ? session()->get('errors')[$name] : null;
}

?>
<div class='xl:w-[25vw] flex flex-col gap-3 wrapperImagePreview '>
    <?php if (!empty($label)) : ?>
        <p class="<?= $errorMsg ? "text-red-400" : ''; ?> label label-text " ><?= $label; ?></p>
    <?php endif ?>
    <div class="flex items-center justify-center w-full">
        <label class=" <?= $errorMsg ? '!border-red-400' : '' ?> relative flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
            <?php if (!empty($src)) : ?>
                <img src="<?= $src; ?>" alt="" class="removeable h-full w-full object-cover overflow-hidden">
                <div class="absolute bottom-2 right-2">
                    <div class="w-20 rounded-full bg-opacity-50 h-20 bg-blue-400">
                        <div class="w-full h-full flex items-center justify-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-[60%] opacity-75 fill-gray-50" viewBox="0 0 512 512">
                                <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                            </svg>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <img src="" alt="" class="imagePreview h-full w-full object-cover overflow-hidden">
            <div class="<?= isset($src) ? 'hidden' : ''; ?>  removeable flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF </p>
            </div>
            <input type="file" class="fileInput hidden" name="<?= $name; ?>" />
        </label>
    </div>
    <?php if (!empty($errorMsg)) : ?>
        <p id="<?= $name; ?>" class="text-xs text-red-600 dark:text-red-400"><?= $errorMsg; ?></p>
    <?php endif; ?>
</div>