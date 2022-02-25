

document.addEventListener('DOMContentLoaded', () => {
    var calendarEl = document.getElementById('calendar-holder');
    if(calendarEl){

    var calendar = new FullCalendar.Calendar(calendarEl, {
        defaultView: 'dayGridMonth',
        allDay: true, // hide event time
        editable: true,
        test: 'test',
        eventSources: [
            {
                url: "{{ path('fc_load_events') }}",
                method: "POST",
                extraParams: {
                    filters: JSON.stringify({})
                },
                failure: () => { // alert("There was an error while fetching FullCalendar!");
                }
            },
        ],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        plugins: [
            'interaction', 'dayGrid', 'timeGrid'
        ], // https://fullcalendar.io/docs/plugin-index
        timeZone: 'UTC'
    });
    calendar.setOption('locale', 'fr');
    calendar.render();
    }
});