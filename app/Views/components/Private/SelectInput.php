<div class=" w-full">
    <select  value="<?= isset($value) ? $value : null; ?>" name="<?= $name; ?>" id="<?= $name; ?>" class="<?= isset(session()->get("errors")[$name]) ? '!border-red-400' : ''; ?>   block px-2.5 pb-2.5 pt-4 text-sm border-stone-500 text-gray-900 rounded-lg border-2  appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer select select-bordered w-full">
        <option disabled selected>Role Of The Worker</option>
        <?php $key = -1 ?>
        <?php foreach ($options as $option) : ?>
            <?php $key++; ?>
            <option <?= $selected === $values[$key] ? 'selected' : '' ; ?> value="<?= $values[$key]; ?>"><?= $labels[$key]; ?></option>
            <?php endforeach ?>
    </select>
    
    <?php if (isset(session()->get("errors")[$name])) : ?>
        <p id="<?= $name; ?>" class="mt-2 text-xs text-red-600 dark:text-red-400"><?= session()->get("errors")[$name]; ?></p>
    <?php endif; ?>
</div>