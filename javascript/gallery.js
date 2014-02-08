(function( $, window, undefined ) {

	"use strict";

	window.Gallery = function( options ){

		this.file = {
			"VIEWER"       : options.VIEWER,
			"AJAX_LISTING" : options.AJAX_LISTING
		};

		this.current_page = options.current_page || 1;
		this.default_page = this.current_page;
		this.total_pages  = options.total_pages;

	};

	Gallery.prototype.init = function(){
		var gallery = this;

		$(window).on('hashchange', function(evt){
			gallery.change_page(evt, gallery);
		});
		this.change_page(null, gallery);

		$('#gallery').on('click', '.img-thumb-box a', function(evt){
			gallery.open_image(evt, gallery);
		});
	};


	Gallery.prototype.change_page = function(evt, gallery){
		var page = location.hash.replace(/^#page-/,"");

		console.log( {page:page, current:gallery.current_page, file:gallery.file} );

		switch ( page ) {
			case "prev":
				if ( gallery.current_page > 1 ) {
					gallery.current_page--;
					location.hash = "#page-" + gallery.current_page;
				}
				break;
			case "next":
				if ( gallery.current_page < total_pages ) {
					this.current_page++;
					location.hash = "#page-" + gallery.current_page;
				}
				break;
			case "":
				gallery.current_page = gallery.default_page;
				break;
			default:
				gallery.current_page = parseInt(page,10);
		}

		console.log( {page:page, current:gallery.current_page} );

		var AJAX_LISTING = gallery.file.AJAX_LISTING;

		$('#gallery').load(AJAX_LISTING, {page:gallery.current_page});
	};


	Gallery.prototype.open_image = function(evt, gallery){
		var img_link = $(evt.currentTarget).attr('href');

		console.log( {img_link:img_link, file:gallery.file.VIEWER} );

		location.href = gallery.file.VIEWER + "#img:" + img_link;
		evt.preventDefault();
	};

})( jQuery, window );
