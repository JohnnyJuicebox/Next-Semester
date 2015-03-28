@extends('layouts.default')

@section('content')
	<h1>Schedule Builder</h1>
	<div class="row">
		<div class="large-9 large-centered columns">
			{{ $calendar->calendar() }}
    		{{ $calendar->script() }}
		</div>
	</div>

@stop