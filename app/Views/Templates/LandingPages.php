<!DOCTYPE html>
<html lang="en" data-theme="light" class="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="<?= csrf_hash() ?>">
    <title>Document</title>
    <link rel="shortcut icon" href=<?= base_url('/assets/images/komodo.jpg'); ?> type="image/x-icon">
    <?= $this->include('components/LandingPages/css'); ?>
    <script type="text/javascript" src="<?= base_url('Jquery/jquery.min.js'); ?>"></script>
</head>

<body class="flex flex-col justify-between text-black">
    <!-- ini untuk amanin class tailwind biar g ilang pas minify -->
    <!-- karena kalo pake add class js atau coditional class php bagal ilang -->
    <div class="!bg-stone-400 z-[1000] bg-opacity-0 backdrop-blur-sm absolute bg-transparent hidden border-2 !border-red-400 rotate-180 rotate-0 h-full text-red-400 text-green-400 fill-yellow-300 !border-red-400 !text-red-400 !h-0 !mt-0"></div>
    <!-- ini untuk amanin class tailwind biar g ilang pas minify -->
    <!-- ?= $this->include('Templates/ModalAuth'); ?> -->
    <?= $this->include('components/Navbar'); ?>
    <div class="pt-[6.4rem] flex flex-col items-center ">
        <?= $this->renderSection('content'); ?>
    </div>
    <!-- <footer class="bg-stone-200 py-4 mt-20 absolute bottom-0 w-full">
        <p class="text-center font-light">&copy; 2023 Uhuy Ltd. All rights reserved.</p>
    </footer> -->
</body>
<?= $this->include('components/LandingPages/js'); ?>

<script>
    function showModalMustLogin() {
        fetch("<?= base_url("modalauth") ?>")
            .then(response => response.json())
            .then(data => {
                document.body.innerHTML += data.html;
                document.querySelector(".authMessage").classList.remove("hidden")
            })
            .catch(error => {
                console.log('Error:', error);
            });
    }

    <?php if (session()->getFlashdata("authMessage")) : ?>
        showModalMustLogin()
    <?php endif ?>

    function hiddenModalMustLogin() {
        document.querySelector(".authMessage").classList.add("hidden")
    }

    document.addEventListener("DOMContentLoaded", function() {
        var navbar = document.getElementById('navba');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('h-0');
            }
        });
    });
</script>


</html>