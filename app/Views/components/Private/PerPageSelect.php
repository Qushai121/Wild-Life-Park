<?php
$options = [
    ['value' => 1],
    ['value' => 25],
    ['value' => 50],
    ['value' => 100],
];
?>



<div class=" w-full flex items-center gap-4">
    <p class="font-semibold">Per Page : </p>
    <form action="<?= current_url(); ?>" method="get" id="perPageForm" class="flex items-center gap-4 w-full">
        <select name="perPage" id="perPage" class="block px-2.5 pb-2.5 pt-4 text-sm border-stone-500 text-gray-900 rounded-lg border-2  appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer select select-bordered w-full">
            <?php if (empty($request->getGet('perPage'))) : ?>
                <option disabled selected>Per Page</option>
            <?php endif ?>
            <?php foreach ($options as $option) : ?>
                <option <?= $request->getGet('perPage') == $option['value'] ? 'selected  class="bg-blue-400"' : ''; ?> value="<?= $option['value']; ?>"><?= $option['value']; ?></option>
            <?php endforeach ?>
        </select>
        <button type="submit" class="btn btn-circle group bg-blue-400">
            <svg class="w-6 h-6 fill-blue-400 group-hover:fill-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path class="stroke-white group-hover:stroke-blue-400" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
        </button>
    </form>
</div>