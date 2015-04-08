@extends('layouts.default')

@section('content')
<div id="row">
	<div class="large-12 columns">
		@foreach($courses as $course)
			<div class="small-2 columns">{{ link_to('http://localhost/course/'. $course->cname, $course->cname, null, ['class' => '']) }}</div>
		@endforeach
	</div>
</div>
@stop
