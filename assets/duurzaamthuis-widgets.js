( function( $ ) {

	$.fn.theiaStickySidebar=function(i){function t(i,t){return!0===i.initialized||!($("body").width()<i.minWidth)&&(function(i,t){i.initialized=!0,0===$("#theia-sticky-sidebar-stylesheet-"+i.namespace).length&&$("head").append($('<style id="theia-sticky-sidebar-stylesheet-'+i.namespace+'">.theiaStickySidebar:after {content: ""; display: table; clear: both;}</style>'));t.each(function(){var t={};if(t.sidebar=$(this),t.options=i||{},t.container=$(t.options.containerSelector),0==t.container.length&&(t.container=t.sidebar.parent()),t.sidebar.parents().css("-webkit-transform","none"),t.sidebar.css({position:t.options.defaultPosition,overflow:"visible","-webkit-box-sizing":"border-box","-moz-box-sizing":"border-box","box-sizing":"border-box"}),t.stickySidebar=t.sidebar.find(".theiaStickySidebar"),0==t.stickySidebar.length){var o=/(?:text|application)\/(?:x-)?(?:javascript|ecmascript)/i;t.sidebar.find("script").filter(function(i,t){return 0===t.type.length||t.type.match(o)}).remove(),t.stickySidebar=$("<div>").addClass("theiaStickySidebar").append(t.sidebar.children()),t.sidebar.append(t.stickySidebar)}t.marginBottom=parseInt(t.sidebar.css("margin-bottom")),t.paddingTop=parseInt(t.sidebar.css("padding-top")),t.paddingBottom=parseInt(t.sidebar.css("padding-bottom"));var a=t.stickySidebar.offset().top,n=t.stickySidebar.outerHeight();function s(){t.fixedScrollTop=0,t.sidebar.css({"min-height":"1px"}),t.stickySidebar.css({position:"static",width:"",transform:"none"})}t.stickySidebar.css("padding-top",1),t.stickySidebar.css("padding-bottom",1),a-=t.stickySidebar.offset().top,n=t.stickySidebar.outerHeight()-n-a,0==a?(t.stickySidebar.css("padding-top",0),t.stickySidebarPaddingTop=0):t.stickySidebarPaddingTop=1,0==n?(t.stickySidebar.css("padding-bottom",0),t.stickySidebarPaddingBottom=0):t.stickySidebarPaddingBottom=1,t.previousScrollTop=null,t.fixedScrollTop=0,s(),t.onScroll=function(t){if(t.stickySidebar.is(":visible"))if($("body").width()<t.options.minWidth)s();else{if(t.options.disableOnResponsiveLayouts){var o=t.sidebar.outerWidth("none"==t.sidebar.css("float"));if(o+50>t.container.width())return void s()}var a,n,d=$(document).scrollTop(),r="static";if(d>=t.sidebar.offset().top+(t.paddingTop-t.options.additionalMarginTop)){var c,p=t.paddingTop+i.additionalMarginTop,b=t.paddingBottom+t.marginBottom+i.additionalMarginBottom,l=t.sidebar.offset().top,f=t.sidebar.offset().top+(a=t.container,n=a.height(),a.children().each(function(){n=Math.max(n,$(this).height())}),n),h=0+i.additionalMarginTop,g=t.stickySidebar.outerHeight()+p+b<$(window).height();c=g?h+t.stickySidebar.outerHeight():$(window).height()-t.marginBottom-t.paddingBottom-i.additionalMarginBottom;var S=l-d+t.paddingTop,u=f-d-t.paddingBottom-t.marginBottom,m=t.stickySidebar.offset().top-d,y=t.previousScrollTop-d;"fixed"==t.stickySidebar.css("position")&&"modern"==t.options.sidebarBehavior&&(m+=y),"stick-to-top"==t.options.sidebarBehavior&&(m=i.additionalMarginTop),"stick-to-bottom"==t.options.sidebarBehavior&&(m=c-t.stickySidebar.outerHeight()),m=y>0?Math.min(m,h):Math.max(m,c-t.stickySidebar.outerHeight()),m=Math.max(m,S),m=Math.min(m,u-t.stickySidebar.outerHeight());var k=t.container.height()==t.stickySidebar.outerHeight();r=(k||m!=h)&&(k||m!=c-t.stickySidebar.outerHeight())?d+m-t.sidebar.offset().top-t.paddingTop<=i.additionalMarginTop?"static":"absolute":"fixed"}if("fixed"==r){var v=$(document).scrollLeft();t.stickySidebar.css({position:"fixed",width:e(t.stickySidebar)+"px",transform:"translateY("+m+"px)",left:t.sidebar.offset().left+parseInt(t.sidebar.css("padding-left"))-v+"px",top:"0px"})}else if("absolute"==r){var x={};"absolute"!=t.stickySidebar.css("position")&&(x.position="absolute",x.transform="translateY("+(d+m-t.sidebar.offset().top-t.stickySidebarPaddingTop-t.stickySidebarPaddingBottom)+"px)",x.top="0px"),x.width=e(t.stickySidebar)+"px",x.left="",t.stickySidebar.css(x)}else"static"==r&&s();"static"!=r&&1==t.options.updateSidebarHeight&&t.sidebar.css({"min-height":t.stickySidebar.outerHeight()+t.stickySidebar.offset().top-t.sidebar.offset().top+t.paddingBottom}),t.previousScrollTop=d}},t.onScroll(t),$(document).on("scroll."+t.options.namespace,function(i){return function(){i.onScroll(i)}}(t)),$(window).on("resize."+t.options.namespace,function(i){return function(){i.stickySidebar.css({position:"static"}),i.onScroll(i)}}(t)),"undefined"!=typeof ResizeSensor&&new ResizeSensor(t.stickySidebar[0],function(i){return function(){i.onScroll(i)}}(t))})}(i,t),!0)}function e(i){var t;try{t=i[0].getBoundingClientRect().width}catch(i){}return void 0===t&&(t=i.width()),t}return(i=$.extend({containerSelector:"",additionalMarginTop:0,additionalMarginBottom:0,updateSidebarHeight:!0,minWidth:0,disableOnResponsiveLayouts:!0,sidebarBehavior:"modern",defaultPosition:"relative",namespace:"TSS"},i)).additionalMarginTop=parseInt(i.additionalMarginTop)||0,i.additionalMarginBottom=parseInt(i.additionalMarginBottom)||0,function(i,e){t(i,e)||(console.log("TSS: Body width smaller than options.minWidth. Init is delayed."),$(document).on("scroll."+i.namespace,function(i,e){return function(o){var a=t(i,e);a&&$(this).unbind(o)}}(i,e)),$(window).on("resize."+i.namespace,function(i,e){return function(o){var a=t(i,e);a&&$(this).unbind(o)}}(i,e)))}(i,this),this};






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




	var DH_Page_Navigation = function( $scope, $ ) {
		$scope.find( '.dh-subpages-toggle' ).on( 'click', function() {
			$( this ).closest( 'li' ).toggleClass( 'dh-opened' );
			$( this ).closest( 'li' ).find( '> ul' ).slideToggle( 300 );
		} );

	}

	var DH_Menu_Tree_Navigation = function( $scope, $ ) {
		$scope.find( '.dh-subpages-toggle' ).on( 'click', function() {
			$( this ).closest( 'li' ).toggleClass( 'dh-opened' );
			$( this ).closest( 'li' ).find( '> ul' ).slideToggle( 300 );
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
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-page-navigation.default', DH_Page_Navigation );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/dh-menu-tree-navigation.default', DH_Menu_Tree_Navigation );
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
		var topOffset = 100;
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










