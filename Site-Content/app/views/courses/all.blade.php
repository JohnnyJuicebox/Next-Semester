@extends('layouts.default')

@section('content')


<div class="row">
	<div class="small-12 columns">
		<div class="small-12 columns">
			<h2>Courses</h2>
			<p>Select specific courses and click the hyperlink to their info pages.</p>
		</div>
		<div class="small-5 columns">
			<input type="text" placeholder="Search for Classes ex. CS491 and press Enter"/>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<ul id="list" style="list-style-type:none">
					@foreach($courses as $course)
						<li class="small-2 columns">{{ link_to_action('CourseController@index',
							$course->cname, array($course->cname), ['class' => '']) }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
@stop

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
$(function(){
	$("input").keypress(function(event) {
    if (event.which == 13) {
        event.preventDefault();
        var searchText = $(this).val().toUpperCase();;
        
	$('ul > li').each(function(){

		var currentLiText = $(this).text(),
		showCurrentLi = currentLiText.indexOf(searchText) !== -1;

		$(this).toggle(showCurrentLi);

		});  
    }
	});
});
</script>