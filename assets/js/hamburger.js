const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");
hamburger.addEventListener("click", mobileMenu);

function mobileMenu() {
    
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
    
    const news = document.querySelectorAll('.card-news')
    console.log(news);

    news.forEach((e) => {
        // console.log(e.style.opacity); 
        // if (e.style.opacity = 0) {
        //     e.style.opacity = 1;
        // } 
        e.classList.toggle("hiden");
    })
}