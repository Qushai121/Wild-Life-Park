<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script type="text/javascript" src="<?= base_url('Jquery/jquery.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body>
    <div class="flex relative w-full bg-no-repeat bg-cover " style="background-image: url(<?= base_url('/assets/images/authbg.svg') ?>);">
        <div class="h-[100vh] flex justify-center items-center w-[40%]">
            <div class="flex flex-col justify-center items-center gap-1 text-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" id="SvgjsSvg1405" x="0" y="0" version="1.1" viewBox="0 0 512 512" width="200" height="200" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev/svgjs">
                        <path d="M0 .001h235.016v50.361H0zm0 92.327h235.016v50.36H0zm0 92.328v50.36h235.016v-50.36zM461.638.001h50.361v235.016h-50.361zm-92.328 0h50.36v235.016h-50.36zm-92.327 0v235.015h50.36V.001zm0 461.638h235.016V512H276.983zm0-92.328h235.016v50.36H276.983zm163.673-92.327H276.983v50.36H512v-50.36zM0 276.984h50.361V512H0zm92.328 0h50.36V512h-50.36zm92.327 0v235.015h50.361V276.984z" fill="url(&quot;#SvgjsLinearGradient1406&quot;)"></path>
                        <defs>
                            <linearGradient gradientTransform="rotate(0 0.5 0.5)" id="SvgjsLinearGradient1406">
                                <stop stop-opacity=" 1" stop-color="rgba(105, 234, 203)" offset="0"></stop>
                                <stop stop-opacity=" 1" stop-color="rgba(234, 204, 248)" offset="0.48"></stop>
                                <stop stop-opacity=" 1" stop-color="rgba(84, 241, 182)" offset="1"></stop>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <p class="text-4xl my-1 font-bold">Wild Life Park</p>
                <p>A place to see exotic animals</p>
            </div>
        </div>

        <div class=" w-[60%]">
            <?= $this->renderSection('content'); ?>
        </div>
        <div class="z-50 w-full bottom-0 absolute bg-stone-400 bg-opacity-50 backdrop-blur-md text-center">
            <div class="flex gap-1 items-center w-full justify-center font-bold">
                <?php
                $nowTime = new DateTime()
                ?>
                <p>copyright </p>
                <i class="fa-regular fa-copyright"></i>
                <p>2023 - <?= $nowTime->format('Y'); ?> Uhuy.ltd</p>
            </div>
        </div>
    </div>

</body>

</html>