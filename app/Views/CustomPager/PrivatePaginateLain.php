<div class="wrapper_shadow">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php if ($pager->getPreviousPageURI()) : ?>
                <li>
                    <a href="<?= $pager->getPageURI($pager->getFirstPage()) ?>" aria-label="<?= lang('Pager.first') ?>">
                        <span aria-hidden="true"><?= lang('Pager.first') ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= $pager->getPreviousPageURI() ?>" aria-label="<?= lang('Pager.previous') ?>">
                        <span aria-hidden="true"><?= lang('Pager.previous') ?></span>
                    </a>
                </li>
            <?php endif ?>

            <div class="flex">
                <?= $pager->links(); ?>
            </div>

            <?php if ($pager->getNextPageURI()) : ?>
                <li>
                    <a href="<?= $pager->getNextPageURI() ?>" aria-label="<?= lang('Pager.next') ?>">
                        <span aria-hidden="true"><?= lang('Pager.next') ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= $pager->getLastPage($pager->getLastPage()) ?>" aria-label="<?= lang('Pager.last') ?>">
                        <span aria-hidden="true"><?= lang('Pager.last') ?></span>
                    </a>
                </li>
            <?php endif ?>
        </ul>
    </nav>
</div>