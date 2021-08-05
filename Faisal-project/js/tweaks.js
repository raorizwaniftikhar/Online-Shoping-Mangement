$(document).ready(function(){
	$('#outer').append("<div class='overlayOuter'><div class='overlayContents'><span class='close'>close</span><img src='' alt='' /></div></div>");
	$('#menu li.last').css('border-right','none');
	$('.gallery ul li:last').css('margin-right','0px');
	
	$('.imgOuter').append('<div class="imgOverlay"></div>');
	$('.breadcrumbProducts li:first').addClass('selected');
	$('.breadcrumbProducts li:first .item').css('display','block');
	$('.breadcrumbProducts li').click(function(){
		$('.item').hide();
		$(this).parent().find('.selected').removeClass('selected');
		$(this).find('.item').show();
		$(this).addClass('selected');
	});
	$('.imgOuter').hover(function(){
		$(this).find('.imgOverlay').fadeOut('fast');
	},function(){
		$(this).find('.imgOverlay').fadeIn();
	});
	$('.overlay').click(function(){
		var getSrc = $(this).attr('src');
		$('.overlayOuter img').attr('src',getSrc);
		var getW = $(document).width();
		$('.overlayContents').css('left',getW/3.4);
		//$('body').css('overflow','hidden');
		$('.overlayOuter').show();
	});
	$('.overlayOuter .close').click(function(){
		//$('body').css('overflow','auto');
		$('.overlayOuter').hide();
	});
	
	$('#vertical-ticker').append('<div class="newsOverlayOuter"></div>');
	$('#vertical-ticker li.news').hover(function(){
		var getNews = $(this).find('.fullNews').html();
		$('.newsOverlayOuter').html(getNews);
		$('.newsOverlayOuter').show();
	},function(){
		$('.newsOverlayOuter').html(' ');
		$('.newsOverlayOuter').hide();
	});
	
	$('.openEmail').click(function(){
		var getW = $(document).width();
		$('.emailContents').css('left',getW/3.4);
		//$('body').css('overflow','hidden');
		$('.emailOverlay').show();
	});
	$('.emailOverlay .close').click(function(){
		//$('body').css('overflow','auto');
		$('.emailOverlay').hide();
	});
	
	var thisWidth = 0;
	$('.footerMenu ul li').each(function(){
		 getWidth = $(this).width();
		 thisWidth += getWidth+100;
	});
	$('.footerMenu ul').css('width',thisWidth);
	
	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
});

