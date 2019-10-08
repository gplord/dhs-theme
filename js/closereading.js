jQuery(document).ready(function(){

    // Option for smooth scrolling
    var smoothscroll = true;
    jQuery('#smoothscroll').change(function () {
        smoothscroll = jQuery('#smoothscroll').is(':checked');
	});
	
	// Option for dark mode
	var darkmode = false;
	jQuery('#darkmode').change(function () {
		darkmode = jQuery('#darkmode').is(':checked');
		if (darkmode) {
			jQuery('.closereading-fullscreen-content').addClass("closereading-dark");
		} else {
			jQuery('.closereading-fullscreen-content').removeClass("closereading-dark");
		}
	});

	var fullscreenMode = false;
    jQuery('#fullscreen').change(function () {
        fullscreenMode = jQuery('#fullscreen').is(':checked');
		toggleFullScreen();
    });

    var leftactive = false;
    var rightactive = false;
	
	var leftHighlightedItem;
	var rightHighlightedItem;
	var leftActiveItem;
	var rightActiveItem;

    jQuery('#left-scrollspy').hover(function(){
        leftactive = true;
        rightactive = false;
    });
    jQuery('#right-scrollspy').hover(function(){
        leftactive = false;
        rightactive = true;
    });

	if (jQuery("#left-scrollspy").length) {

		resizeSplitscreenViewer();

		jQuery(window).resize(function() {
			resizeSplitscreenViewer();
		});

		jQuery('[data-toggle="tooltip"]').tooltip({
            placement: 'bottom'
        });

	}

	function resizeSplitscreenViewer() {	
		var docHeight = jQuery(window).height();
		var viewerTop = jQuery("#closereading-viewer").offset().top;
		var footerHeight = jQuery('.closereading-footer').outerHeight();
		//jQuery("#left-scrollspy").height(docHeight - viewerTop - footerHeight - 10);
		jQuery("#closereading-lefttext").height(docHeight - viewerTop - footerHeight - 26);
		jQuery("#right-scrollspy").height(docHeight - viewerTop - footerHeight - 10);
	}
	
	jQuery('.closereading-section').click(function () {
		GoToOtherColumnPosition(jQuery(this));
	});

	jQuery('.closereading-section').hover(function () {	
		var target = jQuery(jQuery(this).data("other"));
        if (target.length) {
			target.addClass("closereading-highlighted");
			if (jQuery(this).data("this") == "left-") {
				rightHighlightedItem = target;
			} else if (jQuery(this).data("this") == "right-") {
				leftHighlightedItem = target;
			}
		}
        if (jQuery('input#autoscroll').is(':checked')) {
			GoToOtherColumnPosition(jQuery(this));
		}
	},
	function() {
		if (rightHighlightedItem != null) {
			rightHighlightedItem.removeClass("closereading-highlighted");
		}
		if (leftHighlightedItem != null) {
			leftHighlightedItem.removeClass("closereading-highlighted");
		}
	});

	function GoToOtherColumnPosition(element) {
		// Figure out element to scroll to
        var target = jQuery(element.data("other"));
            
        if (target.length) {

			var scrollWindow;
			
			if (element.data("this") == "left-") {
				scrollWindow = "#right-scrollspy";	
				if (rightActiveItem != null) {
					rightActiveItem.removeClass("closereading-active");
				}
				rightActiveItem = target;
								
				if (leftActiveItem != null) {
					leftActiveItem.removeClass("closereading-active");
				}
				element.addClass("closereading-active");
				leftActiveItem = element;

			} else if (element.data("this") == "right-") {
				scrollWindow = "#left-scrollspy";	
				if (leftActiveItem != null) {
					leftActiveItem.removeClass("closereading-active");
				}
				leftActiveItem = target;

				if (rightActiveItem != null) {
					rightActiveItem.removeClass("closereading-active");
				}
				element.addClass("closereading-active");
				rightActiveItem = element;

			}
			target.addClass("closereading-active");

            // Adjusted code to scroll to position relative to overflow parent _gpl
			var originalTopPosition = target.position().top - target.parent().position().top;
			if (target.hasClass("closereading-inline")) {
				originalTopPosition = target.parent().position().top - target.parent().parent().position().top;
			}

            if (smoothscroll) {
				jQuery(scrollWindow).clearQueue();
				jQuery(scrollWindow).animate({ scrollTop: originalTopPosition }, 500, function() {
					// Callback after animation
					// Must change focus!
					var target = jQuery(target);
					target.focus();
                    
					if (target.is(":focus")) { // Checking if the target was focused
						return false;
					} else {
						target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
						target.focus(); // Set focus again
					};

				});
            } else {
				jQuery(scrollWindow).scrollTop(originalTopPosition);
			}
        }
	}

	jQuery('#layout-group').change(function() {
		
		switch (this.value) {
			case 'closereading-layout1':
				jQuery('.closereading-layout-left').attr("class", "col-md-9 closereading-layout-left");
				jQuery('.closereading-layout-right').attr("class", "col-md-3 closereading-layout-right");
				break;
			case 'closereading-layout2':
	            jQuery('.closereading-layout-left').attr("class", "col-md-8 closereading-layout-left");
		        jQuery('.closereading-layout-right').attr("class", "col-md-4 closereading-layout-right");
				break;
			case 'closereading-layout3':
			    jQuery('.closereading-layout-left').attr("class", "col-md-7 closereading-layout-left");
				jQuery('.closereading-layout-right').attr("class", "col-md-5 closereading-layout-right");
				break;
			case 'closereading-layout4':
	            jQuery('.closereading-layout-left').attr("class", "col-md-6 closereading-layout-left");
		        jQuery('.closereading-layout-right').attr("class", "col-md-6 closereading-layout-right");
				break;
			case 'closereading-layout5':
			    jQuery('.closereading-layout-left').attr("class", "col-md-5 closereading-layout-left");
				jQuery('.closereading-layout-right').attr("class", "col-md-7 closereading-layout-right");
				break;
			case 'closereading-layout6':
	            jQuery('.closereading-layout-left').attr("class", "col-md-4 closereading-layout-left");
		        jQuery('.closereading-layout-right').attr("class", "col-md-8 closereading-layout-right");
				break;
			case 'closereading-layout7':
			    jQuery('.closereading-layout-left').attr("class", "col-md-3 closereading-layout-left");
				jQuery('.closereading-layout-right').attr("class", "col-md-9 closereading-layout-right");
				break;
			default:
				break;
		}

	});

	jQuery('#font-select').change(function() {
		jQuery('.dhs_closereading').css("font-size", this.value + 'pt');
	});
	
    jQuery('input[type=radio][name=closereading-layout]').change(function() {
	
        if (this.value == 'closereading-layout1') {
            jQuery('.closereading-layout-left').attr("class", "col-md-9 closereading-layout-left");
            jQuery('.closereading-layout-right').attr("class", "col-md-3 closereading-layout-right");
        }
        else if (this.value == 'closereading-layout2') {
            jQuery('.closereading-layout-left').attr("class", "col-md-8 closereading-layout-left");
            jQuery('.closereading-layout-right').attr("class", "col-md-4 closereading-layout-right");
        }
        else if (this.value == 'closereading-layout3') {
            jQuery('.closereading-layout-left').attr("class", "col-md-7 closereading-layout-left");
            jQuery('.closereading-layout-right').attr("class", "col-md-5 closereading-layout-right");
        }
        else if (this.value == 'closereading-layout4') {
            jQuery('.closereading-layout-left').attr("class", "col-md-6 closereading-layout-left");
            jQuery('.closereading-layout-right').attr("class", "col-md-6 closereading-layout-right");
        }
        else if (this.value == 'closereading-layout5') {
            jQuery('.closereading-layout-left').attr("class", "col-md-5 closereading-layout-left");
            jQuery('.closereading-layout-right').attr("class", "col-md-7 closereading-layout-right");
        }
        else if (this.value == 'closereading-layout6') {
            jQuery('.closereading-layout-left').attr("class", "col-md-4 closereading-layout-left");
            jQuery('.closereading-layout-right').attr("class", "col-md-8 closereading-layout-right");
        }
        else if (this.value == 'closereading-layout7') {
            jQuery('.closereading-layout-left').attr("class", "col-md-3 closereading-layout-left");
            jQuery('.closereading-layout-right').attr("class", "col-md-9 closereading-layout-right");
        }

    });

    // Adapted from codepen smooth-scrolling usability example, available at:
    // https://codepen.io/chriscoyier/pen/dpBMVP
    jQuery('a[href*="#"]')
    .not('[href="#"]')
    .not('[href="#0"]')
    .click(function(event) {
        if ( location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
        && location.hostname == this.hostname) {
            // Figure out element to scroll to
            var target = jQuery(this.hash);
            
            target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
			
                if (smoothscroll) event.preventDefault();

                // Adjusted code to scroll to position relative to overflow parent _gpl
                var originalTopPosition = target.position().top - target.parent().position().top;

                if (smoothscroll) {
					jQuery('#right-scrollspy').animate({ scrollTop: originalTopPosition }, 500, function() {
						// Callback after animation
						// Must change focus!
						var target = jQuery(target);
						target.focus();
                    
						if (target.is(":focus")) { // Checking if the target was focused
							return false;
						} else {
							target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
							target.focus(); // Set focus again
						};
					});
                }
            }
        }
    });

});