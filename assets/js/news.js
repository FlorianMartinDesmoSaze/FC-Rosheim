const arrow = document.querySelector('#down_arrow')
// add click event on arrow
arrow.addEventListener('click', () => {
    let news = document.querySelectorAll(".card-news");
    //if first news is display block
    if (news[0].style.display === "block") {
        //on click first news disappear and second one appear
        news[0].style.display = "none";
        news[1].style.display = "block";
        news[2].style.display = "none"
    } else if(news[1].style.display === "block"){
        news[0].style.display = "none";
        news[1].style.display = "none";
        news[2].style.display = "block"
    } else{
        news[0].style.display = "block";
        news[1].style.display = "none";
        news[2].style.display = "none"
    }
})