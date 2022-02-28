const adminPanelSaveButtonSelector = document.querySelector('#admin_save_button');
const adminPanelDeleteButtonSelector = document.querySelector('#admin_delete_button');

adminPanelSaveButtonSelector.addEventListener('click', (e) => {
    if (confirm("Êtes-vous sûr·e de vouloir modifier ces données ?") == true) {
        console.log("form submitted")
    } else {
        e.preventDefault()
        console.log("form aborted")
    }
})
adminPanelDeleteButtonSelector.addEventListener('click', (e) => {
    if (confirm("Êtes-vous sûr·e de vouloir supprimer ces données ? Ces changements sont irréversibles.") == true) {
        console.log("delete query submitted")
    } else {
        e.preventDefault()
        console.log("delete query aborted")
    }
})
