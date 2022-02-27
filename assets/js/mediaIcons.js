const trigger = document.querySelector('.fa-up-right-from-square');

trigger.addEventListener('click', () => {
    const facebook = document.querySelector('.fa-facebook-square')
    console.log(facebook);

    const youtube = document.querySelector('.fa-youtube')
    console.log(youtube);

    facebook.classList.toggle('active')
    setTimeout(() => {
        youtube.classList.toggle('active')
    }, 50);
})