<?= $this->extend('templates/LandingPages') ?>
<?= $this->section('content'); ?>

<div class="w-full ">
    <?= component('LandingPages/TopBar'); ?>
</div>


<div>
    <div class="flex flex-col xl:flex-row justify-between py-10 ">
       
        <div class="  xl:w-[30vw] py-4 px-3 flex flex-col justify-evenly gap-5 items-center">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d507612.4104045192!2d106.25886424999999!3d-6.3002189999999905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1d762e95ae1%3A0xb96624945cac9ef2!2sWaduh!5e0!3m2!1sid!2sid!4v1690859775242!5m2!1sid!2sid" width="600" height="450" allowFullScreen="" loading="lazy" referrerPolicy="no-referrer-when-downgrade"></iframe>
            <h1>Our Location</h1>
            <div class="flex gap-1 items-center ">
                <svg fill="#488cb9" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink" width="20px" height="20px" viewBox="0 0 395.71 395.71" xmlSpace="preserve">
                    <g>
                        <path d="M197.849,0C122.131,0,60.531,61.609,60.531,137.329c0,72.887,124.591,243.177,129.896,250.388l4.951,6.738
		c0.579,0.792,1.501,1.255,2.471,1.255c0.985,0,1.901-0.463,2.486-1.255l4.948-6.738c5.308-7.211,129.896-177.501,129.896-250.388
		C335.179,61.609,273.569,0,197.849,0z M197.849,88.138c27.13,0,49.191,22.062,49.191,49.191c0,27.115-22.062,49.191-49.191,49.191
		c-27.114,0-49.191-22.076-49.191-49.191C148.658,110.2,170.734,88.138,197.849,88.138z" />
                    </g>
                </svg>
                <span class=" font-sans font-semibold text-sm">
                    Jl. Sunset Road No. 100, 80361Jakarta,Indonesia
                </span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('content'); ?>