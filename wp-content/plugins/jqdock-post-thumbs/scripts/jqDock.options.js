jQuery(document).ready(function($) {

	$(document).ready(function($){
		// set up the options to be used for jqDock...
		var dockOptions = {
			align: 'bottom', // horizontal menu, with expansion UP/DOWN from the middle
			size: 155,  // set the maximum minor axis (horizontal) image dimension to 50px
			labels: 'bc'  // add labels (override the 'tl' default)
		};
		// ...and apply...
		$('.jqd_menu').jqDock(dockOptions);
	});

});