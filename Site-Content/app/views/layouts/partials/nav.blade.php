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
		<li>{{ link_to_route('schedule_path', 'Auto Schedule', null, ['class' => '']) }}</li> 
		<li>{{ link_to_route('schedule_manual_path', 'Manual Schedule', null, ['class' => '']) }}</li> 
		<li>{{ link_to_route('course_all_path', 'Classes', null, ['class' => '']) }}</li> 
		<li>{{ link_to_route('profile_path', 'Profile', null, ['class' => ''])
		}}</li>
		<li>{{ link_to_route('logout_path', 'Log Out', null, ['class' => '']) }}</li>
	</ul> 
</aside> <!-- Right-Side Menu End -->

