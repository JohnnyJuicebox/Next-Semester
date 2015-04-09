@extends('layouts.course_default')

@section('headScripts')
<script>
$(document).ready(function(){
	var h = $('input:hidden').val();
	//alert(h);
});
</script>
@stop

@section('content')
<div id="row">
	<div class="large-12 columns">
		<div id="contentHeader">
			<h2 class="subheader">{{ $courseInfo->cname }} </h2>
			{{ Form::hidden('val', $courseInfo->id) }}
			<p>{{ $courseInfo->cdesc }}</p>
		</div>
		<div id="contentInfo">
			<p> {{ $courseInfo->cinfo }} </p>
		</div>
		<div class="contentForm">
			<div class="userContent">
			</div>
			<a id="submit" class="button postfix">Submit</a>
		</div>

	</div>
</div>
@stop

@section('tailScripts')
<script>

</script>
@stop
