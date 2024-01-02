// SIDEBAR ------------------------------------------------------
let beforeDropdownMenu
let beforeParentClass

function handleOpenDropDown(route, parentClass) {
    const dropDownPrivate = localStorage.getItem('dropDownPrivate')

    if (beforeDropdownMenu) {
        beforeDropdownMenu.classList.remove('h-full');
        beforeDropdownMenu.classList.add('h-0');
        beforeParentClass.classList.add('rotate-0')
        beforeParentClass.classList.remove('rotate-180')
    }

    const dropdownMenu = parentClass.querySelector('.dropdownMenu');
    beforeDropdownMenu = dropdownMenu
    beforeParentClass = parentClass.querySelector('.chevron')

    if (dropDownPrivate) {
        dropdownMenu.classList.remove('h-full')
        dropdownMenu.classList.add('h-0')
        localStorage.removeItem('dropDownPrivate')
        parentClass.querySelector('.chevron').classList.remove('rotate-180')
        parentClass.querySelector('.chevron').classList.add('rotate-0')
    } else {
        dropdownMenu.classList.remove('h-0')
        dropdownMenu.classList.add('h-full')
        localStorage.setItem('dropDownPrivate', route)
        parentClass.querySelector('.chevron').classList.remove('rotate-0')
        parentClass.querySelector('.chevron').classList.add('rotate-180')
    };


}

const wrapperDropwDowns = document.querySelectorAll('.wrapperDropwDown');

wrapperDropwDowns.forEach(wrapperDropwDown => {
    const button = wrapperDropwDown.querySelector('.handleOpenDropDown')
    const dropdownMenu = wrapperDropwDown.querySelector('.dropdownMenu');
    const subMenuDropdown = dropdownMenu.querySelectorAll('.subMenuDropdown');

    const dropdownMenuHref = dropdownMenu.getAttribute('href');
    const dropDownPrivate = localStorage.getItem('dropDownPrivate')

    subMenuDropdown.forEach((e) => {
        if (e.getAttribute('href') == window.location.href) {

            button.querySelector('.chevron').classList.remove('rotate-0')
            button.querySelector('.chevron').classList.add('rotate-180')
            e.querySelector('div').classList.add('!bg-stone-400');
            e.querySelector('div').classList.add('text-white');
        } else {

            button.querySelector('.chevron').classList.remove('rotate-180')
            button.querySelector('.chevron').classList.add('rotate-0')
            e.querySelector('div').classList.remove('text-white');
            e.querySelector('div').classList.remove('!bg-stone-400');
        }
    });

    if (dropdownMenuHref == dropDownPrivate) {
        dropdownMenu.classList.add('h-full');
        dropdownMenu.classList.remove('h-0');
        button.querySelector('.chevron').classList.remove('rotate-0')
        button.querySelector('.chevron').classList.add('rotate-180')

    } else {
        button.querySelector('.chevron').classList.remove('rotate-180')
        button.querySelector('.chevron').classList.add('rotate-0')
        dropdownMenu.classList.add('h-0');
        dropdownMenu.classList.remove('h-full');
    };

    button.addEventListener('click', event => {
        // button.querySelector('.chevron').classList.add('rotate-180')
        const route = wrapperDropwDown.getAttribute('href');
        handleOpenDropDown(route, wrapperDropwDown)
    });

});

document.addEventListener('DOMContentLoaded', function () {
    var navLinks = document.querySelectorAll('.sidebarMenu');
    var currentURL = window.location.href;

    for (var i = 0; i < navLinks.length; i++) {
        navLinks[i].addEventListener('click', (e) => {
            localStorage.removeItem('dropDownPrivate')
        })
        if (navLinks[i].getAttribute('href') === currentURL) {
            const nearestDiv = navLinks[i].querySelector('div');
            const nearestImg = navLinks[i].querySelector('img');

            nearestDiv.classList.add('sidebarLinkPrivateActive');
            nearestImg.classList.add('pembalik');
        }
    }
});

// SIDEBAR ------------------------------------------------------------



// ini untuk input agar ketika input error tapi user mau input lagi
// errornya ilang 
const inputDataGroups = document.querySelectorAll(".inputDataGroup");

inputDataGroups.forEach(group => {
    const inputData = group.querySelector('input');
    const label = group.querySelector('label');

    inputData.addEventListener('input', event => {
        if (inputData.classList.contains('!border-red-400')) {
            inputData.classList.remove('!border-red-400');
            label.classList.remove('!text-red-400');
        }
        group.querySelector('p').style.display = 'none'
    });
});
// ------------------------------------------------------------------
let sidebarState = true

function handleSidebar() {
    const sidebarAdmin = document.getElementById('sidebarAdmin')

    if (sidebarState) {
        sidebarAdmin.classList.remove('w-[19rem]')
        sidebarAdmin.classList.add('w-0')
        sidebarState = false
    } else {
        sidebarAdmin.classList.add('w-[19rem]')
        sidebarAdmin.classList.remove('w-0')
        sidebarState = true
    }
}


const modals = document.querySelectorAll('.modal')

modals.forEach(modal => {
    modal.querySelector('.modal-action').querySelector('label').addEventListener('click', function (e) {
        modal.classList.remove('modal-open');
        modal.classList.add('modal-close');
    })
})