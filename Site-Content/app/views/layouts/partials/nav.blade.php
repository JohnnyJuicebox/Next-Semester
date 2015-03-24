<nav class="tab-bar">
	<section class="left tab-bar-section"> 
		<a href="/"><h1 class="title">NextSemester</h1></a>
	</section> 
	
	<section class="right-menu">
		@if ($currentUser)
			<a class="right-off-canvas-toggle" href="#"><h1 class="title">{{ $currentUser->username }}</h1></a>
			<span class="caret"></span>
		@else
			<a href="#" class="login button radius">Log In</a>
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
	</ul> 
</aside> <!-- Right-Side Menu End -->

