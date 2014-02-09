(function( $, window, undefined ) {

	"use strict";

	window.Gallery = function( options ){

		this.file = {
			"VIEWER"       : options.VIEWER,
			"AJAX_LISTING" : options.AJAX_LISTING,
			"AJAX_FEATURE" : options.AJAX_FEATURE
		};

		this.current_page = options.current_page || 1;
		this.default_page = this.current_page;
		this.total_pages  = options.total_pages;

		this.key = {
			"LEFT_ARROW"  : 37,
			"UP_ARROW"    : 38,
			"RIGHT_ARROW" : 39,
			"DOWN_ARROW"  : 40
		};
		this.nav_visible  = options.nav_visible || false;
		this.current_img  = options.current_img;
		this.default_img  = this.current_img;
		this.imgs_per_nav = options.imgs_per_nav || 6;
	};

	Gallery.prototype.init = function( type ){
		var gallery = this;
		type = type || "listing";

		if ( type == "listing" ) {

			$(window).on('hashchange', function(evt){
				gallery.change_page(evt, gallery);
			});
			this.change_page(null, gallery);

		} else if ( type == "viewer" ) {

			$(window).on('hashchange', function(evt){
				gallery.change_img(evt, gallery);
			});
			this.change_img(null, gallery);
			this.display_nav();

			$(document).on('keypress', function(evt){
				gallery.key_pressed(evt, gallery);
			});

		}

		$('#gallery, #thumb-nav').on('click', '.img-thumb-box a', function(evt){
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

		$('#gallery').load(gallery.file.AJAX_LISTING, {page:gallery.current_page});
	};


	Gallery.prototype.open_image = function(evt, gallery){
		var img_link = $(evt.currentTarget).attr('href');

		console.log( {img_link:img_link, file:gallery.file.VIEWER} );

		location.href = gallery.file.VIEWER + "#img:" + img_link;
		evt.preventDefault();
	};


	///// viewer /////

	Gallery.prototype.key_pressed = function(evt, gallery){
		var pressed = (evt.keyCode || evt.charCode);

		console.log( {pressed:pressed} );

		switch ( pressed ) {
			case gallery.key['LEFT_ARROW']:
				console.log( "View Previous Image" );
				gallery.prev_img();
				break;
			case gallery.key['RIGHT_ARROW']:
				console.log( "View Next Image" );
				gallery.next_img();
				break;
			case gallery.key['UP_ARROW']:
				console.log( "Open Navigation" );
				gallery.open_nav(gallery);
				break;
			case gallery.key['DOWN_ARROW']:
				console.log( "Close Navigation" );
				gallery.close_nav(gallery);
				break;
		}
	};


	Gallery.prototype.change_img = function(evt, gallery) {
		var image = location.hash.replace(/^#img:/,"");

		console.log( {image:image, current:gallery.current_img} );

		switch ( image ) {
			case "prev":
				gallery.prev_img();
				break;
			case "next":
				gallery.next_img();
				break;
			case "":
				gallery.current_img = gallery.default_img;
				break;
			default:
				gallery.current_img = image;
		}

		$('#viewer').load(gallery.file.AJAX_FEATURE, {img:gallery.current_img,preload:0}, function(){
			if ( gallery.nav_visible ) {
				gallery.open_nav(gallery);
			}
		});
	};

	Gallery.prototype.prev_img = function() {
		var prev_href = $('#viewer .nav-links a.prev').attr('href');
		location.hash = "#img:" + prev_href;
	};

	Gallery.prototype.next_img = function() {
		var next_href = $('#viewer .nav-links a.next').attr('href');
		location.hash = "#img:" + next_href;
	};

	Gallery.prototype.display_nav = function( visible ) {
		if ( visible === undefined ) {
			visible = this.nav_visible;
		} else {
			this.nav_visible = visible;
		}

		if ( visible ) {
			$('#thumb-nav').show();
		} else {
			$('#thumb-nav').hide();
		}
	};

	Gallery.prototype.open_nav = function(gallery) {
		$('#thumb-nav').load(gallery.file.AJAX_LISTING, {numof:gallery.imgs_per_nav,rel:gallery.current_img}, function(){
			console.log("Thumb Navigation Updated");
			gallery.display_nav( true );
		});
	};

	Gallery.prototype.close_nav = function(gallery) {
		gallery.display_nav( false );
	};


})( jQuery, window );
