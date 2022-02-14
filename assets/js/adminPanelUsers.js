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
const adminPanelWarningButtonSelector = document.querySelector('#admin_save_button');


console.log('Script adminPanelUsers initialized');

adminPanelEmailSelector.style.cursor = "pointer";
adminPanelEmailSelector.addEventListener('click', (e) => {
    console.log('clicked email')
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
    adminPanelSaveButtonSelector.classList.add('btn-warning')
    adminPanelSaveButtonSelector.innerHTML='Attention, ces changements sont definitifs. Êtes-vous sûr·e  ?'
    adminPanelSaveButtonSelector.id = 'admin_final_save_button'
})
adminPanelWarningButtonSelector.addEventListener('click', (e) => {
    console.log('saved')
})