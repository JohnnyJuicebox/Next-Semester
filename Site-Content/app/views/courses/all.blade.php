@extends('layouts.default')

@section('content')


<div id="row">
			<input type="text" placeholder="Search for Classes ex. CS491"/>
			<ul id="list" style="list-style-type:none">
				@foreach($courses as $course)
					<li class="small-2 columns">{{ link_to_action('CourseController@index',
						$course->cname, array($course->cname), ['class' => '']) }}</li>
				@endforeach
			</ul>
</div>
@stop

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
$(function(){

    $('input[type="text"]').keyup(function(){
        
        var searchText = $(this).val();
        
        $('ul > li').each(function(){
            
            var currentLiText = $(this).text(),
                showCurrentLi = currentLiText.indexOf(searchText) !== -1;
            
            $(this).toggle(showCurrentLi);
            
        });     
    });

});
</script>