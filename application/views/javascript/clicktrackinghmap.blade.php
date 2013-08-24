$(function () {

var hmap = {};
hmap.config = {};
// hmap.config.url_experiments = "experiments.json";
// hmap.config.url_experiment_subjects = "experiment_subjects.json";
hmap.config.url_experiments = "/admin/clicktracking/experiments";
hmap.config.url_experiment_subjects = "/admin/clicktracking/experimentsubjects";
hmap.config.url_experiment_results_base = "/admin/clicktracking";
//hmap.currentSelectors = {};
hmap.currentSelectors = [];

// Adds a heat map item to a specific element
hmap.decorateElement = function(tgt_el_selector, front_content, front_bgcolour, back_content, back_bgcolour) {
	
	// Get / cache target element
	var $tgt = $(tgt_el_selector);
	
	// Get dimensions
	var tgt_height = $tgt.outerHeight();
	var tgt_width = $tgt.outerWidth();
	
	// Get position
	var tgt_pos = $tgt.offset();
	
	// Create overlay display element
	var $display = $('<div class="heatmap_item" id="'+$tgt.id+'_heatmap'+'"></div>');
	$display.css({
		"position": "absolute",
		"top": tgt_pos.top,
		"left": tgt_pos.left,
		"min-width": tgt_width,
		"min-height": tgt_height,
		"z-index": "5000",
		"background": front_bgcolour
	});

	// Add front and back content
	$display.html('<div class="heatmap_item_front">'+front_content+'</div><div class="heatmap_item_back" style="display: none;">'+back_content+'</div>');
	
	// Add toggle event
	$display.toggle(
		function(){
			$(this).css({"background": back_bgcolour});
			$(".heatmap_item_front", $(this)).hide();
			$(".heatmap_item_back", $(this)).show();
		},
		function() {
			$(this).css({"background": front_bgcolour});
			$(".heatmap_item_back", $(this)).hide();
			$(".heatmap_item_front", $(this)).show();
	
	});
	
	// Put it in DOM
	$tgt.prepend($display);
	
	
};

// Hmap init
hmap.init = function() {

	// Render the toolbar first
	hmap.renderToolbar();
	
	// Set up toolbar wireing
	$("#hmap_new_experiment_button").toggle(
		function(){
			$(this).html("Close");
			$("#hmap_control_extended").show();
		},
		function() {
			$(this).html("New experiment...");
			$(".hmap_input_data").val("");
			$("#hmap_control_extended").hide();
		}
	);
	
	// Current experiment handler
	$("#hmap_current_experiment").bind("change", function() {
		//alert("Current experiment: "+$(this).val());
		$('#hmap_metric').trigger('change');
	});
	
	// Scope select handler
	$("#hmap_scope").bind("change", function() {
		//alert("Scope: "+$(this).val());
		$('#hmap_metric').trigger('change');
	});
	
	// Metric select handler
	$("#hmap_metric").bind("change", function() {
		var metric = $(this).val();
		var experiment_id = $("#hmap_current_experiment").val();
		var url = hmap.config.url_experiment_results_base+"/"+metric+"/"+experiment_id;
		
		// !!!!! Change URL!!!
		$.ajax({
			//url: metric+".json",
			url: url,
			type: "GET",
			success: function(data) {
				hmap.renderResults(metric, data, experiment_id);
			},
			error: function() {
				//alert("Could not get results from "+this.url);
			}
		});
		
		//alert("Metric: "+$(this).val());
	});
	
	// Cancel button handler
	$("#hmap_create_cancel").bind("click", function(e) {
		$("#hmap_new_experiment_button").trigger("click");
	});
	
	
	// Create button handler
	$("#hmap_create_button").bind("click", function(e) {
		
		var name = $("#hmap_name_input").val();
		var elements = $("#hmap_element_input").val();
		var page = $("#hmap_page_input").val();
		
		// Send this to server
		
	});
	
	// Load experiments
	hmap.loadExperiments();
	
	
};

// Load experiments
hmap.loadExperiments = function() {
	
	$.ajax({
		type: "GET",
		url: hmap.config.url_experiments,
		success: function(data) {
			
			// Populate current experiment dropdown
			var exp_html = "";
			for (var i=0, il=data.length; i<il; i++) {
				exp_html += '<option value="'+data[i]['id']+'">'+data[i]['name']+'</option>';
			}
			$("#hmap_current_experiment").html('<option>Please select an experiment...</option>' + exp_html);
			
			// Load experiment subjects for this experiment
			//hmap.loadExperimentSubjects($("#hmap_current_experiment").val());
			
		},
		error: function() {
			//alert("Could not GET "+hmap.config.url_experiments);
		}
	});
	
};

// Load experiment subjects
// hmap.loadExperimentSubjects = function(experiment_id) {
	
// 	$.ajax({
// 		type: "GET",
// 		url: hmap.config.url_experiment_subjects,
// 		success: function(data) {
			
// 			// Get all the subjects for the current experiment
// 			for (var i=0, il=data.length; i<il; i++) {
// 				if (data[i]['experiment_id'] === ''+experiment_id) {
// 					hmap.currentSelectors[data[i]['id']] = data[i]['selector'];
// 				}
// 			}
			
// 		},
// 		error: function() {
// 			alert("Could not GET "+hmap.config.url_experiment_subject);
// 		}
// 	});
	
// };

// render results
hmap.renderResults = function(metric, data, experiment_id) {

	$.ajax({
		type: "GET",
		url: hmap.config.url_experiment_subjects,
		success: function(getData) {
			hmap.currentSelectors = [];
			
			// Get all the subjects for the current experiment
			for (var i=0, il=getData.length; i<il; i++) {
				if (getData[i]['experiment_id'] === ''+experiment_id) {
					
					//hmap.currentSelectors[getData[i]['id']] = getData[i]['selector'];
					hmap.currentSelectors.push({
						'id': getData[i]['id'],
						'selector': getData[i]['selector']
					});

				}
			}

			function getRGB(num, min, max) {
				//alert(num + ' ' + min + ' ' + max);
				val = (200 * ((num - min) / (max - min))) + 50;
				return "rgb(" + Math.round(val) + ", " + 0 + ", " + Math.round(val) +")";
			}

			// Usage per session
			if (metric === "usage-per-session") {
				for (i in data)
				{
					for (x=0 ; x<hmap.currentSelectors.length ; x++)
					{
						if (hmap.currentSelectors[x]['id'] == data[i]['experiment_subject_id'])
						{
							hmap.decorateElement(
								hmap.currentSelectors[x]['selector'],
								data[i]['num_used_sessions'] === undefined ? 0 : data[i]['num_used_sessions'],
								getRGB(data[i]['num_used_sessions'] === undefined ? 0 : data[i]['num_used_sessions'], 0, 1),
								"Details",
								"#333"
							);
						}
					}
				}
			} else if (metric === "element-ranking") {
				for (i in data)
				{
					for (x=0 ; x<hmap.currentSelectors.length ; x++)
					{
						if (hmap.currentSelectors[x]['id'] == data[i]['experiment_subject_id'])
						{
							hmap.decorateElement(
								hmap.currentSelectors[x]['selector'],
								i,
								getRGB(i,0,8),
								"Details",
								"#00f"
							);
						}
					}
				}
			} else if (metric === "number-of-average-clicks") {
				for (i in data)
				{
					for (x=0 ; x<hmap.currentSelectors.length ; x++)
					{
						if (hmap.currentSelectors[x]['id'] == data[i]['experiment_subject_id'])
						{
							hmap.decorateElement(
								hmap.currentSelectors[x]['selector'],
								Math.round(data[i]['avg_clicks']),
								getRGB(data[i]['avg_clicks'], 0, 10),
								"Details",
								"#333"
							);
						}
					}
				}
			}
			
		},
		error: function() {
			//alert("Could not GET "+hmap.config.url_experiment_subject);
		}
	});

};


//Render Hmap toolbar
hmap.renderToolbar = function() {
	
	// CSS
	var toolbar_html = '<style>.heatmap_item {color: #fff; font-weight: bold; font-size: 1.2em; text-align: center; opacity: 0.95; }#hmap_control {background: #D6D1C5; padding: 5px 10px;}#hmap_new_experiment_button { font-weight: bold; padding: 10px 0; }#hmap_control_extended h4 { margin: 10px 0; border-bottom: 1px solid #B69510; }#hmap_control_extended label { display: inline-block; width: 80px; text-align: right; }#hmap_control_extended input { margin: 5px 0; }#hmap_control_extended .button { padding: 5px 10px; margin: 0 10px 0 0; background: #00f; color: #fff; font-weight: bold; }#hmap_control_extended .button_container { padding: 10px 0 10px 80px; }</style>';
	
	// Markup
	toolbar_html += '<!-- Heatmap control container --> <div id="hmap_control"><!-- Heatmap control default state --> <div id="hmap_control_default"> <label for="hmap_current_experiment">Current experiment</label> <select id="hmap_current_experiment" name="hmap_experiment"> <option>No experiments yet...</option> </select><label for="hmap_scope">Scope</label> <select id="hmap_scope" name="hmap_scope"> <option value="all">All stores</option> <option value="specific" disabled="true">Specific store</option> </select> <input type="text" id="hmap_store_id_input" style="display: none;" /><label for="hmap_metric">Metric</label> <select id="hmap_metric" name="hmap_metric"> <option value="usage-per-session">Usage per session</option> <option value="element-ranking">Element ranking</option> <option value="number-of-average-clicks">Number of average clicks</option> <option disabled="true" value="time-to-first-click">Time to first click</option> <option disabled="true" value="element_grouping">Element grouping</option> <option disabled="true" value="time_between_repeat">Time between repeat usage</option> <option disabled="true" value="usage_trend">Usage trend</option> </select> <br /> <a id="hmap_new_experiment_button" href="javascript:;">New experiment...</a></div><!-- Heatmap control extended state --> <div id="hmap_control_extended" style="display: none;"> <h4>Create new experiment</h4><ul> <li> <label for="hmap_name_input">Name</label> <input id="hmap_name_input" class="hmap_input_data" name="hmap_name_input" type="text" value="" placeholder=""/> </li><li> <label for="hmap_element_input">Elements</label> <input id="hmap_element_input" class="hmap_input_data" name="hmap_element_input" type="text" value="" placeholder="CSS selectors separated by comma"/> </li><li> <label for="hmap_page_input">Page</label> <select id="hmap_page_input" class="hmap_input_data"> <option value="">Select page...</option> <option value="editProduct">Edit product page</option> </select> </li><li class="button_container"> <button type="button" class="button" id="hmap_create_button">Create!</button> <a id="hmap_create_cancel" href="javascript:;">Cancel</a> </li> </ul> </div> </div>';
	
	
	$("body").prepend(toolbar_html);	
	
};

// Page init
$(document).ready(function() {

	hmap.init();

  	// hmap.decorateElement("#tab-images","5", "#f00", "Details", "#232323");
  	// hmap.decorateElement("#tab-google-product-search","2", "#0f0", "Details", "#232323");
});


});