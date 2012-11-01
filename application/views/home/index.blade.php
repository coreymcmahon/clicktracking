<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Laravel: A Framework For Web Artisans</title>
	<meta name="viewport" content="width=device-width">
	{{ HTML::style('laravel/css/style.css') }}
	{{ Asset::scripts() }}
	<style>
	.experiment-observation-table .footer-row { text-align: right; }
	</style>
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
					<button id="get-experimentsubject">GET</button>
				</div>
				<hr/>
				<h2>Experiment Observations</h2>
				<div>
					<pre>POST /experimentobvservations</pre>
				</div>
				<div>
					<table class="experiment-observation-table">
						<tr>
							<td><label for="experiement-observation-experiment-id">Experiment: </label> </td>
							<td><select id="experiement-observation-experiment-id">
								@foreach ($experiments as $experiment)
								<option value="{{ $experiment->id }}">{{ $experiment->name }}</option>
								@endforeach
							</select></td>

							<td><label for="experiement-observation-experiment-subject-id">Subject: </label> </td>
							<td><select id="experiement-observation-experiment-subject-id">
								@foreach ($experimentsubjects as $experimentsubject)
								<option value="{{ $experimentsubject->id }}">{{ $experimentsubject->selector }}</option>
								@endforeach
							</select></td>
						</tr>
						<tr>
							<td class="labels"><label for="experiement-observation-clicks">Clicks: </label></td>
							<td class="inputs"><input type="text" name="experiement-observation-clicks" id="experiement-observation-clicks" value="0"></td>
						</tr>
						<tr>
							<td class="labels"><label for="experiement-observation-store-id">Store ID: </label></td>
							<td class="inputs"><input type="text" name="experiement-observation-store-id" id="experiement-observation-store-id" value="72142"></td>
						</tr>
						<tr>
							<td class="labels"><label for="experiement-observation-username">Username: </label></td>
							<td class="inputs"><input type="text" name="experiement-observation-username" id="experiement-observation-username" value="admin"></td>
						</tr>
						<tr>
							<td class="labels"><label for="experiement-observation-session">Session: </label></td>
							<td class="inputs"><input type="text" name="experiement-observation-session" id="experiement-observation-session" value="{{ uniqid() }}"></td>
						</tr>
						<tr>
							<td class="labels"><label for="experiement-observation-session-start">Session start: </label></td>
							<td class="inputs"><input type="text" name="experiement-observation-session-start" id="experiement-observation-session-start" value="{{ date('Y-m-d H:i:s') }}"></td>
						</tr>
						<tr>
							<td class="labels"><label for="experiement-observation-session-updated-at">Session last-updated: </label></td>
							<td class="inputs"><input type="text" name="experiement-observation-session-updated-at" id="experiement-observation-session-updated-at" value="{{ date('Y-m-d H:i:s') }}"></td>
						</tr>
						<tr class="footer-row">
							<td colspan="2"><button id="post-experimentobservation">POST</button></td>
					</table>
				</div>
				<div>
					<pre>GET /experimentobservations</pre>
				</div>
				<div>
					<button id="get-experimentobservation">GET</button>
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
