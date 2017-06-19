/* 
============================================================================================	
*/


/*         01 - HEADER ICO              */		
/*         02 - ENTER PRESS SUBMIT      */
/*         03 - HEADER MAX_HEIGHT       */
/*         04 - POPUPS              	*/


/*
============================================================================================
*/
"use strict";
$(function(){
/*=====================

	01 - HEADER ICO

=======================*/
  var toggles = document.querySelectorAll(".cmn-toggle-switch");

  for (var i = toggles.length - 1; i >= 0; i--) {
    var toggle = toggles[i];
    toggleHandler(toggle);
  };
  function toggleHandler(toggle) {
    toggle.addEventListener( "click", function(e) {
      e.preventDefault();
      (this.classList.contains("active") === true) ? this.classList.remove("active") : this.classList.add("active");
    	$(".header-menu").stop().slideToggle();
    });
  }

 	$(".header-menu i").click(function(){
	  if($(window).width() < 992){ 
		if ( $(this).hasClass("fa-angle-down") ) { 
			$(this).removeClass("fa-angle-down"); 
			$(this).addClass("fa-angle-up") ;
			$(this).parent().find("ul:first").stop().slideToggle();
		}
		else { 
			$(this).removeClass("fa-angle-up"); 
	    	$(this).addClass("fa-angle-down") ;
			$(this).parent().find("ul:first").stop().slideToggle();
	  	}
		}
	})
/*=====================

	04 - POPUPS

=======================*/
	$(".filter-block a").click(function(){
		$(".filter-block li").removeClass("be-active");
		if($(window).width() > 991){ 
			$(".be-popup").fadeOut();
			$(this).parent().find(".be-popup").fadeIn();
		}
		else{
			$(".be-popup").slideUp();
			$(this).parent().find(".be-popup").slideDown();
		}
		$(this).parent().addClass("be-active");
		$(".be-fixed-filter").addClass("active-fixed");
	})
	$(".be-fixed-filter, .be-popup .fa").on("click", function(){
		$(".filter-block li").removeClass("be-active");
		if($(window).width() > 991)
			$(".be-popup").fadeOut();
		else
			$(".be-popup").slideUp();
		$(".be-fixed-filter").removeClass("active-fixed");
	});

	$(".color").on("click", function(){
		$(".color").removeClass("active-color")
		$(this).addClass("active-color");
	})

	$(".be-drop-down").on("click" ,function(){
		$(this).toggleClass("be-dropdown-active");
		$(this).find(".drop-down-list").stop().slideToggle();
	});
	$(".drop-down-list li").on("click", function(){
		var new_value = $(this).find("a").text();
		$(this).parent().parent().find(".be-dropdown-content").text(new_value);
	})
	
	//
	$(document).on('mouseleave', '.be-drop-down.be-dropdown-active', function(){
		$(this).click();
	});

	$(".login_block").on("click",function(){
		$(".large-popup.login").slideToggle();
		return false;
	})

	$(".be-signup-link").on("click", function(){
		$(".large-popup.login").slideDown();
		return false;
	})
	$(".large-popup.login .close-button").on("click", function(){
		$(".large-popup.login").slideUp();
	})

	$(".be-register").on("click",function(){
		$(".large-popup.register").slideDown();
		return false;
	})
	$(".large-popup.register .close-button").on("click", function(){
		$(".large-popup.register").slideUp();
	})

/*================
	05 - LOADER
================*/
	$(window).load(function(){
		$(".be-loader").fadeOut("slow");
	})
// ===================
//06 - SWIPER
//====================
      var swipers= [], initIterator = 0;
      $('.swiper-container').each(function(){   
      var $t = $(this);          
      var index = 'swiper-unique-id-'+initIterator;
      $t.attr('data-init', 'swiper-'+index).addClass('swiper-'+index)
      $t.find('.pagination').addClass('pagination-'+index);
      var loopVar = parseInt($t.attr('data-loop'));
      var slidesP = parseInt($t.attr('data-slides-per-view'));
      var centeredSlidesVar = ($t.closest('.history').length)?1:0;
      swipers['swiper-'+index] = new Swiper('.swiper-'+index,{
          pagination: '.pagination-'+index,
          loop: loopVar,
          effect: 'fade',
          paginationClickable: true,
          slidesPerView: slidesP,
          centeredSlides: centeredSlidesVar,
          onSlideChangeStart: function(swiper){
                var activeIndex = (loopVar===true)?swiper.activeIndex:swiper.activeLoopIndex;
                if($t.closest('.w-banner').length){
                    //alert(activeIndex);
                    $('.banner-navigation').removeClass('active-nav');
                    $('.banner-navigation').eq(activeIndex).addClass('active-nav');
                }
          }
      });
      if(centeredSlidesVar) swipers['swiper-'+index].swipeTo(1,0);
      swipers['swiper-'+index].reInit();
      initIterator++;
    });

	/*================
		07 - ACCORDION
	================*/
	$('.accordion').each(function(){
		$(this).find('.acc-title').on("click", function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$(this).siblings('.acc-body').slideUp();
			} else{
				$(this).closest('.accordion').find('.active').removeClass('active');
				$(this).closest('.accordion').find('.acc-body').slideUp('slow');
				$(this).toggleClass('active');
				$(this).siblings('.acc-body').slideToggle('slow');
			}
		});
	});
})


