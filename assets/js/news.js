const arrow = document.querySelector('#down_arrow');
let news = document.querySelectorAll(".card-news");
// add click event on arrow
news[0].style.display = "block";
if (arrow){arrow.addEventListener('click', () => {
    //if first news is display block
    if (news[0].style.display === "block") {
        console.log('1');
        //on click first news disappear and second one appear
        news[0].style.display = "none";
        news[1].style.display = "block";
        news[2].style.display = "none"
    } else if(news[1].style.display === "block"){
        console.log('2');
        news[0].style.display = "none";
        news[1].style.display = "none";
        news[2].style.display = "block"
    } else{
        console.log('3');
        news[0].style.display = "block";
        news[1].style.display = "none";
        news[2].style.display = "none"
    }
})}

// cereer une classe hiden en 