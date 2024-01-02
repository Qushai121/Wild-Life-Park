<!-- jika ada idnya berarti biasanya di pake untuk edit  -->
<?php



$errorMsg;
if (isset($id)) {
    $errorMsg = isset(session()->get("errors$id")[$name]) ? session()->get("errors$id")[$name] : null;
} else {
    $errorMsg = isset(session()->get('errors')[$name]) ? session()->get('errors')[$name] : null;
}
?>

<div class='inputDataGroup w-full'>
    <div class="relative">
        <input <?= isset($attributes) ? implode(' ', array_values($attributes)) : '' ?> value="<?= isset($value) ? $value : null; ?>" type="<?= isset($type) ? $type : 'text'; ?>" name="<?= $name; ?>" id="<?= $name; ?>" class="<?= !empty($errorMsg) ? '!border-red-400' : ''; ?>  block px-2.5 pb-2.5 pt-4 w-full text-sm border-stone-500 text-gray-900 rounded-lg border-2  appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer placeholder:opacity-0 focus:placeholder:opacity-100 " placeholder="<?= !empty($placeholder) ? $placeholder : null; ?>" />
        <label for="<?= $name; ?>" class="<?= !empty($errorMsg) ? '!text-red-400' : ''; ?> absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1"><?= $label; ?></label>
    </div>
    <?php if (!empty($errorMsg)) : ?>
        <p id="<?= $name; ?>" class="mt-2 text-xs text-red-600 dark:text-red-400"><?= $errorMsg; ?></p>
    <?php endif; ?>
</div>