const adminPanelUsersSelector = document.querySelector('#select_users');
const adminPanelNewsSelector = document.querySelector('#select_news');
const adminPanelTeamsSelector = document.querySelector('#select_teams');
const adminPanelResultsSelector = document.querySelector('#select_results');
const adminPanelEventsSelector = document.querySelector('#select_events');

if (adminPanelUsersSelector) {
    
    adminPanelUsersSelector.addEventListener('click', (e) => {
        console.log('click user')
    })
}
if (adminPanelNewsSelector) {
    
    adminPanelNewsSelector.addEventListener('click', (e) => {
        console.log('click news')
    })
}

if (adminPanelTeamsSelector) {
    
    adminPanelTeamsSelector.addEventListener('click', (e) => {
        console.log('click teams')
    })
}

if (adminPanelResultsSelector) {
    
    adminPanelResultsSelector.addEventListener('click', (e) => {
        console.log('click results')
    })
}

if (adminPanelEventsSelector) {
    
    adminPanelEventsSelector.addEventListener('click', (e) => {
        console.log('click events')
    })
}