<?= $this->extend('templates/AuthPages') ?>
<?= $this->section('content'); ?>

<div class="h-[100vh]  z-20 flex justify-center  items-center">
    <div class="bg-stone-100 z-20 rounded-md shadow-md p-10">
        <div class="">
            <h5 class="text-2xl font-bold"><?= lang('Auth.login') ?></h5>




            <form action="<?= url_to('login') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="my-2 gap-1 flex flex-col">
                    <input type="email" class="input input-group" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" />
                    <label for="floatingEmailInput" class="label label-text"><?= lang('Auth.email') ?></label>
                </div>

                <!-- Password -->
                <div class="mb-2 gap-1 flex flex-col">
                    <input type="password" class="input input-group" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" />
                    <label for="floatingPasswordInput" class="label label-text"><?= lang('Auth.password') ?></label>
                </div>

                <!-- Remember me -->
                <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>
                    <div class="form-control w-[50%]">
                        <label class="label cursor-pointer">
                            <input type="checkbox" name="remember" class="checkbox " <?php if (old('remember')) : ?> checked<?php endif ?>>
                            <span class="label-text"><?= lang('Auth.rememberMe') ?></span>
                        </label>
                    </div>
                <?php endif; ?>

                <div class="d-grid col-12 col-md-8 mx-auto m-3">
                    <button type="submit" class="btn btn-success w-full"><?= lang('Auth.login') ?></button>
                </div>

                <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
                    <p class="text-center "><?= lang('Auth.forgotPassword') ?> <a class="link link-info" href="<?= url_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a></p>
                <?php endif ?>

                <?php if (setting('Auth.allowRegistration')) : ?>
                    <p class="text-center "><?= lang('Auth.needAccount') ?> <a class="link link-info" href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a></p>
                <?php endif ?>

            </form>
        </div>
    </div>
</div>

<script>
    
    toastr.options.positionClass = 'toast-top-left';
    <?php if (session('success') !== null) : ?>
        toastr.success(`<div class=""><?= session('success') ?></div>`)
    <?php endif ?>

    <?php if (session('error') !== null) : ?>
        toastr.error(`<div class=" my-2 text-white"><?= session('error') ?></div>`)
    <?php elseif (session('errors') !== null) : ?>
        toastr.error(`<div class=" my-2 text-white">
                    <?php if (is_array(session('errors'))) : ?>
                        <?php foreach (session('errors') as $error) : ?>
                            <?= $error ?>
                            <br>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?= session('errors') ?>
                    <?php endif ?>
                </div>`)
    <?php endif ?>
</script>
<?= $this->endSection(); ?>