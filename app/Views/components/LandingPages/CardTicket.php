<div class="item flex xl:flex-row flex-col border-2 xl:h-[31.4vh] ">
  <div class="item-right relative ">
    <div class="w-[100vw] h-full xl:w-[140%] absolute top-0 -left-10 ">
      <img class="h-full w-[100vw] object-cover" src="<?= base_url('upload/tickets/') . $image ?>" alt="">
    </div>
    <span class="up-border  z-[777]"></span>
    <span class="down-border z-[777]"></span>
  </div> <!-- end item-right -->

  <div class="item-left overflow-y-scroll scrollbar-none z-50 ">
    <p class="event"><?= $name; ?></p>
    <h2 class="title  scrollbar-hide "><?= $description; ?></h2>

    <div class="sce ">
      <div class="icon">
        <i class="fa fa-tag"></i>
      </div>
      <div class="flex gap-2 ">
        <div class="relative">
          <p class="<?= $discount > 0 ? 'line-through' : ''; ?> "><?= toRupiah($price); ?></p>
          <?php if ($discount > 0) : ?>
            <p class="absolute right-2 -bottom-4 "><?= $discount; ?>% OFF</p>
          <?php endif ?>
        </div>
        <?php if ($discount > 0) : ?>
          <div>
            <?= toRupiah(discountPrice($price, $discount)); ?>
          </div>
        <?php endif ?>
      </div>
    </div>
    <div class="fix"></div>
    <div class="loc">
      <div class="icon">
        <i class="fa fa-plus"></i>
      </div>
      <p><?= $access; ?></p>
    </div>
    <div class="fix"></div>
    <?= form_open('checkout/create'); ?>
    <div className='w-[50%] flex border-2 border-green-500 rounded-xl justify-center '>
    </div>
    <input type="number" class="input" name="quantity" id="quantity" min="1" max="10" value="1">
    <input type="hidden" name="product_id" id="" value="<?= $id; ?>">
    <button type="submit" class="tickets">Check Out</button>
    <?= form_close() ?>
  </div>
</div>