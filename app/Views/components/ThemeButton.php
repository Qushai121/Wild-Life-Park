<button class="btn btn-sm bg-stone-200" onclick="themeChange()">
    ganti
</button>

<script>
    let html = document.documentElement
    let mode = localStorage.getItem('mode')

    window.onload = () => {
        html.classList.add(mode);
    }

    function themeChange() {
        html.classList.remove(mode);

        if (mode === 'dark') {
            localStorage.setItem('mode', 'light');
        }
        if (mode === 'light' || !mode) {
            localStorage.setItem('mode', 'dark');
        }

        mode = localStorage.getItem('mode')
        html.classList.add(mode);
    }
</script>

