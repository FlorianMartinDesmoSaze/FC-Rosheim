const adminPanelSaveButtonSelector = document.querySelector('#admin_save_button');


console.log('Script adminPanelUsers initialized');

let editElements = []

document.querySelectorAll('[data-edit]').forEach(element => {
    element.style.cursor = "pointer";
    // element.addEventListener('click', e => editTd(element))
})

function editTd(element){
    const input = element.querySelector('.input')
    input.style.display = none;
    const value = element.querySelector('.value')
    value.style.display = block;
}

adminPanelSaveButtonSelector.addEventListener('click', (e) => {
    if (confirm("Etes-vous sur·e ? Ces changements sont irreversibles") == true) {
        console.log("form submitted")
    } else {
        e.preventDefault()
        console.log("form aborted")
    }
})
