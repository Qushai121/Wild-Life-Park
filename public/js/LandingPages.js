
// ini untuk setHambergerMenu Di navbar All Page
document.addEventListener("DOMContentLoaded", function () {
    const hamburgerMenus = document.getElementById("hamburgerMenus")
    const dropdownHovers = document.querySelectorAll(".dropdown-hover")
    dropdownHovers.forEach(dropdownHover => {

        if (isMobileViewport()) {
            dropdownHover.classList.remove('dropdown-hover')
            dropdownHover.classList.add('dropdown-top')
        } else {
            dropdownHover.classList.remove('dropdown-top')
        }
    })
    isMobileViewport() ? hamburgerMenus.classList.remove('open') : ''
});

function setHambergerMenu() {
    const wrapperHamberger = document.getElementById("nav-icon4")
    let stateHamberger = wrapperHamberger.classList.contains('open')
    const hamburgerMenus = document.getElementById("hamburgerMenus")

    if (stateHamberger) {
        wrapperHamberger.classList.remove('open')
        hamburgerMenus.classList.remove('open')
    } else {
        wrapperHamberger.classList.add('open')
        hamburgerMenus.classList.add('open')
    }
}

function isMobileViewport() {
    return window.innerWidth <= 768; // Adjust the threshold as needed
}
