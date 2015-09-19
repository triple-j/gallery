(function( $, window ) {

	"use strict";

	$( document ).ready(function(){
		console.log("hi");


		$('.pages').on('click', 'a', function(evt){
			evt.preventDefault();

			var url = $(this).attr('href');

			changePage( url );
		});

		window.addEventListener("popstate", function(evt) {
			console.log("location: " + document.location + ", state: " + JSON.stringify(evt.state));

			if (evt.state.page) {
				changePage( document.location, false );
			}
		});
	});

	function changePage( url, addToHistory ) {
		if (addToHistory === undefined) { addToHistory = true; }

		$.ajax({
			url: url,
			type: "GET",
			dataType: "html"
		}).done(function(responseText) {
			var $resDOM = $( "<div>" ).append( $.parseHTML( responseText ) );
			var currentPage = $($resDOM.find('.pages .current').get(0)).text();

			$('.pages').html($resDOM.find('.pages').get(0).innerHTML);
			$('#gallery').html($resDOM.find('#gallery').get(0).innerHTML);

			if ( addToHistory ) {
				history.pushState({page: currentPage}, "page " + currentPage, url);
			}
			console.log(currentPage);
		});
	}

})( jQuery, window );
