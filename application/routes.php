<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

Route::get('/', function()
{
	Asset::add('home', 'js/home.js');
	return View::make('home.index', array(
		'experiments' => Experiment::all(),
		'experimentsubjects' => Experimentsubject::all(),
		'storeIds' => Experimentobservation::get_store_ids(),
	));
});

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

Route::get('experiments/(:num)', 'experiments@experiment');
Route::controller('Experiments');
Route::controller('Experimentsubjects');
Route::controller('Experimentobservations');

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

Route::get('/clicktracking.js', function () {
	$view = View::make('javascript.clicktracking', array(
		'experiments' => Experiment::allAsArray(),
		'experimentsubjects' => Experimentsubject::allAsArray(),
	));

	return new Response($view->render(), 200, array(
		'Access-Control-Allow-Origin' => Request::header('Origin', '*'),
		'Content-type' => 'text/javascript; charset=utf-8',
	));
});

Route::get('/clicktracking.hmap.js', function () {
	$view = View::make('javascript.clicktrackinghmap');

	return new Response($view->render(), 200, array(
		'Access-Control-Allow-Origin' => Request::header('Origin', '*'),
		'Content-type' => 'text/javascript; charset=utf-8',
	));
});

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

Route::get('results/usage-per-session/(:num)', function ($id) {
	$results = Experimentobservation::usage_per_session($id);
	return Response::json($results);
});
Route::get('results/usage-per-session/(:num)/store/(:num)', function ($id, $storeId) {
	$results = Experimentobservation::usage_per_session($id, $storeId);
	return Response::json($results);
});

/* * * * * * * * * * * * * * * */

Route::get('results/element-ranking/(:num)', function ($id) {
	$results = Experimentobservation::element_ranking($id);
	return Response::json($results);
});
Route::get('results/element-ranking/(:num)/store/(:num)', function ($id, $storeId) {
	$results = Experimentobservation::element_ranking($id, $storeId);
	return Response::json($results);
});

/* * * * * * * * * * * * * * * */

Route::get('results/time-to-first-click/(:num)', function ($id) {
	$results = Experimentobservation::time_to_first_click($id);
	return Response::json($results);
});
Route::get('results/time-to-first-click/(:num)/store/(:num)', function ($id, $storeId) {
	$results = Experimentobservation::time_to_first_click($id, $storeId);
	return Response::json($results);
});

/* * * * * * * * * * * * * * * */

Route::get('results/number-of-average-clicks/(:num)', function ($id) {
	$results = Experimentobservation::number_of_average_clicks($id);
	return Response::json($results);
});
Route::get('results/number-of-average-clicks/(:num)/store/(:num)', function ($id, $storeId) {
	$results = Experimentobservation::number_of_average_clicks($id, $storeId);
	return Response::json($results);
});

/* * * * * * * * * * * * * * * */

Route::get('results/(:any)', function () {
	return Response::error('404');
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// include jquery
	Asset::add('jquery','js/jquery-1.8.2.min.js');
	
	// include backbone
	Asset::add('underscore','js/underscore-min.js');
	Asset::add('backbone','js/backbone-min.js');

	// include toastr
	Asset::add('toastrcss','css/toastr.css');
	Asset::add('toastrcssresponsive','css/toastr-responsive.css');
	Asset::add('toastrjs','js/toastr.js');
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});