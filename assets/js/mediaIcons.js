// const trigger = document.querySelector('.fa-up-right-from-square');

// trigger.addEventListener('click', () => {
//     const facebook = document.querySelector('.fa-facebook-square')
//     console.log(facebook);

//     const youtube = document.querySelector('.fa-youtube')
//     console.log(youtube);

//     facebook.classList.toggle('active')
//     setTimeout(() => {
//         youtube.classList.toggle('active')
//     }, 50);
// })

// same thing done dynamicly
function display(trigger, item) {
    const triggerEl = document.querySelector(trigger);
    const classElement = document.querySelectorAll(item);
    let delay = 0;
    let timeout = null;
    triggerEl.addEventListener('click', () => {
        classElement.forEach(element => {
            timeOut = setTimeout(() => {
                element.classList.toggle('active');
            }, delay);
            delay += 50;
        });
        delay=0;
        clearTimeout(timeout);
    })
}

display('.fa-solid', '.fa-brands');