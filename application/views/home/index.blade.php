<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Laravel: A Framework For Web Artisans</title>
	<meta name="viewport" content="width=device-width">
	{{ HTML::style('laravel/css/style.css') }}
	{{ Asset::scripts() }}
</head>
<body>
	<div class="wrapper">
		<header>
			<h1>Clicktracking control panel</h1>
			<h2>Do all the things</h2>

			<p class="intro-text" style="margin-top: 45px;">
			</p>
		</header>
		<div role="main" class="main">
			<div class="home">
				<h2>Experiments</h2>
				<div>
					<pre>POST /experiments</pre>
				</div>
				<div>
					<label for="name">Name: </label> <input type="text" name="name" id="name">
					<label for="url">URL: </label> <input type="text" name="url" id="url">
					<button id="post-experiment">POST</button>
				</div>
				<div>
					<pre>GET /experiments</pre>
				</div>
				<div>
					<button id="get-experiment">GET</button>
				</div>
				<hr/>
				<h2>Experiment Subjects</h2>
				<div>
					<pre>POST /experimentsubjects</pre>
				</div>
				<div>
					<label for="experiment">Experiment: </label>
					<select id="experiment">
						@foreach ($experiments as $experiment)
						<option value="{{ $experiment->id }}">{{ $experiment->name }}</option>
						@endforeach
					</select>

					<label for="CSS Selector">: </label> <input type="text" name="selector" id="selector">

					<button id="post-experimentsubject">POST</button>
				</div>
				<div>
					<pre>GET /experimentsubjects</pre>
				</div>
				<div>
					<button id="get-experimentsubjects">GET</button>
				</div>
				<hr/>
				<h2>Experiment Observations</h2>
				<div>
					<pre>POST /experimentobvservations</pre>
				</div>
				<div>
					
					<button id="post-experimentobservations">POST</button>
				</div>
				<div>
					<pre>GET /experimentobservations</pre>
				</div>
				<div>
					<button id="get-experimentobservations">GET</button>
				</div>
				<!-- <h2>Learn the terrain.</h2>

				<p>
					You've landed yourself on our default home page. The route that
					is generating this page lives at:
				</p>

				<pre>{{ path('app') }}routes.php</pre>

				<p>And the view sitting before you can be found at:</p>

				<pre>{{ path('app') }}views/home/index.blade.php</pre>

				<h2>Grow in knowledge.</h2>

				<p>
					Learning to use Laravel is amazingly simple thanks to
					its {{ HTML::link('docs', 'wonderful documentation') }}.
				</p>

				<h2>Create something beautiful.</h2>

				<p>
					Now that you're up and running, it's time to start creating!
					Here are some links to help you get started:
				</p>

				<ul class="out-links">
					<li><a href="http://laravel.com">Official Website</a></li>
					<li><a href="http://forums.laravel.com">Laravel Forums</a></li>
					<li><a href="http://github.com/laravel/laravel">GitHub Repository</a></li>
				</ul>
			</div> -->
		</div>
	</div>
</body>
</html>
