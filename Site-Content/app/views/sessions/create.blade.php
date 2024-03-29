@extends('layouts.default')

@section('content')
	<h1>Sign In</h1>

	{{ Form::open(['route' => 'login_path']) }}
		<!-- Email Form Input -->
		<div class="form-group">
			{{ Form::label('email', 'Email:') }}
			{{ Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) }}
		</div>

		<!-- Password Form Input -->
		<div class="form-group">
			{{ Form::label('password', 'Password:') }}
			{{ Form::password('password', null, ['class' => 'form-control', 'required' => 'required']) }}
		</div>

		<!-- Sign In Input -->
		 <div class="form-group">
			{{ Form::submit('Sign In', ['class' => 'button']) }}
		</div>
	{{ Form::close() }}
@stop