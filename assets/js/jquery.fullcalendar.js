

!function($) {

    "use strict";



    var CalendarApp = function() {

        this.$body = $("body")

        this.$modal = $('#event-modal'),

        this.$event = ('#external-events div.external-event'),

        this.$calendar = $('#calendar'),

        this.$saveCategoryBtn = $('.save-category'),

        this.$categoryForm = $('#add-category form'),

        this.$extEvents = $('#external-events'),

        this.$calendarObj = null;

        

    };

    

    var m = moment();

    var noTime = $.fullCalendar.moment('2014-05-01');

    var local = $.fullCalendar.moment('2014-05-01T12:00:00');

    var utc = $.fullCalendar.moment.utc('2014-05-01T12:00:00');

    var noTZ = $.fullCalendar.moment.parseZone('2014-05-01T12:00:00');

    var calendar = $('#calendar').fullCalendar('getCalendar');

    var m = calendar.m;

    

    var m = $.fullCalendar.moment('2014-01-22');

    m.hasTime();



    var m = $.fullCalendar.moment('2014-01-22T05:00:00');

    m.stripTime();

    m.hasTime();



    /* on drop */

    CalendarApp.prototype.onDrop = function (eventObj, date) { 

        var $this = this;

            // retrieve the dropped element's stored Event Object

            var originalEventObject = eventObj.data('eventObject');

            var $categoryClass = eventObj.attr('data-class');

            // we need to copy it, so that multiple events don't have a reference to the same object

            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported

            copiedEventObject.start = date;

            if ($categoryClass)

                copiedEventObject['className'] = [$categoryClass];

            // render the event on the calendar

            $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);

            // is the "remove after drop" checkbox checked?

            if ($('#drop-remove').is(':checked')) {

                // if so, remove the element from the "Draggable Events" list

                eventObj.remove();

            }

    },

    /* on click on event */

    CalendarApp.prototype.onEventClick =  function (calEvent, jsEvent, view) {

        var $this = this;

            var form = $("<form></form>");

            form.append("<label>Change event name</label>");

            form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><input class='form-control' type=hidden value='" + calEvent.id + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success waves-effect waves-light'><i class='fa fa-check'></i> Save</button></span></div><a href='javascript:void(0)' style='text-decoration:underline;' onclick='more_details("+calEvent.id+")'>More Details</a><div class='moredetails'></div>");

            $this.$modal.modal({

                backdrop: 'static'

            });

            $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {

                calEvent.id = form.find("input[type=hidden]").val();

                var choice = confirm(this.getAttribute('data-confirm'));

                if(choice){

                    $.post(base_url+'user/delete_event',{invite_id:calEvent.id},function(response){

                    if(response == 1){

                        $this.$calendarObj.fullCalendar('removeEvents', function (ev) {

                            return (ev._id == calEvent._id);

                        });

                        $this.$modal.modal('hide');

                   }

                  });

                }

            });

            $this.$modal.find('form').on('submit', function () {

                calEvent.title = form.find("input[type=text]").val();

                calEvent.id = form.find("input[type=hidden]").val();

                $.post(base_url+'user/update_event_name',{event_title:calEvent.title,invite_id:calEvent.id},function(response){

                    if(response == 1){

                        $this.$calendarObj.fullCalendar('updateEvent', calEvent);

                        $this.$modal.modal('hide');

                    }

                });

                

                return false;

            });

    },

    /* on select */

    CalendarApp.prototype.onSelect = function (start, end, allDay) {

        var $this = this;

            var select_date = '';

            if(typeof start.start._i === 'undefined'){

              select_date = start._d;

            }else{

              select_date = start.start._i;  

            }

            var form = $("<form></form>");

            var d = convertDate(select_date);

            console.log(start)


            $.post(base_url+'user/today_conversation',{date:start.start._i,timezone:start.timezone},function(response){

                if(response == 0){

                    return false;

                }else{

                    $this.$modal.modal();

                    $('.modal-title').html('Today Conversations');

                    $('.modal-body').html(response);

                }

            });

          

            $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {

                 form.submit();

            });

            $this.$calendarObj.fullCalendar('unselect');

    };



    CalendarApp.prototype.enableDrag = function() {

        //init events

        $(this.$event).each(function () {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)

            // it doesn't need to have a start or end

            var eventObject = {

                title: $.trim($(this).text()) // use the element's text as the event title

            };

            // store the Event Object in the DOM element so we can get to it later

            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI

            $(this).draggable({

                zIndex: 999,

                revert: true,      // will cause the event to go back to its

                revertDuration: 0  //  original position after the drag

            });

        });

    }

    /* Initializing */

    CalendarApp.prototype.init = function() {

        //this.enableDrag();

        /*  Initialize the calendar  */

        var date = new Date();

        var d = date.getDate();

        var m = date.getMonth();

        var y = date.getFullYear();

        var form = '';

        var today = new Date($.now());

        

        var defaultEvents =  [

        {

            title: 'Test Event 1',

            start: today,

            end: today,

            className: 'bg-success'

        },

        {

            title: 'Test Event 2',

            start: new Date($.now() + 168000000),

            className: 'bg-info'

        },

        {

            title: 'Test Event 3',

            start: new Date($.now() + 338000000),

            className: 'bg-primary'

        }];



        var $this = this;

        $this.$calendarObj = $this.$calendar.fullCalendar({

            slotDuration: '00:30:00', /* If we want to split day time each 15minutes */

            minTime: '08:00:00',

            maxTime: '19:00:00',  

            allDayDefault: false,

            defaultView: 'month',  

            allDaySlot: true,

            handleWindowResize: true,   

            height: $(window).height() + 100,   

            header: {

                left: 'prev,next today',

                center: 'title',

                right: 'month,agendaWeek,agendaDay'

            },

            eventSources: [base_url+'user/render_calendar_view'],
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            disableDragging: true,
            displayEventTime: false,

            drop: function(date) { $this.onDrop($(this), date); },

            select: function (start, end, allDay) { 


                $this.onSelect(start, end, allDay); },

            eventClick: function(calEvent, jsEvent, view) { $this.onSelect(calEvent, jsEvent, view); }



        });



        //on new event

        this.$saveCategoryBtn.on('click', function(){

            var categoryName = $this.$categoryForm.find("input[name='category-name']").val();

            var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();

            if (categoryName !== null && categoryName.length != 0) {

                $this.$extEvents.append('<div class="external-event bg-' + categoryColor + '" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="mdi mdi-checkbox-blank-circle m-r-10 vertical-middle"></i>' + categoryName + '</div>')

                //$this.enableDrag();

            }



        });

    },



   //init CalendarApp

    $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp

    

}(window.jQuery),



//initializing CalendarApp

function($) {

    "use strict";

    $.CalendarApp.init()

}(window.jQuery);



function rendermydata(data)

{

    return data;

}

function convertDate(d){

 var parts = d.toString().split(" ");

 var months = {Jan: "01",Feb: "02",Mar: "03",Apr: "04",May: "05",Jun: "06",Jul: "07",Aug: "08",Sep: "09",Oct: "10",Nov: "11",Dec: "12"};

 return parts[3]+"-"+months[parts[1]]+"-"+parts[2];

}

