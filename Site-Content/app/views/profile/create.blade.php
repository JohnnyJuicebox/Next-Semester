@extends('layouts.default')

@section('content') 
<div class="panel radius home-panel"> 
	<h1>Profile</h1>

	<div class="row">
		<div class="large-6 large-offset-2 columns">
			Username: {{ $userInfo->username }} <br/>
			First Name: {{ $userInfo->fname}} <br/>
			Last Name: {{ $userInfo->lname }} <br/>
			Email: {{ $userInfo->email }} <br/>
			Major: {{ $userInfo->major }} <br/>
		</div>
	</div>
</div>

@stop