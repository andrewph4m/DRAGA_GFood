// JavaScript Document
jQuery(document).ready(function(e) {
jQuery(window).scroll(function(){
var e=jQuery(window).width();
	if(jQuery(this).scrollTop()>50)
	{	
		jQuery('header .margin-top-bottom-2').css({'margin':'0px 0px'});
	}
	if(jQuery(this).scrollTop()<50)
	{
		jQuery('header .margin-top-bottom-2').css({'margin':'41px 0px 0px 0px'});
	}
	if(jQuery(this).scrollTop()>50)
	{	
		jQuery('header .margin-top-bottom-3').css({'margin':'32px 0px'});
	}
	if(jQuery(this).scrollTop()<50)
	{
		jQuery('header .margin-top-bottom-3').css({'margin':'73px 0px 0px 0px'});
	}
});
jQuery('#hover-cap-4col .thumbnail').hover(
	function(){
	    jQuery(this).find('.caption').slideDown(20); //.fadeIn(250)
	},
	function(){
	    jQuery(this).find('.caption').slideUp(20); //.fadeOut(205)
	}
);    	
var owl = jQuery("#owl-demo");
owl.owlCarousel({
	items : 4,
	itemsMobile : true,
	navigation : false,
	autoHeight : false,
	  responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        400:{
            items:1,
            nav:false
        },
        600:{
            items:2,
            nav:false
        },
        1000:{
            items:4,
            nav:false,
            loop:false
        }
    }
});	
jQuery("#slider4").owlCarousel({
	nav : true, // Show next and prev buttons
	navText: [
	  "<i class='fa fa-angle-left'></i>",
	  "<i class='fa fa-angle-right'></i>"
	],
	slideSpeed : 500,
	paginationSpeed : 500,
	loop : true,
	items : 1,
	autoplay:true, 
	autoplayTimeout:6000,
	autoplayHoverPause:true,
	touchDrag: false,
	mouseDrag: false,
	animateOut: 'fadeOut',
	animateIn: 'fadeIn', 
	dots : false
  });
});

jQuery(window).scroll(function(){
  var sticky = jQuery('#main_header_bg'),
      scroll = jQuery(window).scrollTop();

  if (scroll >= 100) sticky.addClass('fixed');
  else sticky.removeClass('fixed');
}); 