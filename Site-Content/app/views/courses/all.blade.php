@extends('layouts.default')

@section('content')
<div id="row">
	<div class="large-12 columns">
		@foreach($courses as $course)
			<div class="small-2 columns">{{ link_to_action('CourseController@index', $course->cname, array($course->cname), ['class' => '']) }}</div>
		@endforeach
	</div>
</div>
@stop
