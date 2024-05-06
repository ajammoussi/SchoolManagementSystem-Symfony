console.log(schedule);
console.log(schedule[0]['day_of_week']);

let events = [];
let colors=['#6e2020','#165a16','#0000FF','#17176e','#54b5b5','#9b489b'];
let bindColor={};
schedule.forEach(function(item) {
    let start_task = item['start_date']+'T'+item['start_time'];
    let end_task = item['start_date']+'T'+item['end_time'];
    if(!bindColor[item['description']]){
        bindColor[item['description']]=colors.pop();
    }
    let event = {
        title: item['description'], // Description
        start: start_task, // Start time
        end: end_task, // End time
        color: bindColor[item['description']] // Color (you can customize this from the list of available colors)
    };

    events.push(event);
});


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        allDaySlot: false,
        slotMinTime: '08:00:00',
        slotMaxTime: '22:00:00',
        hiddenDays: [0],
        events: events // Pass the events array here
    });
    calendar.render();
});