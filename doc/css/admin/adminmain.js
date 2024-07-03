function navMiniOpen() {
    const nav_mini = document.querySelector('#main_nav_mini');
    nav_mini.classList.remove('main_nav_mini')
}

const nav_list = document.querySelector('.main_nav_list');
nav_list.addEventListener('click', navMiniOpen);