<?php

$datas = [
    [
        'route' => "private/profile",
        'icon' => 'assets/icons/profile.svg',
        'name' => 'Profile',
        'access' => 'superadmin,user,dataentry,worker,ticketguard',
    ],
    [
        'route' => 'private/dashboard',
        'icon' => 'assets/icons/dashboard.svg',
        'name' => 'Dashboard',
        'access' => 'superadmin',
    ],
    [
        'route' => "private/galery",
        'icon' => 'assets/icons/galerys.svg',
        'name' => 'Galery',
        'access' => 'superadmin,dataentry',
        'submenu' => [
            [
                'access' => 'superadmin,dataentry',
                'route' => 'private/galery',
                'name' => 'List Galery',
            ],
            [
                'access' => 'superadmin,dataentry',
                'route' => 'private/galery/new',
                'name' => 'Add Galery',
            ],
        ],
    ],
    [
        'route' => "private/worker",
        'icon' => 'assets/icons/worker.svg',
        'name' => 'Worker Management',
        'access' => 'superadmin,dataentry',
        'submenu' => [
            [
                'access' => 'superadmin',
                'route' => 'private/worker',
                'name' => 'List Worker',
            ],
            [
                'access' => 'superadmin,dataentry',
                'route' => 'private/worker/new',
                'name' => 'Add Worker',
            ],

        ],
    ],
    [
        'route' => "private/ticket",
        'icon' => 'assets/icons/ticket.svg',
        'name' => 'Ticket Management',
        'access' => 'superadmin,dataentry,ticketguard',
        'submenu' => [
            [
                'access' => 'superadmin,dataentry',
                'route' => 'private/ticket/management',
                'name' => 'Ticket Management',
            ],
            [
                'access' => 'superadmin,dataentry',
                'route' => 'private/ticket',
                'name' => 'List ticket',
            ],
            [
                'access' => 'superadmin,dataentry',
                'route' => 'private/ticket/new',
                'name' => 'Add ticket',
            ],
            
            [
                'access' => 'superadmin,dataentry,ticketguard',
                'route' => 'private/ticket/indexscan',
                'name' => 'Scan Costumer E-Ticket',
            ],

        ],
    ],
    // [
    //     'route' => "private/ticket",
    //     'icon' => '/icons/store.svg',
    //     'name' => 'Ticket Transaction',
    //     'access' => 'superadmin',
    //     'submenu' => [
    //         [
    //             'route' => 'private/ticket',
    //             'name' => 'List Transaction',
    //         ],

    //     ],
    // ],
    [
        'route' => "private/absent",
        'icon' => 'assets/icons/absents.svg',
        'name' => 'Absents For Worker',
        'access' => 'superadmin,dataentry',
        'submenu' => [
            [
                'access' => 'superadmin,dataentry',
                'route' => 'private/absent',
                'name' => 'List absent',
            ],
            [
                'access' => 'superadmin,dataentry',
                'route' => 'private/absent/indexScan',
                'name' => 'Scan For QRCode Absent',
            ],
        ],
    ],
    [
        'route' => 'product.index',
        'icon' => 'assets/icons/news.svg',
        'name' => 'News',
        'access' => 'superadmin,dataentry',
        'submenu' => [
            [
                'access' => 'superadmin,dataentry',
                'route' => 'private/news',
                'name' => 'List News',
            ],
            [
                'access' => 'superadmin,dataentry',
                'route' => 'private/news/new',
                'name' => 'Add News',
            ],
        ],
    ],
];

$data;

foreach ($datas as $key => $d) {
    if (auth()->user()->inGroup(...explode(',',$d['access']))) {
        $data[$key] = $d;
        $data[$key]['submenu'] = null;

        if (!empty($d['submenu'])) {
            foreach ($d['submenu'] as $ss => $submenu) {
                if (auth()->user()->inGroup(...explode(',',$submenu['access']))) {
                    $data[$key]['submenu'][] = $submenu;
                }
            }
        }
    }
}


if (empty($data)) {
    return redirect('login');
}

?>


<div class="flex">
    <div id="sidebarAdmin" class="w-[19rem] duration-300 ease-in relative flex flex-col gap-6 px-2">
        <div class='sticky top-10'>
            <div class="flex opacity-100 dark:bg-stone-600 shadow-lg ease-in overflow-auto flex-col rounded-xl h-[70vh] duration-300 ">
                <div class='flex flex-col gap-3 relative'>
                    <div class='mt-1'>
                        <h1 class='text-2xl font-bold text-center my-2 font-serif'>WILD LIFE PARK</h1>
                    </div>
                </div>
                <div class='flex h-full  '>
                    <div class='flex flex-1 flex-col  items-start my-2 gap-2 mx-4'>
                        <?php foreach ($data as $d) : ?>
                            <div class=" w-full flex flex-col duration-300 relative`">
                                <?php if (!isset($d['submenu'])) : ?>
                                    <a class="sidebarMenu" href=<?= base_url($d['route']); ?>>
                                        <div class="bg-stone-50 duration-300 rounded-xl w-full h-12 flex justify-start items-center">
                                            <div class='h-8 rounded-lg w-8 shadow-base_secondary shadow-md m-2 object-cover'>
                                                <img src=<?= base_url($d['icon']); ?> alt="" class='h-full p-2' />
                                            </div>
                                            <p class='text-sm font-light w-[40%] whitespace-nowrap flex flex-wrap'><?= $d['name']; ?></p>
                                        </div>
                                    </a>
                                <?php else : ?>
                                    <div href=<?= base_url($d['route']); ?> class='wrapperDropwDown w-full '>
                                        <div class="handleOpenDropDown bg-stone-50 duration-300 rounded-xl w-full h-12 flex items-center`}">
                                            <div class='w-full flex items-center'>
                                                <div class='h-8 rounded-lg w-8 shadow-base_secondary shadow-md m-2 object-cover'>
                                                    <img src=<?= base_url($d['icon']); ?> alt="" class='h-full p-2 ' />
                                                </div>
                                                <p class='text-sm font-light whitespace-nowrap flex flex-wrap'><?= $d['name']; ?></p>
                                            </div>
                                            <div class='h-8 rounded-lg w-8 bg-stone-50 shadow-base_secondary shadow-md m-2 object-cover'>
                                                <img src=<?= base_url('/assets/icons/chevron_down.svg'); ?> alt="" class="rotate-0 chevron h-full p-2 ease-in duration-300" />
                                            </div>
                                        </div>

                                        <div href=<?= base_url($d['route']); ?> class="dropdownMenu h-0 mt-2 flex w-full duration-300 ">
                                            <div class='w-full flex flex-col '>
                                                <div class='w-full flex flex-col gap-2 overflow-hidden border-l-4 '>
                                                    <?php foreach ($d['submenu'] as $submenu) : ?>
                                                        <div class='flex items-center duration-300'>
                                                            <p class='border-2 w-2'></p>
                                                            <div class='w-full'>
                                                                <a href=<?= base_url($submenu['route']); ?> class='subMenuDropdown w-full rounded-lg'>
                                                                    <div class="bg-stone-50 duration-300 rounded-xl w-full h-12 flex justify-start items-center">
                                                                        <p class='text-sm font-light mx-2'><?= $submenu['name']; ?></p>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
                    </div>

                </div>
            </div>
            <div class="translate-x-0 duration-300 shadow-rounded-2 py-4 h-[25%] rounded-xl overflow-hidden">
                <div>
                    <div class='flex gap-3'>
                        <div class='flex items-center'>
                            <div class="avatar">
                                <div class="w-20 rounded-xl">
                                    <img src="<?= base_url('upload/avatars/') . '' . auth()->user()->avatar; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class='max-w-full overflow-hidden'>
                            <h1><?= auth()->user()->username; ?></h1>
                            <h1>Authority :
                                <?php foreach (auth()->user()->getGroups()  as $grup) : ?>
                                    <span><?= $grup; ?></span>
                                <?php endforeach ?>
                            </h1>
                        </div>
                    </div>
                    <div class="my-4">
                        <a class="btn btn-sm btn-info " href="<?= base_url('logout'); ?>" as="button">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div className="min-h-screen max-h-full flex relative">
        <button onclick="handleSidebar()" class="bg-stone-300 w-6 h-[90%] top-0 sticky hover:bg-stone-400 duration-300 ease-in transition-all rounded-full flex items-center justify-center">
            <p>
                < </p>
        </button>
    </div>
</div>