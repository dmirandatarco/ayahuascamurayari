$(function() {

  // sample calendar events data

  var Draggable = FullCalendar.Draggable;
  var calendarEl = document.getElementById('fullcalendar');
  var containerEl = document.getElementById('external-events');

  var curYear = moment().format('YYYY');
  var curMonth = moment().format('MM');

  // Calendar Event Source
  

  new Draggable(containerEl, {
    itemSelector: '.fc-event',
    eventData: function(eventEl) {
      return {
        title: eventEl.innerText
      };
    }
  });


  // initialize the calendar
  var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
      left: '',
      center: '',
      right: ''
    },
    editable: true,
    droppable: true, // this allows things to be dropped onto the calendar
    // height: 300,
    initialView: 'timeGrid',
    timeZone: 'America/Latina',
    hiddenDays:[],
    duration: { days: 4 },
    // weekNumbers: true,
    // weekNumberFormat: {
    //   week:'numeric',
    // },
    dayMaxEvents: 2,
    events: [],
    drop: function(info) {
        // remove the element from the "Draggable Events" list
        // info.draggedEl.parentNode.removeChild(info.draggedEl);
    },
    eventClick: function(info) {
      var eventObj = info.event;
      console.log(info);
      $('#modalTitle1').html(eventObj.title);
      $('#modalBody1').html(eventObj._def.extendedProps.description);
      $('#eventUrl').attr('href',eventObj.url);
      $('#fullCalModal').modal("show");
    },
    dateClick: function(info) {
      $("#createEventModal").modal("show");
      console.log(info);
    },
  });

  calendar.render();


});