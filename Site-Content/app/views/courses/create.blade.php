@extends('layouts.course_default')

@section('headScripts')
<script>
/* $(document).ready(function(){ */
/*     $.ajax({ */
/*         url: 'http://localhost/courses', */
/*         type: 'GET', */
/*         success: function(data){ */
/*             $.each(data, function(key, value){ */
/*                 var item = "<h3 id=" + value.cname  + ">" + value.cname + "</h3>"; */
/*                 item = item + "<div><p>" +value.cdesc + "</p></div>"; */
/*                 $('#accord').append(item); */
/*             }); */
/*         } */
/*     }); */

/* }); */

/* $(document).ready(function(){ */

/*     function log(ind, message){ */
/*         $("#getCourses").append('<input class="secs" type="radio" name="sections" value=' + ind +'>' + message["sec_no"] + '<br/>'); */
/*         $("#getCourses").scrollTop(0); */
/*     } */

/*     function logTest(item){ */
/*         $("#getCourses").empty(); */
/*         var ind = 1; */
/*         $.each(item.secInfo, function(i, val){ */
/*             log(ind, val); */
/*             ind = ind + 1; */
/*         }); */
/*     } */

/*     $("#tags" ).autocomplete({ */
/*         source: function(request, response){ */
/*             $.ajax({ */
/*                 url: 'courses/', */
/*                 type: 'GET', */
/*                 success: function(data){ */
/*                     response($.map(data, function(item){ */
/*                         return { */
/*                             label: item.cdesc, */
/*                             value: item.cname, */
/*                             secInfo: item.sec_info */
/*                         } */
/*                     })); */
/*                 } */
/*             }); */
/*         }, */
/*         minLength: 0, */
/*         focus: function(event, ui){ */
/*             $("#tags").val(ui.item.value); */
/*             return false; */
/*         }, */
/*         select: function(event, ui){ */
/*             $("#tags").val(ui.item.label); */
/*             logTest(ui.item); */
/*             $("input[name='sections']").on("click", function(){ */
/*                     $("#times").empty(); */
/*                     var boxChecked = $('input:radio[name=sections]:checked').val(); */
/*                     $.each(ui.item.secInfo[boxChecked-1]["timesInfo"], function(i, val){ */
/*                         $("#times").append(val["day"] + " " + val["startTime"] + " " + val["endTime"] + " " + val["roomInfo"] + "<br/>"); */
/*                     }); */
/*             }); */
/*             return false; */
/*         } */
/*     }) */
/*     .autocomplete("instance")._renderItem = function(ul, item){ */
/*         return $("<li>") */
/*                 .append("<a>" + item.value + "</a>") */
/*                 .appendTo(ul); */
/*     }; */
/* }); */

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
$(document).ready(function(){
	//$('fc-day-header').val($('.fc-day-header').val().substr(0, 3));
	$('#calendar').fullCalendar({
		header: {
			left: '',
			center: '',
			right: ''
		},
		editable: false,
		eventLimit: true, // allow "more" link when too many events
		defaultView: 'agendaWeek',
		events: [
		]
	});

	var courseArray = [];
	$("button").click(function(){
		var cname = $("input[name=courseName]").val();
		var url = "http://localhost/searchCourse/" + cname;
		$.getJSON(url, function(json){

			$(".sections").empty();
			var today = new Date();
			
			$.each(json, function(i, val){
				var sname = '<input type="radio" name="secName" value="'+ val["id"] +'"/>  ' + val["sec_no"] + "<br/>"; 
				$(".sections").append(sname);
			});
			// $("input[name='secName']").on("click", function(){
			// 		$.post("")

			// });

			var secUrl = 'http://localhost/searchCourse/section/';
			var secID = -1;

			$("input[name=secName]").on("click", function(){
				
				var oldID = secID;
				secID = $('input:radio[name=secName]:checked').val();	

				$.getJSON(secUrl + secID, function(data){
					$.each(data, function(i, val){
						var newEvent = new Object();
						if(oldID != -1){
							$('#calendar').fullCalendar('removeEvents', oldID);
						}
						var tomorrow = new Date(today);
						tomorrow.setDate(today.getDate() - (getCorrespondingDay(val["day"])));
	
						newEvent.id = secID;
						newEvent.title = cname + val["day"];
						newEvent.start = tomorrow.toISOString().substr(0,10) + " " + val["startTime"];
						newEvent.end = tomorrow.toISOString().substr(0,10) + " " + val["endTime"];
						newEvent.allDay = false;
						$('#calendar').fullCalendar('renderEvent', newEvent);
					});

				});
			});
		}).fail(function(jqXHR, status, error){
			$(".sections").empty();
			$(".sections").append("<p>No such course found</p>");
		});

	});

});
</script>
@stop

@section('content')
<div id="row">
<div class="small-3 columns">
<input type="text" name="courseName" />
<button class="search">Search</button><br/>
<div class="sections">
</div>
</div>
<div class="small-9 columns">
		<div id="calendar">
		</div>
</div>
</div>
@stop

@section('tailScripts')
<script>
$(document).ready(function(){
});
</script>
@stop
