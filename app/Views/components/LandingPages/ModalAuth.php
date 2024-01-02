<div class="z-[1000] backdrop-blur-sm absolute w-full h-full authMessage hidden" >
    <div class=" h-full w-full flex justify-center items-center" >
        <div class="bg-white shadow-lg pt-2 pb-6 px-12 rounded-lg" >
                <div class="flex flex-col gap-4" >
                    <div class="flex gap-10 items-center mt-5" >
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <p class="text-xl font-semibold text-orange-400" >Message</p>
                    </div>
                    <div class="flex flex-col  gap-2" >
                        <h1 class="text-3xl font-bold" >Authentication Required</h1>
                        <p class="font-semibold" >Please Login First Or Make New Account </p>
                    </div>
                    <div class="flex gap-6 items-center justify-end">
                    <button onclick="hiddenModalMustLogin()" class="btn btn-error" >Close</button>
                    <a href="/login" class="btn btn-success">Login</a>
                    </div>
                </div>
        </div>
    </div>
</div>
