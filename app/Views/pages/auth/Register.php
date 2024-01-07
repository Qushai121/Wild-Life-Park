<?= $this->extend('templates/AuthPages') ?>
<?= $this->section('content'); ?>


<div class="h-[100vh] z-20 flex justify-center items-center">
    <div class="bg-stone-100 z-20 w-[40%] rounded-md shadow-md p-10">
        <div class="">
            <h5 class="text-2xl font-bold"><?= lang('Auth.register') ?></h5>


            <form action="<?= url_to('register') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="my-2 gap-1 flex flex-col">
                    <input type="email" class="input input-group" id="floatingEmailInput" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>"  />
                    <label for="floatingEmailInput" class="label label-text"><?= lang('Auth.email') ?></label>
                </div>

                <!-- Username -->
                <div class="my-2 gap-1 flex flex-col">
                    <input type="text" class="input input-group" id="floatingUsernameInput" name="username" inputmode="text" autocomplete="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>"  />
                    <label for="floatingUsernameInput" class="label label-text"><?= lang('Auth.username') ?></label>
                </div>

                <!-- Password -->
                <div class="my-2 gap-1 flex flex-col">
                    <input type="password" class="input input-group" id="floatingPasswordInput" name="password" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>"  />
                    <label for="floatingPasswordInput" class="label label-text"><?= lang('Auth.password') ?></label>
                </div>

                <!-- Password (Again) -->
                <div class="my-2 gap-1 flex flex-col">
                    <input type="password" class="input input-group" id="floatingPasswordConfirmInput" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>"  />
                    <label for="floatingPasswordConfirmInput" class="label label-text"><?= lang('Auth.passwordConfirm') ?></label>
                </div>

                <div class="d-grid col-12 col-md-8 mx-auto m-3">
                    <button type="submit" class="btn btn-success w-full"><?= lang('Auth.register') ?></button>
                </div>

                <p class="text-center"><?= lang('Auth.haveAccount') ?> <a class="link link-info" href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a></p>

            </form>
        </div>
    </div>
</div>

<script>
     toastr.options.positionClass = 'toast-top-left';
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