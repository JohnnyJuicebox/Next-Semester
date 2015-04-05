<nav class="tab-bar">
	<div class="left"> 
		<a href="/" class="nav-link nav-logo">NextSemester</a>
	</div> 
	
	<div class="right-menu">
		@if ($currentUser)
			<a class="right-off-canvas-toggle" href="#"><h1 class="title">{{ $currentUser->username }}<span class="caret"></span></h1></a>
			
		@else
			{{ link_to_route('register_path', 'Sign Up', null, ['class' => 'nav-space login nav-link']) }}
			{{ link_to_route('login_path', 'Log In', null, ['class' => 'login nav-link']) }}
		@endif 
	</div>
	
</nav><!-- Nav Header End -->

<aside class="right-off-canvas-menu"> <!-- Right-Side Menu -->
	<ul class="off-canvas-list"> 
		<li><label>Sections</label></li> 
		<li>{{ link_to_route('schedule_path', 'Schedule Builder', null, ['class' => '']) }}</li> 
		<li><a href="#">Friends</a></li> 
		<li><a href="#">Classes</a></li> 
		<li><a href="#">Profile</a></li>
		<li><a href="#">Settings</a></li>
		<li>{{ link_to_route('logout_path', 'Log Out', null, ['class' => '']) }}</li>
	</ul> 
</aside> <!-- Right-Side Menu End -->

