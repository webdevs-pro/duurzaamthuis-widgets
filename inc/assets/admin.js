jQuery(function($){

	// it is a copy of the inline edit function
	var wp_inline_edit_function = inlineEditPost.edit;

	// we overwrite the it with our own
	inlineEditPost.edit = function( post_id ) {

		// let's merge arguments of the original function
		wp_inline_edit_function.apply( this, arguments );

		// get the post ID from the argument
		var id = 0;
		if ( typeof( post_id ) == 'object' ) { // if it is object, get the ID number
			id = parseInt( this.getId( post_id ) );
		}

		// if post id exists
		if ( id > 0 ) {

			// add rows to variables
			var specific_post_edit_row = $( '#edit-' + id ),
				specific_post_row = $( '#post-' + id ),
				term_id = $( '.dh_template', specific_post_row ).text().match(/\(([^)]+)\)/)[1];

				console.log(term_id)
			$( 'select[name="dh_template"]', specific_post_edit_row ).val(term_id);

		}
	}

	$( 'body' ).on( 'click', 'input[name="bulk_edit"]', function(e) {
		e.preventDefault;
		// let's add the WordPress default spinner just before the button
		$( this ).after('<span class="spinner is-active"></span>');
		
		
		var bulk_edit_row = $( 'tr#bulk-edit' );
		var post_ids = new Array();
		var template = bulk_edit_row.find( '.dh_template' ).val();
		
		
		// now we have to obtain the post IDs selected for bulk edit
		bulk_edit_row.find( '#bulk-titles' ).children().each( function() {
			post_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
		});

		// save the data with AJAX
		$.ajax({
			url: ajaxurl, // WordPress has already defined the AJAX url for us (at least in admin area)
			type: 'POST',
			async: false,
			data: {
				action: 'misha_save_bulk', // wp_ajax action hook
				post_ids: post_ids, // array of post IDs
				dh_template: template, // new price
			}
		});
	});




	});