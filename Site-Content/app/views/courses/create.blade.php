@extends('layouts.default')

@section('content')
<div id="row">
	<div class="large-12 columns">
		<div id="contentHeader">
			<h2 class="subheader">{{ $courseInfo->cname }} </h2>
			<p>{{ $courseInfo->cdesc }}</p>
		</div>
		<div id="contentInfo">
			<p> {{ $courseInfo->cinfo }} </p>
		</div>
	</div>
</div>
@stop
