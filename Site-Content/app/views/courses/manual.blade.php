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

$(document).ready(function(){
	

	$('#save').click(function(){
		
		var checkValues = $('input:radio[name$=secName]:checked').map(function(){
	    	return $(this).val();
	    }).get();

		$.ajax({
	        url: 'generate',
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
					//if(oldID != -1){
					//	$('#calendar').fullCalendar('removeEvents', oldID);
					//}
				
					$.getJSON(secUrl + secID, function(data){
						$.each(data, function(i, val){
							
							var newEvent = new Object();
							var tomorrow = new Date(today);
							
							tomorrow.setDate((today.getDate())+ (getCorrespondingDay(val["day"])-today.getDay()));
							
							newEvent.id = secID;
							var rating = Math.round(val["rating"]*100)/100;
							newEvent.title = cname + val["day"];
							newEvent.url = 'course/' + cname;
							if(rating != -1){
								newEvent.title = newEvent.title + " " + rating;
							}
							newEvent.start = dateString(tomorrow) + " " + val["startTime"];
							newEvent.end = dateString(tomorrow) + " " + val["endTime"];
							
							newEvent.description = val["fname"] + " " + val["lname"] + "<br/>" + val["roomInfo"];
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
	//function(){
			
			// var checkValues = $('input:radio[name$=secName]:checked').map(function(){
	  //           return $(this).val();
	  //       }).get();
			// //});
		
	  //       // $.ajax({
	  //       //     url: 'generate',
	  //       //     type: 'get',
	  //       //     data: { cnames: checkValues },
	  //       //     success:function(data){
	  //       //     	alert('success');
	  //       //     	$('#calendar').fullCalendar({events: 'generate'});
					
	  //       //     }
	  //       // });
	  // //       var uniqueNames = [];
	  // //       var notFound = -1;
	  // //       alert('here');
			// // $.each(checkValues, function(i, val){
			// // 	if($.inArray(val, uniqueNames) == notFound){
			// // 		uniqueNames.push(val);
			// // 	}
	  // //       	//alert(val);
	  // //       });

	  //       $.each(checkValues, function(i, val){
	  //       	alert(val);
	  //       });
	//	});
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
		<a id="save" class="button postfix">Save Changes</a>
	</div>
	<div class="large-9 columns">
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
