<?= $this->extend('templates/PrivatePages') ?>
<?= $this->section('content'); ?>

<div class="wrapper_shadow">
    <div class="flex flex-col xl:flex-row gap-10">
        <div class="h-[70vh] xl:h-[50vh] xl:w-[40vw] rounded-xl border-2 border-gray-200 shadow-sm relative">
            <div class="flex h-full justify-center items-center">
                <p>Click Open Camera For Scanning Worker QR CODE</p>
            </div>
            <video id="preview" class="absolute inset-0 w-full h-full object-cover"></video>
        </div>
        <div class="flex flex-col gap-4 mt-4 items-center">
            <div class="flex gap-4">
                <div>
                    <button class="btn btn-sm btn-info" onclick="openCamera()">Open Camera</button>
                </div>
                <div>
                    <button class="btn btn-sm btn-error" onclick="closeCamera()">Close Camera</button>
                </div>
            </div>
            <div class="flex flex-col items-center">
                <h1>Status Absensts</h1>
                <div class="content-message  ">
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<script type="text/javascript" src="<?= base_url('js/instascan.min.js'); ?>"></script>

<script type="text/javascript">
    let scanner;

    function openCamera() {
        document.getElementById('preview').classList.remove('hidden')
        // Initialize the scanner inside the openCamera function to ensure it's only initialized when needed
        scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });

        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
        });

        scanner.addListener('scan', function(content) {
            const data = JSON.parse(content)
            console.log(data);
            $.ajax({
                url: "<?= base_url('private/absent/checkWorkerDataScan') ?>",
                type: 'POST', // You can use 'GET' or 'POST' depending on your API requirements
                data: {
                    "nik": data.nik,
                    "shift": data.shift,
                    "email": data.email,
                    "<?= csrf_token() ?>": '<?= csrf_hash() ?>'
                },
                complete: function(params) {
                    console.log(params);
                },
                success: function(data) {
                    console.log(data);
                    // Handle the success response data here
                    document.getElementsByClassName('content-message')[0].innerHTML = `<div class="text-green-400 btn btn-lg flex flex-col gap-2 items-center"><p class="text-green-400">Success</p><p class="text-green-400">${data.success}</p></div>`
                    
                },
                error: function(data) {
                    console.error(data);
                    document.getElementsByClassName('content-message')[0].innerHTML = `<div class=" btn btn-lg flex flex-col gap-2 items-center" ><p class="text-red-400">Failed</p><p class="text-red-400">${data.responseJSON.error}</p></div>`

                }
            });
        });p
    }

    function closeCamera() {
        if (scanner) {
            scanner.stop();
            document.getElementById('preview').classList.add('hidden')
        }
    }


    // if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    //     console.log('getUserMedia is supported');
    // } else {
    //     console.error('getUserMedia is not supported');
    // }
</script>
<?= $this->endSection('content'); ?>