<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('css/flatpickr.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('DataTables/css/datatables.min.css'); ?>">
    <style>
        .btn {
            --tw-text-opacity: 1;
            color: rgb(249 250 251 / var(--tw-text-opacity));
        }
    </style>
</head>

<body class="bg-gray-100 w-full dark:bg-stone-900 dark:text-stone-100">
    <div>
        <div class="min-h-screen ">
            <div className='max-w-[97vw] flex flex-1 flex-col justify-between '>
                <main className="openSideBar w-[79vw] duration-300 pb-4 min-h-screen">
                    <div class='flex gap-4 py-4 '>
                        <?= $this->include('components/Private/Sidebar'); ?>
                        <div class="flex flex-col w-full mr-4">
                            <div class="notification !h-0">
                                <div class="wrapper_shadow  duration-300">
                                </div>
                            </div>
                            <?= $this->include('components/Private/Topbar');  ?>
                            <?= $this->renderSection('content'); ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>

<?= $this->include('components/Private/js'); ?>


<script type="text/javascript" src="<?= base_url('js/flatpickr.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('js/fullcalender.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('Jquery/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('DataTables/js/datatables.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('js/Global.js'); ?>"></script>
<script>
    
    flatpickr("#time_input", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    })

    <?php if (session()->get('success')) : ?>
        notification('<?= session()->get('success') ?>', 'text-green-400')
    <?php endif ?>

    function notification(message, styleColor) {
        const notifications = document.querySelector('.notification')
        notifications.classList.remove('!h-0')
        var messageBody = document.createElement('div');
        messageBody.textContent = message;
        notifications.querySelector('div').appendChild(messageBody).classList.add(styleColor);
        setTimeout(() => {
            notifications.querySelector('div').classList.add('!h-0', '!p-0', '!mt-0')
        }, 3000);
    }

    // function editModal(id) {
    //     fetch(`http://localhost:8080/private/galery/1/edit`)
    //         .then(response => response.json())
    //         .then(data => {
    //             console.log(data);
    //             const newDiv = document.createElement('div');
    //             newDiv.innerHTML = data.html;

    //             document.querySelector('div').appendChild(newDiv);
    //         })
    //         .catch(error => {
    //             console.log('Error:', error);
    //         });
    // }



    $(document).ready(function() {
        console.log('halo');
        $('#table').DataTable({
            // Menghilangkan fitur Search
            "searching": false,
            "dom": 'Bfrtip', // Add B to the dom option for buttons
            "buttons": [
                'colvis' // Add column visibility button
            ]
        });
    });
</script>

</html>