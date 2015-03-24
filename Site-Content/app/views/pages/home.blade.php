@extends('layouts.default')

@section('content') 
<div class="panel radius home-panel"> 
	<h3><strong>Welcome To NextSemester!</strong></h3>
	<br>
	<h4>Our goal with NextSemester is to incorporate an intuitive schedule building app with a social network of fellow classmates.  The idea is to make it easier to create your course schedule in collaboration with friends as well as meet people who are taking classes with you.</h4>
	<br>
	<h4>NextSemester is a tool for pooling resources (youtube videos, helpful websites, and class content) and forming study groups/cram sessions.  Students can set up meet times at the library or alert the rest of the class that you want to work on a specific problem or homework assignment.</h4>
	<br>
	<h4>To get started please sign in or register for a new account.</h4>

	@if ( ! $currentUser)
		{{ link_to_route('register_path', 'Sign Up', null, ['class' => 'button radius']) }}
	@endif
</div>

@stop
