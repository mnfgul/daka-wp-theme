(function($) {
	$(document).ready( function() {
		
		//$('.dropdown-toggle').dropdown();
		$("a.lightbox").prettyPhoto({ie6_fallback: true, social_tools:false, slideshow: true, show_title: false});
		$(".gallery-item a").prettyPhoto({ie6_fallback: true, social_tools:false, slideshow: true, show_title: false, animation_speed: 'slow', slideshow: 5000});
				
		$('.ttip').tooltip();
		
		$('#topBanner').carousel('cycle').bind('slid', function(){
        	var index = $(this).find(".active").index()+1;
        	var btnId ='#btn'+index;
        	$(".bannerBtn").removeClass("activeThumb");
        	$(btnId).addClass("activeThumb");        	
    	});;
    	
		$("#btn1").click(function(){slidebanner(0); return false;});
		$("#btn2").click(function(){slidebanner(1); return false;});
		$("#btn3").click(function(){slidebanner(2); return false;});
		$("#btn4").click(function(){slidebanner(3); return false;});
		$("#btn5").click(function(){slidebanner(4); return false;});
		$("#btn6").click(function(){slidebanner(5); return false;});
		$("#btn7").click(function(){slidebanner(6); return false;});
		
		//footer animation
		$("#footerLogo").click(function(){
			$('html,body').animate({scrollTop: 5}, 1000);
			return false;
		});
		
		//welcome popup
		$('#welcome').modal({keyboard: false, "backdrop": "static"});
		
	});
	
})(jQuery);

function slidebanner(i)
{
	$('#topBanner').carousel(i);
}
