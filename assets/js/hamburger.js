const arrow = document.querySelector('#down_arrow');

if (arrow) {
    
    const hamburger = document.querySelector(".hamburger");
    const navMenu = document.querySelector(".nav-menu");
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
            arrow.setAttribute('style', 'opacity:.7' )
            arrow.classList.toggle('exclusion');
        }else {
            arrow.setAttribute('style', 'opacity:0' )
            arrow.classList.toggle('exclusion');
        }
    }
}