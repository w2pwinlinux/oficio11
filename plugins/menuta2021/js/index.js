// Remember - there are THREE external javascript files included in this demo. If you don't use them, you'll get an error on the console.

// Set a resize timer for efficiency
var delay = (function(){
	var timer = 0;
	return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	};
})();

jQuery(function($){ //create closure so we can safely use $ as alias for jQuery

	$('ul.sf-menu').supersubs({ // Initialize Superfish Menu
		minWidth:	12,	 // minimum width of submenus in em units
		maxWidth:	27,	 // maximum width of submenus in em units
		extraWidth:	1	 // extra width can ensure lines don't sometimes turn over
	}).superfish();

	$('#hamburger').click(function () { // Capture responsive menu button click
    	// Show/hide menu
    	$('.sf-menu').toggle();
    });
	
  // Check if our window has been resized
  $(window).resize(function() {
    // set a timeout using the delay function so this doesn't fire evey millesecond
    delay(function(){
      // If we're not in responsive mode
      if( $(document).width() > 768 ) {
        // Always show the main menu, in case it was toggled off.
        $('.sf-menu').css('display', 'block');
    }
}, 500);
});
});