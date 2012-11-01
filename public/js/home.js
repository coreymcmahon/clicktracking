var Experiment = Backbone.Model.extend({
	url: '/experiments'
});

var Experimentsubject = Backbone.Model.extend({
	url: '/experimentsubjects'
});

var Experimentobservation = Backbone.Model.extend({
	url: '/experimentobservations'
});

$(function () {
	$('#post-experiment').on('click', function () {
		var experiment = new Experiment({
			name: $('#name').val(),
			url: $('#url').val()
		});
		experiment.save();
	});
	$('#get-experiment').on('click', function () {
		window.location = '/experiments'
	});

	/**/
	$('#post-experimentsubject').on('click', function () {
		var experimentsubject = new Experimentsubject({
			experiment_id: $('#experiment').val(),
			selector: $('#selector').val()
		});
		experimentsubject.save();
	});
	$('#get-experimentsubject').on('click', function () {
		window.location = '/experimentsubjects'
	});

	/**/
	$('#post-experimentobservation').on('click', function () {
		var experimentobservation = new Experimentobservation({
			experiment_id: $('#experiement-observation-experiment-id').val(),
			experiment_subject_id: $('#experiement-observation-experiment-subject-id').val(),
			clicks: $('#experiement-observation-clicks').val(),
			store_id: $('#experiement-observation-store-id').val(),
			username: $('#experiement-observation-username').val(),
			session: $('#experiement-observation-session').val(),
			session_start: $('#experiement-observation-session-start').val(),
			session_updated_at: $('#experiement-observation-session-updated-at').val()
		});
		experimentobservation.save();
	});
	$('#get-experimentobservation').on('click', function () {
		window.location = '/experimentobservations'
	});
});


