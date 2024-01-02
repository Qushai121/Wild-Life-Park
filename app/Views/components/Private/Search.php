    <div class="flex items-center gap-2">
        <input name="search" value="<?= $request->getGet('search'); ?>" type="text" id="search" placeholder="Search" class="input input-bordered w-full max-w-xs" />
        <button type="submit" class="btn btn-circle group bg-blue-400">
            <svg class="w-6 h-6 fill-blue-400 group-hover:fill-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path class="stroke-white group-hover:stroke-blue-400" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
        </button>
    </div>