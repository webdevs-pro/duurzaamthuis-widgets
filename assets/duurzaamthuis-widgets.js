( function( $ ) {
	/**
 	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */ 
	var DH_Header = function( $scope, $ ) {

		var toggle = $scope.find('.dh-page-header-calc-toggle');
		var content = $scope.find('.dh-page-header-calc-text');

		$(toggle).on('click', function(){
			$(toggle).toggleClass('active');
			$(content).slideToggle(300);
		})
		
	};

	var DH_Product_Comparison = function( $scope, $ ) {
		$scope.find('.dh-product-description').each(function() {
			var height = $(this).height();
			var content = $(this).find('.dh-product-description-content');
			var content_height = $(content).height();
			// console.log(content_height);
			if(content_height > height) {
				var open = $(this).find('.dh-open');
				var close = $(this).find('.dh-close');
				$(open).show();
				var parent = this;
				$(open).on('click', function() {
					$(parent).css('max-height', content_height + 22);
					$(this).hide();
					$(close).show();
				});
				$(close).on('click', function() {
					$(parent).css('max-height', height);
					setTimeout(function(){
						$(this).hide();
						$(open).show();
					}, 150);
				});
			}
		});
	};


	var DH_Impact = function( $scope, $ ) {

		var toggle = $scope.find('.dh-impact-calc-toggle');
		var content = $scope.find('.dh-impact-calc-text');

		$(toggle).on('click', function(){
			$(toggle).toggleClass('active');
			$(content).slideToggle(300);
		})
		
	};


	var DH_Mega_Menu = function( $scope, $ ) {

		var toggle = $scope.find( '.dh-mobile-menu-toggle' );
		console.log(toggle);
		var menu = $scope.find( '.dh-mobile-menu' );
		var submenu_toggle = $scope.find( '.dh-mobile-submenu-toggle' );

		$( toggle ).on( 'click', function() {
			$( menu ).toggleClass( 'active' );
		} );
		
		$( submenu_toggle ).on( 'click', function() {
			$( this ).closest( '.dh-menu-item' ).find( '.dh-submenu' ).eq(0).slideToggle( 200 );
			$( this ).toggleClass( 'active' );
		} );

		
	};
	
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-page-header.default', DH_Header );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-product-comparition.default', DH_Product_Comparison );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-impact.default', DH_Impact );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-mega-menu.default', DH_Mega_Menu );
	} );






	// elementor.settings.page.addChangeCallback("dh_template", function (newValue) {
	// 	elementor.saver.update.apply().then(function () {
	// 		elementor.reloadPreview();
	// 	});
	// });






} )( jQuery );
