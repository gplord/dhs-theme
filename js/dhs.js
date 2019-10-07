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
	
	jQuery("#rdf-download-collection").click(function() {
        var text = jQuery("#rdf-collection-content").text();
        var filename = rdfDownloadPrefix + "-collection.rdf";
        rdfdownload(filename, text);
	});
	
	jQuery(".rdf-download-chapter").click(function() {
	    var id = jQuery(this).attr("data-id");
	    var text = jQuery("#rdf-" + id).text();
	    var filename = rdfDownloadPrefix + "-chapter-" + id + ".rdf";
	    rdfdownload(filename, text);
	});

	jQuery(".pdfbutton").click(function () {		// Main method, called when clicking the button to generate a PDF
	
		jQuery('#pdf-progressbar').show();

		// CUSTOMIZE: Replace these values with your Collection's PDF specifications
		var pdfTitle = "My Theory of the En Dehors Garde";
		var pageWidth = 8.5;	// Units are in inches -- see above constructor
		var pageHeight = 11;
		var lineHeight = 1.5;	// Line spacing, used in calculations throughout
		var margin = 0.5;		// Margin from edge of page
		var maxLineWidth = pageWidth - margin * 2;
		var fontSize = 12;		// Font size in points
		var currentFontSize = fontSize;
		var ptsPerInch = 72;
		var oneLineHeight = fontSize * lineHeight / ptsPerInch;
		var pageCount = 1;		// Current page used through the traversal, and total number, used for page numbering afterwards
		var usePageNumbering = true;	// Default to including page numbering -- set to false if these are not desired
		var useFooterSiteLink = true;
		var footerSiteLinkURL = 'http://www.mina-loy.com/endehorsgarde';

		var siteWidth = 1110;	// Width in pixels of the website -- used to calculate image ratios
		var maxHeight = 8;		// Maximum allowed height of images (in inches)
		var yPosition = margin;	// Current y position of the iterator, in rendering elements to the PDF
		var newHeaderThreshold = 5;

		var renderingHeader = false;	// Flag to temporarily switch font styles for header elements
		var passedFirstHeader = false;	// Flag to prevent adding separator to the first header in the document
		
		var doc = new jsPDF({
			unit: 'in',
			lineHeight: 1.2
		}).setProperties({ title: pdfTitle });
		
		traverseDOM(jQuery('#pdf').get(0), function(node) {

			if (node.nodeType == 3) {	// Raw text node
				var trimmed = jQuery.trim(jQuery(node).text());
				if (trimmed.length > 0) {
					
					if (renderingHeader) {

						doc.setFontSize(24);
						doc.setFontType("bold");
						currentFontSize = 24;
												
						// Threshold for starting a new page if the new header is too close to the bottom of a page
						if (yPosition + (oneLineHeight * newHeaderThreshold) > (pageHeight - margin * 2)) {	
							doc.addPage();										// create a new page
							pageCount++;										
							yPosition = margin - 1.5 * oneLineHeight;			// and set the y position to the top of the new page					
						}

					}
					
					var textNode = jQuery(node).text();

					var textLines = doc.splitTextToSize(textNode, maxLineWidth);
					var textHeight = textLines.length * fontSize * lineHeight / ptsPerInch;

					for (i = 0; i < textLines.length; i++) {
						if (yPosition + oneLineHeight > (11 - oneLineHeight)) {	// If the next line would spill off of the page,
							doc.addPage();										// create a new page
							pageCount++;										
							yPosition = margin - 1.5 * oneLineHeight;			// and set the y position to the top of the new page
						}
						doc.text(textLines[i], margin, yPosition + 2 * oneLineHeight);
						yPosition += oneLineHeight;
						if (i + 1 == textLines.length) {	// If this is the last of the textLines, 
							yPosition += oneLineHeight;		// add a full line space before the next element
						}
					}
										
					if (renderingHeader) {			// Reset to original text properties
						renderingHeader = false;	
						passedFirstHeader = true;	// Flag to begin adding separators to subsequent headers
						yPosition += oneLineHeight/2;	// Add padding below the header
						doc.setFontSize(12);
						doc.setFontType("normal");
						currentFontSize = 12;
					}

				}
			} else {	// If it's another type of node, use the appropriate rendering method

				if (node.nodeName == "H1") {	// Headers (Can add rules for smaller headers here)

					renderingHeader = true;					
				
					if (passedFirstHeader) {
						yPosition += oneLineHeight;
						doc.setDrawColor(200,200,200);
						doc.setLineWidth(0.01);
						doc.line(margin, yPosition, pageWidth - margin * 2, yPosition); // horizontal line
					}

				}
				if (node.nodeName == "IMG") {	// Images

					var widthRatio;
					var finalWidth;
					var heightRatio;
					var finalHeight;
					if (node.naturalWidth > siteWidth) {
						widthRatio = 1;
					} else {
						widthRatio = node.naturalWidth / siteWidth;
					}
					finalWidth = (pageWidth - margin * 2) * widthRatio;

					heightRatio = node.naturalHeight / node.naturalWidth;
					finalHeight = finalWidth * heightRatio;
					if (finalHeight > maxHeight) {
						finalHeight = maxHeight;
						finalWidth = (node.naturalWidth / node.naturalHeight) * finalHeight;
					}

					if (yPosition + finalHeight > (pageHeight - margin * 2)) {
						doc.addPage();										// create a new page
						pageCount++;										
						yPosition = margin - 1.5 * oneLineHeight;			// and set the y position to the top of the new page					
					}
					
					images.push(node);
					var dimensions = [pageCount, margin, yPosition+oneLineHeight, finalWidth, finalHeight];
					imageDimensions.push(dimensions);

					yPosition += finalHeight;	// Create vertical blank space for the final image size
												// Image will be drawn on subsequent pass

				}
			}
		});

		if (usePageNumbering) {		// Add page numbering, if desired
			if (pageCount > 1) {	// But only if there is more than one page
				for (i = 1; i <= pageCount; i++) {
					doc.setPage(i);
					doc.setFontSize(10);
					doc.setFont("helvetica");
					doc.setFontType("normal");
					doc.text(pageWidth - 1.25 * margin, 11.35, i + " of " + pageCount, null, null, 'right');
				}
			}
		}

		if (useFooterSiteLink) {
			for (i = 1; i <= pageCount; i++) {
				doc.setPage(i);
				doc.setFontSize(10);
				doc.setFont("helvetica");
				doc.setFontType("normal");
				doc.text(margin, 11.35, footerSiteLinkURL, null, null, 'left');
			}		
		}

		// If the traversal found images (it almost definitely will)
		if (images.length > 0) {
			
			imagesNeeded = images.length;		// Prepare global variables to expect callback checks
			pdfDoc = doc;						// Set the global pdf element to this document

			for (i = 0; i < images.length; i++) {

				var thisImageDimensions = imageDimensions[i];

				// Get image data URI and return it via callback
				getDataUri(images[i].getAttribute("src"), thisImageDimensions, function(dataUri, returnDimensions) {
					// Upon callback
					doc.setPage(returnDimensions[0]);
					doc.addImage(dataUri, 'PNG', returnDimensions[1], returnDimensions[2], returnDimensions[3], returnDimensions[4]);
					imagesFinished++;
					tryToSaveDoc();
				});
			}
					
		} else {	// But, if not, skip to saving out the doc
		
			imagesNeeded = 0;
			pdfDoc = doc;						// Set the global pdf element to this document
			tryToSaveDoc();	

		}
	});
	
	function tryToSaveDoc() {
	
		if (imagesFinished >= imagesNeeded) {
			
			var string = pdfDoc.output('bloburi');
			jQuery('.preview-pane').show();
			jQuery('.preview-pane').attr('src', string);
			console.log("PDF loaded.");
			jQuery('#pdf-progressbar').hide();

		} else {
				
			var progress = Math.floor((imagesFinished / imagesNeeded) * 100);

			jQuery('#pdf-progressbar .progress-bar').attr('aria-valuenow', progress);
			jQuery('#pdf-progressbar .progress-bar').css('width', progress + '%');
			jQuery('#pdf-progressbar .progress-bar').text('Generating PDF: ' + progress + '%');

			console.log("PDF loading: " + imagesFinished + " out of " + imagesNeeded + " images loaded.");

		}
	}
	
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

