@extends('layouts.default')

@section('content') 
<div class="panel radius home-panel"> 
	<h1>Registration</h1>

	<div class="row">
		<div class="large-6 large-offset-2 columns">

			@include('layouts.partials.errors')


			{{ Form::open(['route' => 'register_path']) }}

				<!-- Username Input -->
				<div class="form-group">
					{{ Form::label('username', 'Username:') }}
					{{ Form::text('username', null, ['class' => 'form-control']) }}
				</div>

				<!-- Email Input -->
				<div class="form-group">
					{{ Form::label('email', 'Email:') }}
					{{ Form::text('email', null, ['class' => 'form-control']) }}
				</div>

				<!-- Password Input -->
				<div class="form-group">
					{{ Form::label('password', 'Password:') }}
					{{ Form::password('password', null, ['class' => 'form-control']) }}
				</div>

				<!-- Password Confirmation -->
				<div class="form-group">
					{{ Form::label('password_confirmation', 'Password Confirmation:') }}
					{{ Form::password('password_confirmation', null, ['class' => 'form-control']) }}
				</div>

				<!-- Submit -->
				<div class="form-group">
					{{ Form::submit('Sign Up', ['class' => 'button radius']) }}
				</div>

			{{ Form::close() }}
		</div>
	</div>
</div>

@stop