

(function($) {

	"use strict";

	/** Menu */
	var toggleButton = $('.toggle-button'),
		menu = $('#navigation'),
		menuItem = $('.main-menu li'),
		header = $('#header'),
		headerStyle = header.attr('data-style'),
		html = $('html'),
		body = $('body');

	// Menu Toggle Button (Hamburger button)
	toggleButton.on('click', function() {

		$(this).toggleClass('button-open');
		menu.toggleClass('show-menu');

		body.toggleClass('menu-open');

        if (body.hasClass('dark-header') && !header.hasClass('scrolling'))
			$(this).toggleClass('toggle-light');

		if ($(this).hasClass('button-open')) {

			/* If header is fixed, make header transparent to not hide menu items */
			if (headerStyle == 'fixed') {
				setTimeout(function() {
					header.addClass('transparent');
				}, 400);
			} else {
				/* Prevent page scrolling */
				html.css({
					'position': 'fixed',
					'width': '100%',
					'overflow-y': 'scroll',
					'margin-top': '0 !important'
				});
			}
		} 
        else {

			resizeHeaderOnScroll();

			if (headerStyle == 'fixed') {
				header.removeClass('transparent');
			} else {
				html.removeAttr('style');
			}
		}

		// Fade in social icons
		$('#navigation .social-sharing').toggleClass('visible');

		// Fade in menu items
		var length = menuItem.length,
			c = 1;

		setInterval(function() {
			if (c <= length) {
				$('.main-menu li:nth-child(' + c + ')').toggleClass('visible');
				c = c + 1;
			}
		}, 70);
    });

	// Popup Menu Drop Down
	$('#navigation li.menu-item-has-children > a').on('click', function(e) {
		$(this).removeAttr('href');
		var element = $(this).parent('li');
		if (element.hasClass('open')) {
			element.removeClass('open');
			element.find('li').removeClass('open');
			element.find('ul').slideUp();
		} else {
			element.addClass('open');
			element.children('ul').slideDown();
			element.siblings('li').children('ul').slideUp();
			element.siblings('li').removeClass('open');
			element.siblings('li').find('li').removeClass('open');
			element.siblings('li').find('ul').slideUp();
		}
	});

	// Standard Menu Drop Down
	$('.menu li').hover(function() {
		$(this).find('ul').first().stop().fadeIn();
	}, function() {
		$(this).find('ul').first().stop().fadeOut();
	});

	/** Resize Header on Scroll */
	var header = $('#header'),
		toggleButton = $('.toggle-button'),
		body = $('body'),
		isDarkHeader = (body.hasClass('dark-header')) ? true : false,
		logo = $('.logo'),
		logoAlt = $('.logo-alt'),
		logoSrc = $('.logo').attr('src'),
		logoAltSrc = $('.logo-alt').attr('src');

	function resizeHeaderOnScroll() {
		const scrollDistance = window.pageYOffset || document.documentElement.scrollTop;

		if (scrollDistance > 80) {
			if (!body.hasClass('menu-open'))
				header.addClass('scrolling');

			if (isDarkHeader) {
				toggleButton.removeClass('toggle-light');

				if (!body.hasClass('menu-open')) {
					logo.attr('src', logoAltSrc);
					logoAlt.attr('src', logoSrc);
				}
			}
		} 
        else {
			if (!body.hasClass('menu-open'))
				header.removeClass('scrolling');

			if (isDarkHeader) {
				if (!toggleButton.hasClass('button-open'))
					toggleButton.addClass('toggle-light');

				if (!body.hasClass('menu-open')) {
					logo.attr('src', logoSrc);
					logoAlt.attr('src', logoAltSrc);
				}
			}
		}
    }
            
})(jQuery);