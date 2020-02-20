jQuery(document).ready(function(){

	var rdfDownloadPrefix = "dhs";

	// Kind of hackish, but add a link to any image object that has a link in its caption
	jQuery('figure.gallery-item:has(figcaption a)').find('img').addClass('cursorpointer').click(function() {
		var captionlink = jQuery(this).find('a').attr('href');
		if (captionlink != null) {
			window.location.href = captionlink;
		}
	});
		
    jQuery( "#lightbox-sortable" ).disableSelection();
	jQuery("#lightbox-sortable").sortable({										// Lightbox sortable grid initialization
		tolerance: "pointer",
		update: function() {													// When we rearrange the Lightbox grid...
			var sortedIDs = jQuery("#lightbox-sortable").sortable("toArray");	// Serialize all of the #lightbox-sortable child IDs...
			for (var i = sortedIDs.length - 1; i >= 0; i--) {					// Iterate backwards through the serialized IDs...
				jQuery("#pdf #post-"+sortedIDs[i]).prependTo("#pdf");			// and push them all to the front of the parent, in reverse order
			}
		}
	})
	
	jQuery("#lightbox-selection").submit(function( event ) {
		var idArray = [];
		jQuery(".edg-checkbox").each(function() {
			if (this.checked) idArray.push(this.id);
		});
		if (idArray.length > 1) {
			jQuery("#lightbox-ids").val(idArray.join());
			jQuery("#lightbox-selection").submit();
		} else {
			event.preventDefault();
			alert("Please select at least two entries to submit to the lightbox.");
		}
	});
		
	var images = [];			// Global array of image nodes
	var imageDimensions = [];	// Global array of rendered image dimensions, used in asynchronous second pass
	
	var imagesNeeded = 0;		// Default to expecting no images; this will be incremented by the traversal
	var imagesFinished = 0;		// Number of images rendered
	var pdfDoc;					// Global PDF element

	var traverseDOM = function walk(node, func) {	// DOM traversal function
		func(node);
		node = node.firstChild;
		while (node) {
			walk(node, func);
			node = node.nextSibling;
		}
	};
	
	// Dynamic Image Data URI generator
	function getDataUri(url, dimensions, callback) {
		var image = new Image();

		image.onload = function () {
			var canvas = document.createElement('canvas');
			canvas.width = this.naturalWidth;	// or 'width' if you want a special/scaled size
			canvas.height = this.naturalHeight; // or 'height' if you want a special/scaled size

			canvas.getContext('2d').drawImage(this, 0, 0);

			// Get raw image data
			//callback(canvas.toDataURL('image/png').replace(/^data:image\/(png|jpg);base64,/, ''));

			// ... or get as Data URI
			callback(canvas.toDataURL('image/png'), dimensions);
		};

		image.src = url;
	}
	
	function rdfdownload(filename, text) {
        var element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        element.setAttribute('download', filename);
    
        element.style.display = 'none';
        document.body.appendChild(element);
    
        element.click();
    
        document.body.removeChild(element); 
    }
	
	jQuery(".rdf-download-collection").click(function() {
		var id = jQuery(this).attr("data-id");
	    var text = jQuery("#rdf-collection-" + id).text();
        var filename = rdfDownloadPrefix + "-collection-" + id + ".rdf";
        rdfdownload(filename, text);
	});
	
	jQuery(".rdf-download-chapter").click(function() {
	    var id = jQuery(this).attr("data-id");
	    var text = jQuery("#rdf-chapter-" + id).text();
	    var filename = rdfDownloadPrefix + "-chapter-" + id + ".rdf";
	    rdfdownload(filename, text);
	});
	
});

/**
 *
 * javascript full-screen window technology - fullscreen mode
 *
 * Copyright 2013, Dhiraj kumar
 * http://www.css-jquery-design.com/
 */

// mozfullscreenerror event handler
function errorHandler() {
   alert('mozfullscreenerror');
}
document.documentElement.addEventListener('mozfullscreenerror', errorHandler, false);

// toggle full screen
function toggleFullScreen() {
  if (!document.fullscreenElement &&    // alternative standard method
      !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
    if (document.documentElement.requestFullscreen) {
      document.documentElement.requestFullscreen();
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
    } else if (document.documentElement.webkitRequestFullscreen) {
      document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
    }
  } else {
    if (document.cancelFullScreen) {
      document.cancelFullScreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitCancelFullScreen) {
      document.webkitCancelFullScreen();
    }
  }
}

