var Calendar = function () {


    return {
        //main function to initiate the module
        init: function () {
            Calendar.initCalendar();
        },

        initCalendar: function () {

            if (!jQuery().fullCalendar) {
                return;
            }

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var h = {};

            if (Metronic.isRTL()) {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        right: 'title, prev, next',
                        center: '',
                        right: 'agendaDay, agendaWeek, month, today'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        right: 'title',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today, prev,next'
                    };
                }
            } else {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        left: 'title, prev, next',
                        center: '',
                        right: 'today,month,agendaWeek,agendaDay'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                }
            }


            var initDrag = function (el) {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim(el.text()) // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                el.data('eventObject', eventObject);
                // make the event draggable using jQuery UI
                el.draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });
            }

            var addEvent = function (title) {
                title = title.length == 0 ? "Untitled Event" : title;
                var html = $('<div class="external-event label label-default">' + title + '</div>');
                jQuery('#event_box').append(html);
                initDrag(html);
            }

            $('#external-events div.external-event').each(function () {
                initDrag($(this))
            });

            $('#event_add').unbind('click').click(function () {
                var title = $('#event_title').val();
                addEvent(title);
            });

            //predefined events
            $('#event_box').html("");

            $('#calendar').fullCalendar('destroy'); // destroy the calendar
            $('#calendar').fullCalendar({ //re-initialize the calendar
                header: h,
                defaultView: 'month', // change default view with available options from http://arshaw.com/fullcalendar/docs/views/Available_Views/
                slotMinutes: 15,
                editable: true,
                dragOpacity: {//设置拖动时事件的透明度
                    agenda: .5,
                    '':.6
                },
                //拖动事件
                eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {
                    $.post("/index.php?m=admin&c=calendar&a=event&ac=drag", {
                        id: event.id,
                        daydiff: dayDelta,
                        minudiff: minuteDelta,
                        allday: allDay
                    }, function (msg) {
                        if (msg != 1) {
                            alert(msg);
                            revertFunc(); //恢复原状
                        }
                    });
                },

                eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
                    $.post("/index.php?m=admin&c=calendar&a=event&ac=resize",{id:event.id,daydiff:dayDelta,minudiff:minuteDelta},function(msg){
                        if(msg!=1){
                            alert(msg);
                            revertFunc();
                        }
                    });
                },

                selectable: true,
                select: function( startDate, endDate, allDay, jsEvent, view ){
                    var start =$.fullCalendar.formatDate(startDate,'yyyy-MM-dd');
                    var end =$.fullCalendar.formatDate(endDate,'yyyy-MM-dd');
                    $.fancybox({
                        'type':'ajax',
                        'href':'/index.php?m=admin&c=calendar&a=event&ac=add&start='+start+'&end='+end
                    });
                },


                events: '/index.php?m=admin&c=calendar&a=show',    //事件数据
                dayClick: function(date, allDay, jsEvent, view) {
                    var start =$.fullCalendar.formatDate(date,'yyyy-MM-dd');//格式化日期
                    $.fancybox({//调用fancybox弹出层
                        'type':'ajax',
                        'href':'/index.php?m=admin&c=calendar&a=event&ac=add&start='+start
                    });
                },
                eventClick: function(calEvent, jsEvent, view) {
                    $.fancybox({
                        'type':'ajax',
                        'href':'/index.php?m=admin&c=calendar&a=event&ac=edit&id='+calEvent.id
                    });
                }





            });

        }

    };

}();