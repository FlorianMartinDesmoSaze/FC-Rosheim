const trigger = document.querySelector('.fa-solid');
const links = document.querySelectorAll('.fa-brands');

trigger.addEventListener('click', ()=> {
    console.log(links);
links.forEach(link => {
    console.log(link);
    link.classList.toggle('active');
});
});