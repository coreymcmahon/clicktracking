var Experiment = Backbone.Model.extend({
	url: '/experiments'
});

var Experimentsubject = Backbone.Model.extend({
	url: '/experimentsubjects'
});

var Experimentobservation = Backbone.Model.extend({
	url: '/Experimentobservations'
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
			experiment_id: $('experiment').val(),
			selector: $('#selector').val()
		});
		experiment.save();
	});
	$('#get-experimentsubject').on('click', function () {
		window.location = '/experimentsubjects'
	});
});