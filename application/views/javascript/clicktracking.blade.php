$(function () {
	
	window.clicktracking = window.clicktracking || {};

	// load the experiment data...
	var experiments = {{ json_encode($experiments) }};
	var experimentsubjects = {{ json_encode($experimentsubjects) }};
	var session = '{{ Input::get('session') }}';
	var username = '{{ Input::get('username') }}';
	var storeId = '{{ Input::get('storeId') }}';
	var currentExperiments = [];

	// take an absolute URL and make it usable...
	var path = '/' + (window.location.href
				.split('//')[1]
				.split('/')
				.splice(1)
				.join('/'));
	path = path.split('#')[0];

	$.each(experiments, function (element) {
		if (element.url == path) 
		{
			currentExperiments.push(element);
		}
	});

	if (currentExperiments.length > 0) {
		// initialise window.clicktracking
		// set up handlers
	}

	//{{ URL::to_action('experimentobservations') }}
});