<!-- jika ada idnya berarti biasanya di pake untuk edit  -->
<?php



$errorMsg;
if (isset($id)) {
    $errorMsg = isset(session()->get("errors$id")[$name]) ? session()->get("errors$id")[$name] : null;
} else {
    $errorMsg = isset(session()->get('errors')[$name]) ? session()->get('errors')[$name] : null;
}
?>


<input  value="<?= isset($value) ? $value : null; ?>" type="time" name="<?= $name; ?>" id="time_input" class="<?= !empty($errorMsg) ? '!border-red-400' : 'border-gray-400'; ?>" />
<?php if (!empty($errorMsg)) : ?>
    <p id="<?= $name; ?>" class="mt-2 text-xs text-red-600 dark:text-red-400"><?= $errorMsg; ?></p>
<?php endif; ?>