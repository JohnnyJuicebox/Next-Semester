<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NextSemester | Welcome</title>
    <!-- CSS and JS asset calls -->
    {{ HTML::style('css/foundation.css'); }}
    {{ HTML::style('css/main.css'); }}
    {{ HTML::style('css/fullcalendar.css'); }}
    {{ HTML::script('js/moment.min.js'); }}
    {{ HTML::script('js/jquery.min.js'); }}
    {{ HTML::script('js/fullcalendar.min.js'); }}
    {{ HTML::script('js/vendor/modernizr.js'); }} 
  </head>
  <body>
  	<div class="page">
		<div class="off-canvas-wrap" data-offcanvas>
			<div class="inner-wrap"> 
				
				@include('layouts.partials.nav') <!-- Top Nav Bar and Side Menu -->

				<section class="main-section"> <!-- Main Content -->
					<div class="row">
						<div class="small-12 columns">
              @include('flash::message')

							@yield('content')
						</div>
					</div>
				</section> <!-- End Main Content -->

				<a class="exit-off-canvas"></a> 
			</div> <!-- End Inner Wrapper -->
		</div> <!-- End Main Canvas -->
	</div>
    <!-- {{ HTML::script('js/vendor/jquery.js'); }} -->
    {{ HTML::script('js/foundation/foundation.js'); }}
    {{ HTML::script('js/foundation/foundation.offcanvas.js'); }}
    {{ HTML::script('js/foundation/foundation.alert.js'); }}
    
    <script>
      $(document).foundation();
    </script>
  </body>
</html>