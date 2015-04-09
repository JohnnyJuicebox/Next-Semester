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

$(document).ready(function(){
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
		events: 'userautoschedule', 
		eventRender: function(event, element) { 
            element.find('.fc-title').append("<br/>" + event.description);
        }
	});
	$("#add").click(function(){
		var cname = $("input[name=courseName]").val();
		var url = "searchCourse/" + cname;
		$(".sections").append('<div id="' + cname + '"></div>');

		$.getJSON(url, function(json){
			if(json.length != 0){
				$('.sections').append('<input type="checkbox" name="clist" value=' + cname + ' checked/>' + cname + '<br/>');
			}
		}).fail(function(jqXHR, status, error){
			$(".sections").empty();
			$(".sections").append("<p>No such course found</p>");
		});
	});

	var selected = [];
	$("#generate").click(function(){

		var checkValues = $('input[name=clist]:checked').map(function(){
            return $(this).val();
        }).get();

        var schedOption = $('input:radio[name=scheduleOption]:checked').val();

        $.ajax({
            url: 'generate',
            type: 'get',
            data: { cnames: checkValues, sOption: schedOption },
            success:function(data){
            	$('#calendar').fullCalendar('refetchEvents');
            	events = $('#calendar').fullCalendar('clientEvents');
            }
        });
	});
	$('.fc-toolbar').remove();

});
</script>
@stop

@section('content')
<div id="row">
	<h3 align="center" style="padding-bottom: 5px;">AutoSchedule Calendar</h3>
	<div class="large-3 columns">
		<div style="border: 2px solid black; padding: 10px;">
			<h5>Course Selection:</h5>
			<input type="text" name="courseName" />
			<a id="add" class="button postfix">Add</a><br/>
			<div class="sections panel radius">
				<h5>Courses:</h5>
			</div>
			<div id="options" class="panel radius">
				<input type="radio" name="scheduleOption" value="1" />Best Professor<br/>
				<input type="radio" name="scheduleOption" value="2" />Best Timing<br/>
			</div>
			<a id="generate" class="button postfix">Submit</a>
		</div>
	</div>
	<div class="large-9 columns">
		<div id="calendar">
		</div>
		<div id="online">
		</div>
	</div>
</div>
@stop

@section('tailScripts')
@stop
