<nav class="tab-bar">
	<section class="left tab-bar-section"> 
		<a href="/"><h1 class="title">NextSemester</h1></a>
	</section> 
	
	<section class="right-menu">
		@if ($currentUser)
			<a class="right-off-canvas-toggle" href="#"><h1 class="title">{{ $currentUser->username }}</h1><span class="caret"></span></a>
			
		@else
			{{ link_to_route('register_path', 'Sign Up', null, ['class' => 'login button radius']) }}
			{{ link_to_route('login_path', 'Log In', null, ['class' => 'login button radius']) }}
		@endif 
	</section>
	
</nav><!-- Nav Header End -->

<aside class="right-off-canvas-menu"> <!-- Right-Side Menu -->
	<ul class="off-canvas-list"> 
		<li><label>Sections</label></li> 
		<li><a href="#">Schedule Builder</a></li> 
		<li><a href="#">Friends</a></li> 
		<li><a href="#">Classes</a></li> 
		<li><a href="#">Profile</a></li>
		<li><a href="#">Settings</a></li>
		<li>{{ link_to_route('logout_path', 'Log Out', null, ['class' => '']) }}</li>
	</ul> 
</aside> <!-- Right-Side Menu End -->

