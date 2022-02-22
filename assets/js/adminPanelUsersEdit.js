const adminPanelEmailSelector = document.querySelector('#user_email');
const adminPanelNicknameSelector = document.querySelector('#user_nickname');
const adminPanelFirstNameSelector = document.querySelector('#user_firstName');
const adminPanelLastNameSelector = document.querySelector('#user_lastName');
const adminPanelPhoneSelector = document.querySelector('#user_phone');
const adminPanelBirthDateSelector = document.querySelector('#user_birthDate');
const adminPanelLicenseSelector = document.querySelector('#user_license');
const adminPanelTeamSelector = document.querySelector('#user_team');
const adminPanelStaffSelector = document.querySelector('#user_staff');
const adminPanelSaveButtonSelector = document.querySelector('#admin_save_button');
const adminPanelH1Selector = document.querySelector('h1');


console.log('Script adminPanelUsers initialized');

let editElements = []

document.querySelectorAll('[data-edit]').forEach(element => {
    element.addEventListener('click', e => editTd(element))
})

function editTd(element){
    const input = element.querySelector('.input')
    input.classList.remove('invisible')
}


adminPanelEmailSelector.style.cursor = "pointer";
adminPanelEmailSelector.addEventListener('click', (e) => {
    console.log('clicked nickname')
})

adminPanelNicknameSelector.style.cursor = "pointer";
adminPanelNicknameSelector.addEventListener('click', (e) => {
    console.log('clicked nickname')
})

adminPanelFirstNameSelector.style.cursor = "pointer";
adminPanelFirstNameSelector.addEventListener('click', (e) => {
    console.log('clicked firstname')
})

adminPanelLastNameSelector.style.cursor = "pointer";
adminPanelLastNameSelector.addEventListener('click', (e) => {
    console.log('clicked lastname')
})

adminPanelPhoneSelector.style.cursor = "pointer";
adminPanelPhoneSelector.addEventListener('click', (e) => {
    console.log('clicked phone')
})

adminPanelBirthDateSelector.style.cursor = "pointer";
adminPanelBirthDateSelector.addEventListener('click', (e) => {
    console.log('clicked birthdate')
})

adminPanelLicenseSelector.style.cursor = "pointer";
adminPanelLicenseSelector.addEventListener('click', (e) => {
    console.log('clicked license')
})

adminPanelTeamSelector.style.cursor = "pointer";
adminPanelTeamSelector.addEventListener('click', (e) => {
    console.log('clicked team')
})

adminPanelStaffSelector.style.cursor = "pointer";
adminPanelStaffSelector.addEventListener('click', (e) => {
    console.log('clicked staff')
})

adminPanelSaveButtonSelector.addEventListener('click', (e) => {
    if (confirm("Etes-vous sur·e ? Ces changements sont irreversibles") == true) {
        console.log("form submit")
        const alert = document.createElement("div");
        alert.classList.add("alert alert-success")
        adminPanelH1Selector.after(alert)
    } else {
        const alert = document.createElement("div");
        alert.classList.add("alert alert-warning")
        adminPanelH1Selector.appendChild(alert)
    }
})
