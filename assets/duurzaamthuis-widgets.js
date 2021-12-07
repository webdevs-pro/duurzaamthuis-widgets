( function( $ ) {


	// var sidebar = new StickySidebar('.dh-sticky-sidebar', {
	// 	topSpacing: 20,
	//  });

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


	var DH_Product_Review = function( $scope, $ ) {
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


	var DH_Company_Offer = function( $scope, $ ) {
		var form_id = $scope.find( '.dh-widget-dh-company-offer' ).data( 'form-id' );
		var max_checked = $scope.find( '.dh-widget-dh-company-offer' ).data( 'max-companies' );
		var empty_text = 'Selecteer minimaal 1 bedrijf';

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
					$(parent).css('height', content_height + 22);
					$(this).hide();
					$(close).show();
				});
				$(close).on('click', function() {
					$(parent).css('max-height', height);
					$(parent).css('height', '');
					setTimeout(function(){
						$(this).hide();
						$(open).show();
					}, 150);
				});
			}
		});



		$( '#' + form_id + ' [type="dh-companies-offer-emails"]' ).val( '' );
		$( '#' + form_id + ' [type="dh-companies-offer-titles"]' ).val( '' );

		var selected = $scope.find( '.dh-product[data-selected="yes"]' );
		$( selected ).each( function( index ) {
			var _this = this;
			setTimeout( function() {
				var target = $( _this ).find( '.dh-product-checkbox-button' );
				$( target ).click();
			}, 100 );
		} );

		$scope.find( '.dh-product-checkbox-button' ).on( 'click', function() {
			if ( $( this ).hasClass( 'active' ) ) {
				$( this ).toggleClass( 'checked' );
			}

			var checked_buttons = $scope.find( '.dh-product-checkbox-button.checked' );
			if ( checked_buttons.length >= max_checked ) {
				$scope.find( '.dh-product-checkbox-button.active:not(.checked)' ).removeClass( 'active' );
			} else {
				$scope.find( '.dh-product-checkbox-button' ).addClass( 'active' );
			}

			var emails = [];
			var titles = [];
			$( checked_buttons ).each( function() {
				emails.push( $( this ).data( 'email' ) );
				titles.push( $( this ).closest( '.dh-product' ).find( '.dh-heading' ).text() );
			} );

			$( '#' + form_id + ' [type="dh-companies-offer-emails"]' ).val( emails.join(',') );
			$( '#' + form_id + ' [type="dh-companies-offer-titles"]' ).val( titles.join(', ') );

			
			if ( titles.length ) {
				$( '#' + form_id + ' .dh-selected-companies-badges' ).html('');
				$.each( titles, function( key, title ) {
					$( '#' + form_id + ' .dh-selected-companies-badges' ).append( '<span class="dh-selected-company-badge">' + title + '</span>' );
				} );
			}
		} );

		$( document ).on('submit_success', '#' + form_id + '', function() {
			$scope.find( '.dh-product-checkbox-button' ).addClass( 'active' ).removeClass( 'checked' );
			$( '#' + form_id + ' .dh-selected-companies-badges' ).remove();
		} );

		$scope.find( '.dh-product-checkbox-scroll-to-form' ).on( 'click', function() {
			if ( $( '#' + form_id ).length == 0 ) return false;
			$( 'html, body' ).animate( {
				scrollTop: $( '#' + form_id ).offset().top - 250
			}, 700, 'swing' );
		} );

	}



	
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-page-header.default', DH_Header );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-product-comparition.default', DH_Product_Comparison );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-impact.default', DH_Impact );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-mega-menu.default', DH_Mega_Menu );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-product-comparition-sustainability-score.default', DH_Product_Comparition_Sustainability_Score );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-product-review.default', DH_Product_Review );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-company-offer.default', DH_Company_Offer );
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







	// sticky column
	var sticky_column = $( '.elementor-column[data-settings*="dh_sticky_column"] > .elementor-widget-wrap' );
	if ( sticky_column.length ) {
		var adminBar = $('#wpadminbar');
		var topOffset = 0;
		if ( adminBar.length) {
			topOffset = 32 + topOffset;
		}
		$( sticky_column ).theiaStickySidebar( {
			containerSelector: $( sticky_column ).closest( '.elementor-section' ),
			additionalMarginTop: topOffset,
			minWidth: 1025
		} );
	}




} )( jQuery );











(function ($) {
	$.fn.theiaStickySidebar = function (options) {
		 var defaults = {
			  'containerSelector': '',
			  'additionalMarginTop': 0,
			  'additionalMarginBottom': 0,
			  'updateSidebarHeight': true,
			  'minWidth': 0,
			  'disableOnResponsiveLayouts': true,
			  'sidebarBehavior': 'modern',
			  'defaultPosition': 'relative',
			  'namespace': 'TSS'
		 };
		 options = $.extend(defaults, options);

		 // Validate options
		 options.additionalMarginTop = parseInt(options.additionalMarginTop) || 0;
		 options.additionalMarginBottom = parseInt(options.additionalMarginBottom) || 0;

		 tryInitOrHookIntoEvents(options, this);

		 // Try doing init, otherwise hook into window.resize and document.scroll and try again then.
		 function tryInitOrHookIntoEvents(options, $that) {
			  var success = tryInit(options, $that);

			  if (!success) {
					console.log('TSS: Body width smaller than options.minWidth. Init is delayed.');

					$(document).on('scroll.' + options.namespace, function (options, $that) {
						 return function (evt) {
							  var success = tryInit(options, $that);

							  if (success) {
									$(this).unbind(evt);
							  }
						 };
					}(options, $that));
					$(window).on('resize.' + options.namespace, function (options, $that) {
						 return function (evt) {
							  var success = tryInit(options, $that);

							  if (success) {
									$(this).unbind(evt);
							  }
						 };
					}(options, $that))
			  }
		 }

		 // Try doing init if proper conditions are met.
		 function tryInit(options, $that) {
			  if (options.initialized === true) {
					return true;
			  }

			  if ($('body').width() < options.minWidth) {
					return false;
			  }

			  init(options, $that);

			  return true;
		 }

		 // Init the sticky sidebar(s).
		 function init(options, $that) {
			  options.initialized = true;

			  // Add CSS
			  var existingStylesheet = $('#theia-sticky-sidebar-stylesheet-' + options.namespace);
			  if (existingStylesheet.length === 0) {
					$('head').append($('<style id="theia-sticky-sidebar-stylesheet-' + options.namespace + '">.theiaStickySidebar:after {content: ""; display: table; clear: both;}</style>'));
			  }

			  $that.each(function () {
					var o = {};

					o.sidebar = $(this);

					// Save options
					o.options = options || {};

					// Get container
					o.container = $(o.options.containerSelector);
					if (o.container.length == 0) {
						 o.container = o.sidebar.parent();
					}

					// Create sticky sidebar
					o.sidebar.parents().css('-webkit-transform', 'none'); // Fix for WebKit bug - https://code.google.com/p/chromium/issues/detail?id=20574
					o.sidebar.css({
						 'position': o.options.defaultPosition,
						 'overflow': 'visible',
						 // The "box-sizing" must be set to "content-box" because we set a fixed height to this element when the sticky sidebar has a fixed position.
						 '-webkit-box-sizing': 'border-box',
						 '-moz-box-sizing': 'border-box',
						 'box-sizing': 'border-box'
					});

					// Get the sticky sidebar element. If none has been found, then create one.
					o.stickySidebar = o.sidebar.find('.theiaStickySidebar');
					if (o.stickySidebar.length == 0) {
						 // Remove <script> tags, otherwise they will be run again when added to the stickySidebar.
						 var javaScriptMIMETypes = /(?:text|application)\/(?:x-)?(?:javascript|ecmascript)/i;
						 o.sidebar.find('script').filter(function (index, script) {
							  return script.type.length === 0 || script.type.match(javaScriptMIMETypes);
						 }).remove();

						 o.stickySidebar = $('<div>').addClass('theiaStickySidebar').append(o.sidebar.children());
						 o.sidebar.append(o.stickySidebar);
					}

					// Get existing top and bottom margins and paddings
					o.marginBottom = parseInt(o.sidebar.css('margin-bottom'));
					o.paddingTop = parseInt(o.sidebar.css('padding-top'));
					o.paddingBottom = parseInt(o.sidebar.css('padding-bottom'));

					// Add a temporary padding rule to check for collapsable margins.
					var collapsedTopHeight = o.stickySidebar.offset().top;
					var collapsedBottomHeight = o.stickySidebar.outerHeight();
					o.stickySidebar.css('padding-top', 1);
					o.stickySidebar.css('padding-bottom', 1);
					collapsedTopHeight -= o.stickySidebar.offset().top;
					collapsedBottomHeight = o.stickySidebar.outerHeight() - collapsedBottomHeight - collapsedTopHeight;
					if (collapsedTopHeight == 0) {
						 o.stickySidebar.css('padding-top', 0);
						 o.stickySidebarPaddingTop = 0;
					}
					else {
						 o.stickySidebarPaddingTop = 1;
					}

					if (collapsedBottomHeight == 0) {
						 o.stickySidebar.css('padding-bottom', 0);
						 o.stickySidebarPaddingBottom = 0;
					}
					else {
						 o.stickySidebarPaddingBottom = 1;
					}

					// We use this to know whether the user is scrolling up or down.
					o.previousScrollTop = null;

					// Scroll top (value) when the sidebar has fixed position.
					o.fixedScrollTop = 0;

					// Set sidebar to default values.
					resetSidebar();

					o.onScroll = function (o) {
						 // Stop if the sidebar isn't visible.
						 if (!o.stickySidebar.is(":visible")) {
							  return;
						 }

						 // Stop if the window is too small.
						 if ($('body').width() < o.options.minWidth) {
							  resetSidebar();
							  return;
						 }

						 // Stop if the sidebar width is larger than the container width (e.g. the theme is responsive and the sidebar is now below the content)
						 if (o.options.disableOnResponsiveLayouts) {
							  var sidebarWidth = o.sidebar.outerWidth(o.sidebar.css('float') == 'none');

							  if (sidebarWidth + 50 > o.container.width()) {
									resetSidebar();
									return;
							  }
						 }

						 var scrollTop = $(document).scrollTop();
						 var position = 'static';

						 // If the user has scrolled down enough for the sidebar to be clipped at the top, then we can consider changing its position.
						 if (scrollTop >= o.sidebar.offset().top + (o.paddingTop - o.options.additionalMarginTop)) {
							  // The top and bottom offsets, used in various calculations.
							  var offsetTop = o.paddingTop + options.additionalMarginTop;
							  var offsetBottom = o.paddingBottom + o.marginBottom + options.additionalMarginBottom;

							  // All top and bottom positions are relative to the window, not to the parent elemnts.
							  var containerTop = o.sidebar.offset().top;
							  var containerBottom = o.sidebar.offset().top + getClearedHeight(o.container);

							  // The top and bottom offsets relative to the window screen top (zero) and bottom (window height).
							  var windowOffsetTop = 0 + options.additionalMarginTop;
							  var windowOffsetBottom;

							  var sidebarSmallerThanWindow = (o.stickySidebar.outerHeight() + offsetTop + offsetBottom) < $(window).height();
							  if (sidebarSmallerThanWindow) {
									windowOffsetBottom = windowOffsetTop + o.stickySidebar.outerHeight();
							  }
							  else {
									windowOffsetBottom = $(window).height() - o.marginBottom - o.paddingBottom - options.additionalMarginBottom;
							  }

							  var staticLimitTop = containerTop - scrollTop + o.paddingTop;
							  var staticLimitBottom = containerBottom - scrollTop - o.paddingBottom - o.marginBottom;

							  var top = o.stickySidebar.offset().top - scrollTop;
							  var scrollTopDiff = o.previousScrollTop - scrollTop;

							  // If the sidebar position is fixed, then it won't move up or down by itself. So, we manually adjust the top coordinate.
							  if (o.stickySidebar.css('position') == 'fixed') {
									if (o.options.sidebarBehavior == 'modern') {
										 top += scrollTopDiff;
									}
							  }

							  if (o.options.sidebarBehavior == 'stick-to-top') {
									top = options.additionalMarginTop;
							  }

							  if (o.options.sidebarBehavior == 'stick-to-bottom') {
									top = windowOffsetBottom - o.stickySidebar.outerHeight();
							  }

							  if (scrollTopDiff > 0) { // If the user is scrolling up.
									top = Math.min(top, windowOffsetTop);
							  }
							  else { // If the user is scrolling down.
									top = Math.max(top, windowOffsetBottom - o.stickySidebar.outerHeight());
							  }

							  top = Math.max(top, staticLimitTop);

							  top = Math.min(top, staticLimitBottom - o.stickySidebar.outerHeight());

							  // If the sidebar is the same height as the container, we won't use fixed positioning.
							  var sidebarSameHeightAsContainer = o.container.height() == o.stickySidebar.outerHeight();

							  if (!sidebarSameHeightAsContainer && top == windowOffsetTop) {
									position = 'fixed';
							  }
							  else if (!sidebarSameHeightAsContainer && top == windowOffsetBottom - o.stickySidebar.outerHeight()) {
									position = 'fixed';
							  }
							  else if (scrollTop + top - o.sidebar.offset().top - o.paddingTop <= options.additionalMarginTop) {
									// Stuck to the top of the page. No special behavior.
									position = 'static';
							  }
							  else {
									// Stuck to the bottom of the page.
									position = 'absolute';
							  }
						 }

						 /*
						  * Performance notice: It's OK to set these CSS values at each resize/scroll, even if they don't change.
						  * It's way slower to first check if the values have changed.
						  */
						 if (position == 'fixed') {
							  var scrollLeft = $(document).scrollLeft();

							  o.stickySidebar.css({
									'position': 'fixed',
									'width': getWidthForObject(o.stickySidebar) + 'px',
									'transform': 'translateY(' + top + 'px)',
									'left': (o.sidebar.offset().left + parseInt(o.sidebar.css('padding-left')) - scrollLeft) + 'px',
									'top': '0px'
							  });
						 }
						 else if (position == 'absolute') {
							  var css = {};

							  if (o.stickySidebar.css('position') != 'absolute') {
									css.position = 'absolute';
									css.transform = 'translateY(' + (scrollTop + top - o.sidebar.offset().top - o.stickySidebarPaddingTop - o.stickySidebarPaddingBottom) + 'px)';
									css.top = '0px';
							  }

							  css.width = getWidthForObject(o.stickySidebar) + 'px';
							  css.left = '';

							  o.stickySidebar.css(css);
						 }
						 else if (position == 'static') {
							  resetSidebar();
						 }

						 if (position != 'static') {
							  if (o.options.updateSidebarHeight == true) {
									o.sidebar.css({
										 'min-height': o.stickySidebar.outerHeight() + o.stickySidebar.offset().top - o.sidebar.offset().top + o.paddingBottom
									});
							  }
						 }

						 o.previousScrollTop = scrollTop;
					};

					// Initialize the sidebar's position.
					o.onScroll(o);

					// Recalculate the sidebar's position on every scroll and resize.
					$(document).on('scroll.' + o.options.namespace, function (o) {
						 return function () {
							  o.onScroll(o);
						 };
					}(o));
					$(window).on('resize.' + o.options.namespace, function (o) {
						 return function () {
							  o.stickySidebar.css({'position': 'static'});
							  o.onScroll(o);
						 };
					}(o));

					// Recalculate the sidebar's position every time the sidebar changes its size.
					if (typeof ResizeSensor !== 'undefined') {
						 new ResizeSensor(o.stickySidebar[0], function (o) {
							  return function () {
									o.onScroll(o);
							  };
						 }(o));
					}

					// Reset the sidebar to its default state
					function resetSidebar() {
						 o.fixedScrollTop = 0;
						 o.sidebar.css({
							  'min-height': '1px'
						 });
						 o.stickySidebar.css({
							  'position': 'static',
							  'width': '',
							  'transform': 'none'
						 });
					}

					// Get the height of a div as if its floated children were cleared. Note that this function fails if the floats are more than one level deep.
					function getClearedHeight(e) {
						 var height = e.height();

						 e.children().each(function () {
							  height = Math.max(height, $(this).height());
						 });

						 return height;
					}
			  });
		 }

		 function getWidthForObject(object) {
			  var width;

			  try {
					width = object[0].getBoundingClientRect().width;
			  }
			  catch (err) {
			  }

			  if (typeof width === "undefined") {
					width = object.width();
			  }

			  return width;
		 }

		 return this;
	}
})(jQuery);