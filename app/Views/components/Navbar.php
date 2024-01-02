<?php $request = \Config\Services::request(); ?>

<nav id="navba" class="text-white overflow-visible fixed w-full z-[999]">
    <div class="bg-white px-6 text-black border-b-2 border-green-950 overflow-visible">
        <div class="flex gap-2">
            <img src=<?= base_url('assets/icons/phone.svg'); ?> alt="">
            <p>+6272672672272</p>
        </div>
    </div>
    <div class="relative">
        <div class="flex bg-stone-800 justify-between px-6 items-center h-20 overflow-hidden">
            <h1 class="text-xl font-bold py-5">
                WILD LIFE PARK
            </h1>
            <div class="xl:hidden" onclick="setHambergerMenu()">
                <div id="nav-icon4">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="duration-300 delay-100 xl:!overflow-visible mx-10 xl:bg-transparent xl:!h-20 bg-white rounded-b-sm xl:absolute xl:top-0 xl:left-64 " id="hamburgerMenus">
            <ul class="text-center mx-10 overflow-visible flex flex-col xl:flex-row xl:items-center xl:justify-evenly xl:h-20 xl:w-[70vw] [&>*]:py-[10px] [&>*]:text-lg [&>*]:font-semibold text-green-400 ">
                <li>
                    <a href="/home">Home</a>
                </li>
                <li>
                    <a href="/news">News & Event</a>
                </li>
                <li>
                    <a href="/park/information">Park Information</a>
                </li>
                <li>
                    <div class="dropdown dropdown-hover">
                        <div tabindex="0" role="button" class="">Galery</div>
                        <ul tabindex="0" class="dropdown-content z-[1] menu pt-8  w-52">
                            <div class="shadow bg-base-100  rounded-box p-2">
                                <li><a href="/galery/guest">Our Guest Gallery</a></li>
                                <li><a href="/galery/animal">Animal Colections</a></li>
                            </div>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="/ticket"  class="btn btn-sm border animate-pulse text-white rounded-full bg-green-400">
                        <p class="flex items-center h-full ">Ticket</p>
                    </a>
                </li>
                <li>
                    <div class="flex gap-4 items-center xl:justify-center justify-between px-6 bg-green-400 p-2 rounded-full">
                        <div class="indicator mt-1">
                            <span class="indicator-item badge badge-secondary"><?= count(json_decode($request->getCookie('products'), true) ?? []); ?></span>
                            <a href="/checkout" class="">
                                <i class="fa fa-cart-plus text-white"></i>
                            </a>
                        </div>
                        <div class="dropdown dropdown-hover">
                            <div tabindex="0" role="button" class="btn border text-black rounded-full bg-white">
                                <?= auth()->user() ? auth()->user()->username : 'Login' ?>
                            </div>
                            <ul tabindex="0" class="dropdown-content z-[1] menu pt-8  w-52">
                                <div class="shadow bg-base-100  rounded-box p-2">
                                    <?php if (auth()->user()) : ?>
                                        <li><a href="/private/profile">Profile</a></li>
                                        
                                        <li><a href="/logout">Log out</a></li>
                                    <?php else : ?>
                                        <li><a href="/login">Login</a></li>
                                        <li><a href="/register">Register</a></li>
                                    <?php endif ?>
                                </div>
                            </ul>
                        </div>
                    </div>

                </li>

            </ul>
        </div>
    </div>
</nav>