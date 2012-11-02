$(function () {
	
	window.clicktracking = window.clicktracking || [];

	window.forceClicktracking = function () {
		$.ajax({
			type: 'POST',
			url: '/admin/clicktracking/experimentobservations',
			data: JSON.stringify(window.clicktracking),
			contentType: 'application/json',
			dataType: 'json',
			async: false,
			processData: false
		});
	};

	// load the experiment data...
	var experiments = {{ json_encode($experiments) }};
	var experimentsubjects = {{ json_encode($experimentsubjects) }};
	var currentExperiments = [];
	var currentExperimentIds = [];
	var currentExperimentSubjects = [];
	// @TODO: add url as a parameter so we can provide only the relevant experiment data above

	var session = '{{ Input::get('session') }}';
	var sessionStart = '{{ Input::get('start') }}';
	var username = '{{ Input::get('username') }}';
	var storeId = '{{ Input::get('storeId') }}';

	// take an absolute URL and make it usable...
	var path = '/' + (window.location.href
				.split('//')[1]
				.split('/')
				.splice(1)
				.join('/'));
	path = path.split('#')[0];
	path = path.split('&')[0];

	// @TODO: decide if this is required or not:


	$.each(experiments, function (index, element) {
		if (element.url == path) 
		{
			currentExperiments.push(element);
			currentExperimentIds.push(element.id);
		}
	});
	$.each(experimentsubjects, function (index, element) {
		if (_.contains(currentExperimentIds, element.experiment_id))
		{
			currentExperimentSubjects.push(element);
		}
	});

	if (currentExperiments.length > 0) {
		// initialise window.clicktracking
		for (i = 0 ; i<currentExperiments.length ; i++) {
			window.clicktracking.push({
				experiment_id: currentExperiments[i]['id'],
				experiment_subject_id: 0,
				clicks: 0,
				store_id: storeId,
				username: username,
				session: session,
				session_start: sessionStart, // @TODO: work out the time values here
				session_updated_at: ''
			});
		}

		// set up handlers
		for (i=0 ; i<currentExperimentSubjects.length ; i++)
		{
			window.clicktracking.push({
				experiment_id: currentExperimentSubjects[i]['experiment_id'],
				experiment_subject_id: currentExperimentSubjects[i]['id'],
				clicks: 0,
				store_id: storeId,
				username: username,
				session: session,
				session_start: sessionStart, // @TODO: work out the time values here
				session_updated_at: ''
			});

			$(currentExperimentSubjects[i]['selector']).on('click', function (selector, experimentId, experimentSubjectId) {

				return function (event) {
					
					console.log('tracking click for ' + selector);
					$.each(window.clicktracking, function (index, element) {

						if (element.experiment_id == experimentId 
							  && element.experiment_subject_id == experimentSubjectId) 
						{
							element.clicks += 1;
						}

					});

				};

			} (currentExperimentSubjects[i]['selector'], currentExperimentSubjects[i]['experiment_id'], currentExperimentSubjects[i]['id']) );
		}

		$(document).on('click', function () {
			console.log('tracking click for entire page');
			$.each(window.clicktracking, function (index, element) {
				if (element.experiment_subject_id === 0) {
					element.clicks += 1;
				}
			});
		});

		$(window).unload(window.forceClicktracking);
	}
});

