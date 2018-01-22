$(document).ready(function() {
	    var min_time = '';
	    var max_time = '';
		/*$.post(base_url+'user/guru_available_time',{mentor_id:$('#app_id').val()},function(res){
			     var data = JSON.parse(res);
			     console.log(data);
                 min_time = data.min_time;
                 max_time = data.max_time;
		});*/
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'listDay,listWeek,month'
			},

			// customize the button names,
			// otherwise they'd all just say "list"
			views: {
				listDay: { buttonText: 'list day' },
				listWeek: { buttonText: 'list week' }
			},
            slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
            minTime: min_time,
            maxTime: max_time,  
            allDayDefault: false,
			defaultView: 'listWeek',
			allDaySlot: true,
            handleWindowResize: true, 
			//defaultDate: '2017-09-12',
			navLinks: true, // can click day/week names to navigate views
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			eventSources: [base_url+'user/render_available_time']
		});
		
	});
