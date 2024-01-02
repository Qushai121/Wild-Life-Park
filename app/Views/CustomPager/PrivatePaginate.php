<div>
    <?php $pager->setSurroundCount(4); ?>
    <ul class="flex">
        <?php if ($pager->getPreviousPage()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-x-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <div class="flex ">
                        <img src=<?= base_url('/assets/icons/chevron_down.svg'); ?> alt="" class="-rotate-90 ease-in duration-300" />
                        <img src=<?= base_url('/assets/icons/chevron_down.svg'); ?> alt="" class="-rotate-90 ease-in duration-300" />
                    </div>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPreviousPage() ?>" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-x-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
            </li>
        <?php endif; ?>
        <?php
        $request = \Config\Services::request();
        $page = $request->getGet('page') ?: null;
        $perPage = $request->getGet('perPage') ?: null;
        $search = $request->getGet('search') ?: null;
        $time = $request->getGet('time') ?: null;
        ?>
        <?php foreach ($pager->links(['query' => ['search' => $search, 'perPage' => $perPage, 'time' => $time, 'page' => $page, 'time' => $time]]) as $link) : ?>
            <li>
                <a href="<?= $link['uri'] ?>" class="<?= $link['active'] ? 'bg-gray-200 text-black' : '' ?> flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"><?= $link['title'] ?></a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->getNextPage()) : ?>
            <li>
                <a href="<?= $pager->getNextPage() ?>" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-x-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-x-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <div class="flex">
                        <img src=<?= base_url('/assets/icons/chevron_down.svg'); ?> alt="" class="rotate-90 ease-in duration-300" />
                        <img src=<?= base_url('/assets/icons/chevron_down.svg'); ?> alt="" class="rotate-90 ease-in duration-300" />
                    </div>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>