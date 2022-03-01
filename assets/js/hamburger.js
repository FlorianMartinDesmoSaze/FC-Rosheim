const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");
const arrow = document.querySelector('#down_arrow');
console.log(down_arrow);
hamburger.addEventListener("click", mobileMenu);

function isEven(n) {
    return n % 2 == 0;
}
let userClick = 0;

function mobileMenu() {
    userClick++;
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
    const news = document.querySelectorAll('.card-news')
    
    news.forEach((e) => {
        e.classList.toggle("hiden");
    })
    if (isEven(userClick)) {
        console.log('if');
        arrow.setAttribute('style', 'opacity:1' )
        arrow.classList.toggle('exclusion');
    }else {
        console.log('not if');
        arrow.setAttribute('style', 'opacity:0' )
        arrow.classList.toggle('exclusion');
    }
    console.log(userClick);
}