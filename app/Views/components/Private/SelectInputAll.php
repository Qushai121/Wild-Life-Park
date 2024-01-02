<?php
$errorMsg;
if (isset($id)) {
    $errorMsg = isset(session()->get("errors$id")[$name]) ? session()->get("errors$id")[$name] : null;
} else {
    $errorMsg = isset(session()->get('errors')[$name]) ? session()->get('errors')[$name] : null;
}
?>

<div class="w-full">
    <select value="<?= isset($value) ? $value : null; ?>" name="<?= $name; ?>" id="<?= $name; ?>" class="<?= !empty($errorMsg) ? '!border-red-400 text-red-400 ' : ''; ?>   block px-2.5 pb-2.5 pt-4 text-sm border-stone-500 text-gray-900 rounded-lg border-2  appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer select select-bordered w-full">
        <?php if ($label && !isset($selected)) : ?>
            <option disabled selected><?= isset($label) ? $label : ''; ?></option>
        <?php endif ?>
        <?php foreach ($options as $option) : ?>
            <option <?= isset($selected) ? $selected === $option['value'] ? 'selected' : '' : ''; ?> value="<?= $option['value']; ?>"><?= $option['label']; ?></option>
        <?php endforeach ?>
    </select>

    <?php if (!empty($errorMsg)) : ?>
        <p id="<?= $name; ?>" class="mt-2 text-xs text-red-600 dark:text-red-400"><?= session()->get("errors")[$name]; ?></p>
    <?php endif; ?>
</div>