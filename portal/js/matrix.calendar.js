
$(document).ready(function(){
	
	maruti.init();
	
	$('#add-event-submit').click(function(){
		maruti.add_event();
	});
	
	$('#event-name').keypress(function(e){
		if(e.which == 13) {	
			maruti.add_event();
		}
	});	
});

maruti = {	
	
	// === Initialize the fullCalendar and external draggable events === //
	init: function() {	
		// Prepare the dates
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();	
		
		$('#fullcalendar').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			firstDay: 1,
			editable: true,
			droppable: true, // this allows things to be dropped onto the calendar !!!
			eventDrop: function(event, delta, revertFunc) {
				var newDate = new Date(event.start);
				var output = newDate.getFullYear( ) +'-'+ (Number(newDate.getMonth( )) + 1) +'-'+ newDate.getDate( );
				
				var id = event.url.substring(2);
				//alert(event.url);
				
				var del;
				if (event.url.indexOf("f") > -1)
				{
					del = "first";
				}
				else if (event.url.indexOf("s") > -1)
				{
					del = "second";
				}
				else if (event.url.indexOf("t") > -1)
				{
					del = "third";
				}
				
				var xmlhttp = new XMLHttpRequest();
				
			    xmlhttp.onreadystatechange = function() {
			        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
			           if (xmlhttp.status == 200) {
			        	  // alert(xmlhttp.responseText);
			              // window.location.reload();
			           }
			           else if (xmlhttp.status == 400) {
			              alert('There was an error 400');
			           }
			           else {
			               alert('something else other than 200 was returned');
			           }
			        }
			    };
			
			    xmlhttp.open("GET", "actions/updatedeliverydate.php?fid=" + id + "&del=" + del + "&date=" + output, true);
			    xmlhttp.send();
		    },
			drop: function(date, allDay) { // this function is called when something is dropped
				
				// retrieve the dropped element's stored Event Object
				var originalEventObject = $(this).data('eventObject');
					
				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);
					
				// assign it the date that was reported
				copiedEventObject.start = date;
				copiedEventObject.allDay = allDay;
				
				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
				$('#fullcalendar').fullCalendar('renderEvent', copiedEventObject, true);
					
				// is the "remove after drop" checkbox checked?
				
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				
			}
		});
		this.external_events();		
	},
	
	// === Adds an event if name is provided === //
	add_event: function(){
		if($('#event-name').val() != '') {
			var event_name = $('#event-name').val();
			$('#external-events .panel-content').append('<div class="external-event ui-draggable label label-inverse">'+event_name+'</div>');
			this.external_events();
			$('#modal-add-event').modal('hide');
			$('#event-name').val('');
		} else {
			this.show_error();
		}
	},
	
	// === Initialize the draggable external events === //
	external_events: function(){
		/* initialize the external events
		-----------------------------------------------------------------*/
		$('#external-events div.external-event').each(function() {		
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
	},
	
	// === Show error if no event name is provided === //
	show_error: function(){
		$('#modal-error').remove();
		$('<div style="border-radius: 5px; top: 70px; font-size:14px; left: 50%; margin-left: -70px; position: absolute;width: 140px; background-color: #f00; text-align: center; padding: 5px; color: #ffffff;" id="modal-error">Enter event name!</div>').appendTo('#modal-add-event .modal-body');
		$('#modal-error').delay('1500').fadeOut(700,function() {
			$(this).remove();
		});
	}
	
	
};