(function( $, window ) {

	"use strict";

	$( document ).ready(function(){
		console.log("hi");


		$('.pages').on('click', 'a', function(evt){
			evt.preventDefault();

			var url = $(this).attr('href');

			changePage( url );
		});

		$('#gallery, #popup').on('click', '.img-thumb-box a, .image-nav a', function(evt){
			evt.preventDefault();

			var url = $(this).attr('href');

			changeImage( url );
		});

		$('#overlay').on('click', closePopup);

		window.addEventListener("popstate", function(evt) {
			console.log("location: " + document.location + ", state: " + JSON.stringify(evt.state));

			if (evt.state.page) {
				changePage( document.location, false );
			} else if (evt.state.image) {
				changeImage( document.location, false );
			}
		});
	});

	function changePage( url, addToHistory, leavePopup ) {
		if (addToHistory === undefined) { addToHistory = true; }
		if (leavePopup === undefined) { leavePopup = false; }

		$.ajax({
			url: url,
			type: "GET",
			dataType: "html"
		}).done(function(responseText) {
			var $resDOM = $( "<div>" ).append( $.parseHTML( responseText ) );
			var currentPage = $($resDOM.find('.pages .current').get(0)).text();

			$('.pages').html($resDOM.find('.pages').get(0).innerHTML);
			$('#gallery').html($resDOM.find('#gallery').get(0).innerHTML);

			if ( leavePopup == false ) {
				closePopup();
			}

			if ( addToHistory ) {
				history.pushState({page: currentPage}, "page " + currentPage, url);
			}

			console.log(currentPage);
		});
	}

	function changeImage( url, addToHistory ) {
		if (addToHistory === undefined) { addToHistory = true; }

		$.ajax({
			url: url,
			type: "GET",
			dataType: "html"
		}).done(function(responseText) {
			var $resDOM = $( "<div>" ).append( $.parseHTML( responseText ) );
			var currentImage = $($resDOM.find('#viewer .media').get(0)).attr('src');
			var prevSaveUrl = window.saveUrl;
			window.saveUrl = $($resDOM.find('#nav-links .gallery').get(0)).attr('href');

			if ( prevSaveUrl && prevSaveUrl != window.saveUrl ) {
				changePage(window.saveUrl, false, true);
			}

			$('#viewer').html($resDOM.find('#viewer').get(0).innerHTML);

			openPopup();

			if ( addToHistory ) {
				history.pushState({image: currentImage}, "image " + currentImage, url);
			}

			console.log(currentImage);
		});
	}

	function openPopup() {
		$('#overlay, #popup').addClass("active");
	}

	function closePopup() {
		if ( window.saveUrl !== undefined ) {
			history.pushState({page: true}, "page unknown", window.saveUrl);
			window.saveUrl = undefined;
		}

		$('#overlay, #popup').removeClass("active");
	}

})( jQuery, window );
