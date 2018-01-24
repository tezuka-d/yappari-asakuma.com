$(window).load(function(){

	function indexOpening1() {
		$.cookie('cookieIndexOpening', 'visited', {
			//expires: 7
		});
		$('#index-content').css({'background':'#fff'});
		$('#index-logo').delay(1000).animate({opacity: '1.0'},{duration: 2000,easing: 'swing', complete: function(){indexOpening2();}});
	}

	function indexOpening2() {
		$('#index-logo').delay(2000).animate({opacity: '0'},{duration: 1500,easing: 'swing', complete: function() {indexOpening3();indexOpening4();}});
	}

	function indexOpening3() {
		$('#index-content').hide();
		$('#TopImg .TopImg__logo').show();
		$('#TopImg .PageScroll').css({'opacity':'1.0'});
		$('#Footer').show();
		$('#GlobalHeader').css({'visibility':'visible'});
		$('#TopImg .TopImg__logo').delay(100).animate({opacity: '1.0'},{duration: 3000, easing: 'swing'});
	}

	function indexOpening4() {
		$('#top .PageBody').delay(100).animate({opacity: '1.0'},{duration: 3000, easing: 'swing'});
		$('#Footer').delay(100).animate({opacity: '1.0'},{duration: 3000, easing: 'swing'});
	}

	if($.cookie('cookieIndexOpening') != 'visited') {
		indexOpening1();
	} else {
		$('#index-content').hide();
		$('#TopImg .TopImg__logo').css({'display':'block','opacity':'1.0'});
		$('#TopImg .PageScroll').css({'opacity':'1.0'});
		$('#top .PageBody').css({'opacity':'1.0'});
		$('#GlobalHeader').css({'visibility':'visible'});
		$('#Footer').css({'display':'block','opacity':'1.0'});
	}

});
