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
		experiment.save({}, {
			success: function () {
				toastr.info('Experiment added.');
			}
		});
	});
	$('#get-experiment').on('click', function () {
		window.location = '/experiments';
	});

	/**/
	$('#post-experimentsubject').on('click', function () {
		var experimentsubject = new Experimentsubject({
			experiment_id: $('#experiment').val(),
			selector: $('#selector').val()
		});
		experimentsubject.save({}, {
			success: function () {
				toastr.info('Experiment subject added.');
			}
		});
	});
	$('#get-experimentsubject').on('click', function () {
		window.location = '/experimentsubjects';
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
		experimentobservation.save({}, {
			success: function () {
				toastr.info('Experiment observation added.');
			}
		});
	});
	$('#get-experimentobservation').on('click', function () {
		window.location = '/experimentobservations';
	});


	$.each(['usage-per-session-experiment', 'element-ranking-experiment', 'time-to-first-click-experiment', 'number-of-average-clicks-experiment'], function (i, e) {
		$('#' + e + "-button").on('click', getApiRedirectFunction(e.replace('-experiment',''), e));
	});

	$.each(['usage-per-session-store-experiment', 'element-ranking-store-experiment', 'time-to-first-click-store-experiment', 'number-of-average-clicks-store-experiment'], function (i,e) {
		$('#' + e + "-button").on('click', getApiRedirectFunction(e.replace('-store-experiment',''), e.replace('-store', ''), e.replace('-experiment','') + "-store-id"));
	});

});

var getApiRedirectFunction = function (path, experimentIdElementId, storeIdElementId) {
	return function () {
		var storePath = '';
		if (storeIdElementId !== undefined)
		{
			storePath = '/store/' + $('#' + storeIdElementId).val();
		}
		window.open('results/' + path + '/' + $('#' + experimentIdElementId).val() + storePath, '_blank');
	};
};

