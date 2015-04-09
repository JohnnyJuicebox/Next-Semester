@extends('layouts.course_default')

@section('headScripts')
<script>
function getCorrespondingDay(day){

	switch(day){
		case 'M':
			return 1;
		case 'T':
			return 2;
		case 'W':
			return 3;
		case 'R':
			return 4;
		case 'F':
			return 5;
		case 'S':
			return 6;
	}
}

function dateString(tomorrow){
	
	var d = tomorrow.getDate();
	var m = (tomorrow.getMonth()+1);
	var y = tomorrow.getFullYear();

	if(d < 10){
		d = "0" + d;
	}

	if(m < 10){
		m = "0" + m;
	}

	return y + "-" + m + "-" + d;
}

function validate(val){
	if(!val){
		return "";
	}
	return val;
}
$(document).ready(function(){
	

	$('#save').click(function(){
		
		var checkValues = $('input:radio[name$=secName]:checked').map(function(){
	    	return $(this).val();
	    }).get();

		$.ajax({
	        url: 'manualstore',
	        type: 'get',
	        data: { secNames: checkValues },
	        success:function(data){
	        	$('#calendar').fullCalendar('refetchEvents');
        	}
    	});
	});

	Array.prototype.remove = function(value) {
		var idx = this.indexOf(value);
		if (idx != -1) {
		    return this.splice(idx, 1); // The second parameter is the number of elements to remove.
		}
		return false;
	}

	$('#calendar').fullCalendar({
		header: {
			left: '',
			center: '',
			right: ''
		},
		hiddenDays: [0],
		editable: false,
		eventLimit: true, // allow "more" link when too many events
		defaultView: 'agendaWeek',
		minTime: "08:00:00",
		maxTime: "22:00:00",
		allDaySlot: false,
		events: 'usermanualschedule', 
		eventRender: function(event, element) { 
            element.find('.fc-title').append("<br/>" + event.description);
        }
	});

	var secList = [];

	$("#search").click(function(){
		
		var cname = $("input[name=courseName]").val();
		var url = "searchCourse/" + cname;
		$(".sections").append('<div id="' + cname + '"></div>');

		$.getJSON(url, function(json){
		
			if(json.length != 0){

				secList.push(cname + 'secName');
				var today = new Date();
				$("#" + cname).append('<div class="cname">' + cname + '</div>');
				$("#" + cname).append('<a class="' + cname + 'close">close</a><br/>');
				$.each(json, function(i, val){
					var sname = '<input type="radio" name="' + cname + 'secName" value="'+ val["id"] +'"/>  ' + val["sec_no"] + "<br/>"; 
					$("#" + cname).append(sname);
				});

				var secUrl = 'searchCourse/section/';
				var secID = -1;
				$('.' + cname + 'close').on("click", function(){
					$("#" + cname).remove();
					var url = "searchCourse/" + cname;
					secList.remove(cname + 'secName');
					$.getJSON(url, function(jsonInside){
						$.each(jsonInside, function(i, val){
							$('#calendar').fullCalendar('removeEvents', val["id"]);
						});
					});
				});
				$("input[name=" + cname + "secName]").on("click", function(){
					
					// Comment these lines out 
					$.getJSON(url, function(jsonInside){
						$.each(jsonInside, function(i, val){
							$('#calendar').fullCalendar('removeEvents', val["id"]);
						});
					});
					// Comment these lines out
					var oldID = secID;
					
					secID = $('input:radio[name=' + cname + 'secName]:checked').val();
					//alert(secID);
					$.getJSON(secUrl + secID, function(data){
						$.each(data, function(i, val){
							
							var newEvent = new Object();
							var tomorrow = new Date(today);
							//alert("here");
							tomorrow.setDate((today.getDate())+ (getCorrespondingDay(val["day"])-today.getDay()));
							
							newEvent.id = secID;
							var rating;
							if(val["rating"] ){
								rating = Math.round(val["rating"]*100)/100;
								if(rating != -1){
									newEvent.title = newEvent.title + " " + rating;
								}
							}
							newEvent.title = cname + val["day"];
							newEvent.url = 'course/' + cname;
							
							newEvent.start = dateString(tomorrow) + " " + val["startTime"];
							newEvent.end = dateString(tomorrow) + " " + val["endTime"];
							newEvent.description = validate(val["fname"]) + " " + validate(val["lname"]) + "<br/>" + validate(val["roomInfo"]);
							newEvent.allDay = false;

							$('#calendar').fullCalendar('renderEvent', newEvent);

						});

					});
				});

			}
		});
	}).fail(function(jqXHR, status, error){
		$(".sections").empty();
		$(".sections").append("<p>No such course found</p>");
	});
});

</script>
@stop

@section('content')
<div id="row">
	<div class="large-3 columns">
		<input type="text" name="courseName" />
		<a id="search" class="button postfix">Search</a><br/>
		<div class="sections">
		</div>
		<a id="save" class="button postfix">Save</a>
	</div>
	<div class="large-9 columns">
		<div id="calendar">
		</div>
	</div>
</div>
@stop

@section('tailScripts')
@stop
