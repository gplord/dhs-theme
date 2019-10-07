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

    var primaryactive = false;
    var secondaryactive = false;
	
	var primaryHighlightedItem;
	var secondaryHighlightedItem;
	var primaryActiveItem;
	var secondaryActiveItem;

    jQuery('#primary-scrollspy').hover(function(){
        primaryactive = true;
        secondaryactive = false;
    });
    jQuery('#secondary-scrollspy').hover(function(){
        primaryactive = false;
        secondaryactive = true;
    });

	if (jQuery("#primary-scrollspy").length) {

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
		//jQuery("#primary-scrollspy").height(docHeight - viewerTop - footerHeight - 10);
		jQuery("#closereading-primarytext").height(docHeight - viewerTop - footerHeight - 26);
		jQuery("#secondary-scrollspy").height(docHeight - viewerTop - footerHeight - 10);
	}
	
	jQuery('.closereading-section').click(function () {
		GoToOtherColumnPosition(jQuery(this));
	});

	jQuery('.closereading-section').hover(function () {	
		var target = jQuery(jQuery(this).data("other"));
        if (target.length) {
			target.addClass("closereading-highlighted");
			if (jQuery(this).data("this") == "primary-") {
				secondaryHighlightedItem = target;
			} else if (jQuery(this).data("this") == "secondary-") {
				primaryHighlightedItem = target;
			}
		}
        if (jQuery('input#autoscroll').is(':checked')) {
			GoToOtherColumnPosition(jQuery(this));
		}
	},
	function() {
		if (secondaryHighlightedItem != null) {
			secondaryHighlightedItem.removeClass("closereading-highlighted");
		}
		if (primaryHighlightedItem != null) {
			primaryHighlightedItem.removeClass("closereading-highlighted");
		}
	});

	function GoToOtherColumnPosition(element) {
		// Figure out element to scroll to
        var target = jQuery(element.data("other"));
            
        if (target.length) {

			var scrollWindow;
			
			if (element.data("this") == "primary-") {
				scrollWindow = "#secondary-scrollspy";	
				if (secondaryActiveItem != null) {
					secondaryActiveItem.removeClass("closereading-active");
				}
				secondaryActiveItem = target;
								
				if (primaryActiveItem != null) {
					primaryActiveItem.removeClass("closereading-active");
				}
				element.addClass("closereading-active");
				primaryActiveItem = element;

			} else if (element.data("this") == "secondary-") {
				scrollWindow = "#primary-scrollspy";	
				if (primaryActiveItem != null) {
					primaryActiveItem.removeClass("closereading-active");
				}
				primaryActiveItem = target;

				if (secondaryActiveItem != null) {
					secondaryActiveItem.removeClass("closereading-active");
				}
				element.addClass("closereading-active");
				secondaryActiveItem = element;

			}
			target.addClass("closereading-active");

            // Adjusted code to scroll to position relative to overflow parent _gpl
            var originalTopPosition = target.position().top - target.parent().position().top;

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
				jQuery('.closereading-layout-primary').attr("class", "col-md-9 closereading-layout-primary");
				jQuery('.closereading-layout-secondary').attr("class", "col-md-3 closereading-layout-secondary");
				break;
			case 'closereading-layout2':
	            jQuery('.closereading-layout-primary').attr("class", "col-md-8 closereading-layout-primary");
		        jQuery('.closereading-layout-secondary').attr("class", "col-md-4 closereading-layout-secondary");
				break;
			case 'closereading-layout3':
			    jQuery('.closereading-layout-primary').attr("class", "col-md-7 closereading-layout-primary");
				jQuery('.closereading-layout-secondary').attr("class", "col-md-5 closereading-layout-secondary");
				break;
			case 'closereading-layout4':
	            jQuery('.closereading-layout-primary').attr("class", "col-md-6 closereading-layout-primary");
		        jQuery('.closereading-layout-secondary').attr("class", "col-md-6 closereading-layout-secondary");
				break;
			case 'closereading-layout5':
			    jQuery('.closereading-layout-primary').attr("class", "col-md-5 closereading-layout-primary");
				jQuery('.closereading-layout-secondary').attr("class", "col-md-7 closereading-layout-secondary");
				break;
			case 'closereading-layout6':
	            jQuery('.closereading-layout-primary').attr("class", "col-md-4 closereading-layout-primary");
		        jQuery('.closereading-layout-secondary').attr("class", "col-md-8 closereading-layout-secondary");
				break;
			case 'closereading-layout7':
			    jQuery('.closereading-layout-primary').attr("class", "col-md-3 closereading-layout-primary");
				jQuery('.closereading-layout-secondary').attr("class", "col-md-9 closereading-layout-secondary");
				break;
			default:
				break;
		}

	});

	jQuery('#font-select').change(function() {
		jQuery('.dhs_split_text').css("font-size", this.value + 'pt');
	});
	
    jQuery('input[type=radio][name=closereading-layout]').change(function() {
	
        if (this.value == 'closereading-layout1') {
            jQuery('.closereading-layout-primary').attr("class", "col-md-9 closereading-layout-primary");
            jQuery('.closereading-layout-secondary').attr("class", "col-md-3 closereading-layout-secondary");
        }
        else if (this.value == 'closereading-layout2') {
            jQuery('.closereading-layout-primary').attr("class", "col-md-8 closereading-layout-primary");
            jQuery('.closereading-layout-secondary').attr("class", "col-md-4 closereading-layout-secondary");
        }
        else if (this.value == 'closereading-layout3') {
            jQuery('.closereading-layout-primary').attr("class", "col-md-7 closereading-layout-primary");
            jQuery('.closereading-layout-secondary').attr("class", "col-md-5 closereading-layout-secondary");
        }
        else if (this.value == 'closereading-layout4') {
            jQuery('.closereading-layout-primary').attr("class", "col-md-6 closereading-layout-primary");
            jQuery('.closereading-layout-secondary').attr("class", "col-md-6 closereading-layout-secondary");
        }
        else if (this.value == 'closereading-layout5') {
            jQuery('.closereading-layout-primary').attr("class", "col-md-5 closereading-layout-primary");
            jQuery('.closereading-layout-secondary').attr("class", "col-md-7 closereading-layout-secondary");
        }
        else if (this.value == 'closereading-layout6') {
            jQuery('.closereading-layout-primary').attr("class", "col-md-4 closereading-layout-primary");
            jQuery('.closereading-layout-secondary').attr("class", "col-md-8 closereading-layout-secondary");
        }
        else if (this.value == 'closereading-layout7') {
            jQuery('.closereading-layout-primary').attr("class", "col-md-3 closereading-layout-primary");
            jQuery('.closereading-layout-secondary').attr("class", "col-md-9 closereading-layout-secondary");
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
					jQuery('#secondary-scrollspy').animate({ scrollTop: originalTopPosition }, 500, function() {
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