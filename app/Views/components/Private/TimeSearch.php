<div class=" flex items-center justify-center xl:justify-end xl:gap-2 gap-10 w-full">
    <label for="time_input">Enter Time:</label>
    <input type="time" value="<?= $request->getGet('time') ?? $nowTime; ?>" id="time_input" class="border-gray-400" name="time" required>
    <button type="submit" class="btn btn-circle group bg-blue-400">
        <svg class="w-6 h-6 fill-blue-400 group-hover:fill-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path class="stroke-white group-hover:stroke-blue-400" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
        </svg>
    </button>
</div>