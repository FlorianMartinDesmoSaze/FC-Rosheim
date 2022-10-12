let $userInput = false;
let $isSubmitted = false;
const tdSelector = document.querySelectorAll("td")
const formSelector = document.querySelectorAll("form")

console.log('adminLeaveWarning initialized');

document.addEventListener("DOMContentLoaded", function(event) {
    tdSelector.forEach(e =>{
        e.addEventListener("change", function() {
            $userInput = true;
        })
    })
    formSelector.forEach(e =>{
        e.addEventListener("submit", function() {
            $isSubmitted = true;
            console.log("$isSubmitted = true;")
        })
    })

    window.onbeforeunload = function () {
        if ($userInput && !$isSubmitted) {
            return "Vos modifications n'ont pas été enregistrées.\
      Êtes-vous sûr de vouloir quitter cette page ?";
        }
    }
});