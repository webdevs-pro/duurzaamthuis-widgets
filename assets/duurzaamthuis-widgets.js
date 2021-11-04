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
		
	}

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
	}


	var DH_Impact = function( $scope, $ ) {

		var toggle = $scope.find('.dh-impact-calc-toggle');
		var content = $scope.find('.dh-impact-calc-text');

		$(toggle).on('click', function(){
			$(toggle).toggleClass('active');
			$(content).slideToggle(300);
		})
		
	}


	var DH_Mega_Menu = function( $scope, $ ) {

		var toggle = $scope.find( '.dh-mobile-menu-toggle' );
		var menu = $scope.find( '.dh-mobile-menu' );
		var submenu_toggle = $scope.find( '.dh-mobile-submenu-toggle' );

		$( toggle ).on( 'click', function() {
			$( menu ).toggleClass( 'active' );
		} );
		
		$( submenu_toggle ).on( 'click', function() {
			$( this ).closest( '.dh-menu-item' ).find( '.dh-submenu' ).eq(0).slideToggle( 200 );
			$( this ).toggleClass( 'active' );
		} );

		function setMobileMenuPosition() {
			$( menu ).css({
				'left': - $scope.offset().left,
			});
		}
		
		setMobileMenuPosition();
		
		$( window ).on( 'resize', function() {
			setMobileMenuPosition();
		} );

	}


	var DH_Product_Comparition_Sustainability_Score = function( $scope, $ ) {

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


		var products = $scope.find( '.dh-product' );


		$( products ).each( function() {
			var last_updated = $( this ).find( '.dfrcs_last_updated' ).text();
		} );
		

	}



	
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-page-header.default', DH_Header );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-product-comparition.default', DH_Product_Comparison );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-impact.default', DH_Impact );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-mega-menu.default', DH_Mega_Menu );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-product-comparition-sustainability-score.default', DH_Product_Comparition_Sustainability_Score );
		initDHtooltips();
	} );






	// elementor.settings.page.addChangeCallback("dh_template", function (newValue) {
	// 	elementor.saver.update.apply().then(function () {
	// 		elementor.reloadPreview();
	// 	});
	// });













	function initDHtooltips() {
		// tolltips
		$( document ).on( 'mouseenter', '[data-dh-tooltip]', function() {

			clearTimeout( $( this ).data( 'dh-tooltip-timeout-id' ) );

			var prevTooltip = $( this ).find( '.tooltip' );
			if ( prevTooltip.length > 0 ) return false;

			$( this ).append( '<div class="tooltip"><div class="tooltip-wrapper"><span>' + $( this ).data( 'dh-tooltip' ) + '</span></div><div class="tooltip-trangle"></div></div>' );
			var tooltip = $( this ).find( '.tooltip' );
			var innerWidth = getInnerWidth( $( tooltip ).find( '.tooltip-wrapper > span' )[0] ) + 21;

			$( tooltip ).find( '.tooltip-wrapper' ).css({ 
				'width': innerWidth
			});

			var overflow = tooltip.offset().left + tooltip.width() - $( window ).width();
			if( overflow > 0 ) {
				var pos = overflow + 10;
				$( tooltip ).find( '.tooltip-wrapper' ).css({ 
					'transform': 'translateX(-' + pos + 'px)'
				});
			}

		});
		$( document ).on( 'mouseleave', '[data-dh-tooltip]', function() {
			var element = $( this );
			var timeoutId = setTimeout( function() {
				element.find( '.tooltip' ).css( 'animation', 'none' ).fadeOut( 200, function() {
					$( this ).remove();
				} );
			}, 200 );
			element.data( 'dh-tooltip-timeout-id', timeoutId ); 
		});

		function getInnerWidth(element) {
			var wrapper = document.createElement('span'),
				result;
			while ( element.firstChild ) {
				wrapper.appendChild( element.firstChild );
			}
			element.appendChild( wrapper );
			result = wrapper.offsetWidth;
			element.removeChild( wrapper );
			while ( wrapper.firstChild ) {
				element.appendChild( wrapper.firstChild );
			}
			return result;
		}
	}








} )( jQuery );
