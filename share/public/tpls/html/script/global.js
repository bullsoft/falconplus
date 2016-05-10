/*-------------------------------------------------------------------------------------------------------------------------------*/
/*This is main JS file that contains custom style rules used in this template*/
/*-------------------------------------------------------------------------------------------------------------------------------*/
/* Template Name: Site Title*/
/* Version: 1.0 Initial Release*/
/* Build Date: 22-04-2015*/
/* Author: Unbranded*/
/* Website: http://moonart.net.ua/site/ 
/* Copyright: (C) 2015 */
/*-------------------------------------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------*/
/* TABLE OF CONTENTS: */
/*--------------------------------------------------------*/
/* 01 - VARIABLES */
/* 02 - page calculations */
/* 03 - function on document ready */
/* 04 - function on page load */
/* 05 - function on page resize */
/* 06 - swiper sliders */
/* 07 - buttons, clicks, hovers */
/*-------------------------------------------------------------------------------------------------------------------------------*/

$(function() {

	"use strict";

	/*================*/
	/* 01 - VARIABLES */
	/*================*/
	var swipers = [], winW, winH, winScr, _isresponsive, smPoint = 768, mdPoint = 992, lgPoint = 1200, addPoint = 1600, _ismobile = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i);

	/*========================*/
	/* 02 - page calculations */
	/*========================*/
	function pageCalculations(){
		winW = $(window).width();
		winH = $(window).height();
		if($('.menu-button').is(':visible')) _isresponsive = true;
		else _isresponsive = false;
		if(winW <= 992)
			$(".header-menu").css({"max-height":winH - 20 +  "px"});
	}

	/*=================================*/
	/* 03 - function on document ready */
	/*=================================*/
	pageCalculations();

	//center all images inside containers
	$('.center-image').each(function(){
		var bgSrc = $(this).attr('src');
		$(this).parent().addClass('background-block').css({'background-image':'url('+bgSrc+')'});
		$(this).hide();
	});		

	/*============================*/
	/* 04 - function on page load */
	/*============================*/
	$(window).load(function(){
		$(".be-loader").fadeOut("slow");
		initSwiper();
		notification();
		$('.isotope-grid').isotope({
			itemSelector: '.isotope-item ',
			percentPosition: true
		});		
	});

	/*==============================*/
	/* 05 - function on page resize */
	/*==============================*/
	$(window).resize(function(){
			resizeCall();
			notification();
	});

	function resizeCall(){
		pageCalculations();
		
		$('.swiper-container.initialized[data-slides-per-view="responsive"]').each(function(){
			var thisSwiper = swipers['swiper-'+$(this).attr('id')], $t = $(this), slidesPerViewVar = updateSlidesPerView($t);
			thisSwiper.params.slidesPerView = slidesPerViewVar;
			thisSwiper.reInit();
			var paginationSpan = $t.find('.pagination span');
			var paginationSlice = paginationSpan.hide().slice(0,(paginationSpan.length+1-slidesPerViewVar));
			if(paginationSlice.length<=1 || slidesPerViewVar>=$t.find('.swiper-slide').length) $t.addClass('pagination-hidden');
			else $t.removeClass('pagination-hidden');
			paginationSlice.show();
			updateSlidesPerView(this);
		});
			var a = $(window).height() - 70;
			$("#one").css("max-height",a + "px");
	}

	/*=====================*/
	/* 06 - swiper sliders */
	/*=====================*/
	function initSwiper(){
		var initIterator = 0;
		$('.swiper-container').each(function(){								  
			var $t = $(this);								  

			var index = 'swiper-unique-id-'+initIterator;

			$t.addClass('swiper-'+index + ' initialized').attr('id', index);
			$t.find('.pagination').addClass('pagination-'+index);

			var autoPlayVar = parseInt($t.attr('data-autoplay'));
			var centerVar = parseInt($t.attr('data-center'));
			var simVar = ($t.closest('.circle-description-slide-box').length)?false:true;

			var slidesPerViewVar = $t.attr('data-slides-per-view');
			if(slidesPerViewVar == 'responsive'){
				slidesPerViewVar = updateSlidesPerView($t);
			}
			else slidesPerViewVar = parseInt(slidesPerViewVar);

			var loopVar = parseInt($t.attr('data-loop'));
			var speedVar = parseInt($t.attr('data-speed'));

			var slidesPerGroup = parseInt($t.attr('data-slides-per-group'));
			if(!slidesPerGroup){slidesPerGroup=1;}			

			swipers['swiper-'+index] = new Swiper('.swiper-'+index,{
				speed: speedVar,
				pagination: '.pagination-'+index,
				loop: loopVar,
				paginationClickable: true,
				autoplay: autoPlayVar,
				slidesPerView: slidesPerViewVar,
				slidesPerGroup: slidesPerGroup,
				keyboardControl: true,
				calculateHeight: true, 
				simulateTouch: simVar,
				centeredSlides: centerVar,
				roundLengths: true,
				onSlideChangeEnd: function(swiper){
					var activeIndex = (loopVar===1)?swiper.activeLoopIndex:swiper.activeIndex;
					var qVal = $t.find('.swiper-slide-active').attr('data-val');
					$t.find('.swiper-slide[data-val="'+qVal+'"]').addClass('active');
				},
				onSlideChangeStart: function(swiper){
					$t.find('.swiper-slide.active').removeClass('active');
					if($t.hasClass('thumbnails-preview')){
						var activeIndex = (loopVar===1)?swiper.activeLoopIndex:swiper.activeIndex;
						swipers['swiper-'+$t.next().attr('id')].swipeTo(activeIndex);
						$t.next().find('.current').removeClass('current');
						$t.next().find('.swiper-slide[data-val="'+activeIndex+'"]').addClass('current');
					}
				},
				onSlideClick: function(swiper){
					if($t.hasClass('thumbnails')) {
						swipers['swiper-'+$t.prev().attr('id')].swipeTo(swiper.clickedSlideIndex);
					}
				},
				onResize: function(swiper){
					var browserWidthResize2 = $(window).width();
					if (browserWidthResize2 < 750) {
							swiper.params.slidesPerGroup=1;
					} else { 
                      swiper.params.slidesPerGroup=slidesPerGroup;
					  swiper.resizeFix(true);
					}					
				}				
			});
			swipers['swiper-'+index].reInit();
			if($t.attr('data-slides-per-view')=='responsive'){
				var paginationSpan = $t.find('.pagination span');
				var paginationSlice = paginationSpan.hide().slice(0,(paginationSpan.length+1-slidesPerViewVar));
				if(paginationSlice.length<=1 || slidesPerViewVar>=$t.find('.swiper-slide').length) $t.addClass('pagination-hidden');
				else $t.removeClass('pagination-hidden');
				paginationSlice.show();
			}
			initIterator++;
		});

	}

	function updateSlidesPerView(swiperContainer){
		if(winW>=addPoint) return parseInt($(swiperContainer).attr('data-add-slides'));
		else if(winW>=lgPoint) return parseInt($(swiperContainer).attr('data-lg-slides'));
		else if(winW>=mdPoint) return parseInt($(swiperContainer).attr('data-md-slides'));
		else if(winW>=smPoint) return parseInt($(swiperContainer).attr('data-sm-slides'));
		else return parseInt($(swiperContainer).attr('data-xs-slides'));
		// else return 0;
	}

	//swiper arrows
	$('.swiper-arrow-left.be-out').click(function(){
		swipers['swiper-'+$(this).parent().parent().find(".swiper-container").attr('id')].swipePrev();
		return false;
	});

	$('.swiper-arrow-right.be-out').click(function(){
		swipers['swiper-'+$(this).parent().parent().find(".swiper-container").attr('id')].swipeNext();
		return false;
	});

	$('.swiper-arrow-left').click(function(){
		if(!$(this).hasClass("be-out")) swipers['swiper-'+$(this).parent().attr('id')].swipePrev();
	});

	$('.swiper-arrow-right').click(function(){
		if(!$(this).hasClass("be-out")) swipers['swiper-'+$(this).parent().attr('id')].swipeNext();
	});

	/*==============================*/
	/* 07 - buttons, clicks, hovers */
	/*==============================*/

	// central images background
	$('.be-center-image').each(function(){
		var bgSrc = $(this).attr('src');
		$(this).parent().css({'background-image':'url('+bgSrc+')'});
		$(this).hide();
	});

	// top menu
	$(".cmn-toggle-switch").on("click", function(){
		if ($(this).hasClass("active")){
			$(this).removeClass("active");
			$('body').removeClass('menu-open')
		} else{
			$(this).addClass("active");
			$('body').addClass('menu-open')
		}
		$(".header-menu").stop().slideToggle();
		$(".large-popup").slideUp();
		return false;
	});

 	$(".header-menu i").on("click", function(){
	  if($(window).width() < 1200){ 
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
	});


	$(".filter-block a").on("click", function(){
		$(".filter-block li").removeClass("be-active");
		if($(window).width() > 1199){ 
			$(".be-popup").fadeOut();
			$(this).parent().find(".be-popup").fadeIn();
		}
		else{
			$(".be-popup").slideUp();
			$(this).parent().find(".be-popup").slideDown();
		}
		$(this).parent().addClass("be-active");
		$(".be-fixed-filter").addClass("active-fixed");
	});
	$(".be-fixed-filter, .be-popup .fa").on("click", function(){
		$(".filter-block li").removeClass("be-active");
		if($(window).width() > 1199)
			$(".be-popup").fadeOut();
		else
			$(".be-popup").slideUp();
		$(".be-fixed-filter").removeClass("active-fixed");
	});

	//
	$(".color").on("click", function(){
		$(".color").removeClass("active-color");
		$(this).addClass("active-color");
	});

	$(".be-drop-down").on("click" ,function(){
		$(this).toggleClass("be-dropdown-active");
		$(this).find(".drop-down-list").stop().slideToggle();
	});
	$(".drop-down-list li").on("click", function(){
		var new_value = $(this).find("a").text();
		$(this).parent().parent().find(".be-dropdown-content").text(new_value);
			$.ajax({
	     type:"GET",
	     async:true,
	     url:'ajax_for_index.html',
	     success:function(msg){
	      $("._post-container_").html(msg).delay(100).animate({'opacity':1}, 500, function(){
	       updateContentFinish = 0;
	      });
	     }
	    });
			return false;
	});
	$(".left-feild .creative_filds_block").on("click",function(){
		$.ajax({
	     type:"GET",
	     async:true,
	     url:'ajax_for_index.html',
	     success:function(msg){
	      $("._post-container_").html(msg).delay(100).animate({'opacity':1}, 500, function(){
	      });
	     }
	    });
	    return false;
	})
	$(".left-feild .tags_block a").on("click",function(){
		$.ajax({
	     type:"GET",
	     async:true,
	     url:'ajax_for_index.html',
	     success:function(msg){
	      $("._post-container_").html(msg).delay(100).animate({'opacity':1}, 500, function(){
	      });
	     }
	    });
	    $(this).toggleClass("active");
	    return false;
	})
	
	//
	$(document).on('mouseleave', '.be-drop-down.be-dropdown-active', function(){
		$(this).click();
	});

	$(".login_block .btn-login").on("click",function(){
		$(".large-popup.login").slideToggle();
		return false;
	});

	$(".be-signup-link").on("click", function(){
		$(".large-popup.login").slideDown();
		return false;
	});
	$(".large-popup.login .close-button").on("click", function(){
		$(".large-popup.login").slideUp();
	});

	$(".be-register").on("click",function(){
		$(".large-popup.register").slideDown();
		return false;
	});
	$(".large-popup.register .close-button").on("click", function(){
		$(".large-popup.register").slideUp();
	});
	$(".btn-share").on("click", function(){
		$(".share-buttons").animate({width:'toggle'},350);
	});
	$(".btn-message").on("click", function(event){
		event.stopPropagation();
		var $tgt=jQuery(event.target);
		if ($tgt.is('.close-button') ){
		      $(this).find(".message-popup").slideUp();	      
		    }else{
		      $(this).find(".message-popup").slideDown();		      
		    }   		
	});
	$(".btn-rename").on("click", function(event){
		event.stopPropagation();
		var $tgt=jQuery(event.target);
		if ($tgt.is('.close-button') ){
		      $(this).find(".message-popup").slideUp();     
		    }else{
		      $(this).find(".message-popup").slideDown();		 		      	      
		    }   		
	});	

	$(".edit-collection").on("click",function(){
		$(this).find(".c_edit").slideToggle();
		return false;
	});	

	//scroll left menu
   $('#scrollspy').affix({
        offset: {
          top: function () { return (this.top = $('#scrollspy').offset().top-85)},
          bottom: 464
        }
    });

		$("#scrollspy li a[href^='#']").on('click', function(e) {
		   e.preventDefault();
		   var hash = this.hash;
		   $('html, body').animate({
			   scrollTop: $(this.hash).offset().top
			 }, 1200, function(){
			   window.location.hash = hash;
			 });
		   return false;

		});

	/*COLOR PICKER*/
	$(".cfix li").on("click",function(){
			$.ajax({
	     type:"GET",
	     async:true,
	     url:'ajax_for_index.html',
	     success:function(msg){
	      $("._post-container_").html(msg).delay(100).animate({'opacity':1}, 500, function(){
	       updateContentFinish = 0;
	      });
	     }
	    });
	})
	$(".cfix li").on("click",function(){
			$.ajax({
	     type:"GET",
	     async:true,
	     url:'ajax_for_index.html',
	     success:function(msg){
	      $("._post-container_").html(msg).delay(100).animate({'opacity':1}, 500, function(){
	       updateContentFinish = 0;
	      });
	     }
	    });
	})	

	$(".s_keywords a").eq(0).on("click",function(){
		$(this).parent().find(".color-6").fadeOut();
	})

	$(".s_keywords i").on("click",function(){
		if($(this).parent().index()!=0)
				$(this).parent().fadeOut();
	})
	/*notification*/
	$(".messages-popup").on("click", function(){
		$(".notofications-block").hide();
		$(".messages-block").slideToggle();
		return false;
	});		
	$(".notofications-popup").on("click", function(){
		$(".messages-block").hide();
		$(".notofications-block").slideToggle();
		return false;
	});
	function notification(){
		$('.noto-body').css("max-height",winH-150);
	}		

	/*accordion*/
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

	//statistic counters
	$('.number-counters').viewportChecker({
		classToAdd: 'counted',
		offset: 100,
		callbackFunction: function(elem, action){
			elem.find('.stat-number').countTo();		
		}		
	});	


    //Tabs
	var tabFinish = 0;
	$('.nav-tab-item').on('click',  function(){
	    var $t = $(this);
	    if(tabFinish || $t.hasClass('active')) return false;
	    tabFinish = 1;
	    $t.closest('.nav-tab').find('.nav-tab-item').removeClass('active');
	    $t.addClass('active');
	    var index = $t.parent().parent().find('.nav-tab-item').index(this);
	    $t.closest('.tab-wrapper').find('.tab-info:visible').fadeOut(500, function(){
	        $t.closest('.tab-wrapper').find('.tab-info').eq(index).fadeIn(500, function() {
	            tabFinish = 0;
	        });
	    });
	});

	/*table sorting*/
	$('.table-sotring').each(function(){
        $(this).tablesorter();
	});

	$('.select-all').change( function(){
	    if($(this).prop('checked')) {
	        $(this).closest('form').find('.noto-entry .form-checkbox input').prop('checked',true);
	    } else {
	        $(this).closest('form').find('.noto-entry .form-checkbox input').prop('checked',false);	    	
	    }	        
	});

	var post_id = 1;
	$("a.add_section").on("click",function(){

		$(".creative_filds_block ul").append("<li><a href='#"+post_id+"'>New section</a>");
		$("._editor-content_").append('<div class="affix-block" id="'+post_id+'"><div class="be-large-post"><div class="info-block style-2"><div class="be-large-post-align"><h3 class="info-block-label">New section</h3></div><i class="fa fa-times close-w"></i></div><div class="be-large-post-align"><div class="row"><div class="input-col col-xs-12"><div class="form-group focus-2"><div class="form-label">Section Title</div><input class="form-input" type="text" placeholder="About Me"></div></div><div class="input-col col-xs-12"><div class="form-group focus-2"><div class="form-label">Description</div><textarea class="form-input" required="" placeholder="Something about you"></textarea></div></div></div></div></div></div>');
		$("#scrollspy li a[href^='#']").on('click', function(e) {
		   e.preventDefault();
		   var hash = this.hash;
		   $('html, body').animate({
			   scrollTop: $(this.hash).offset().top
			 }, 1200, function(){
			   window.location.hash = hash;
			 });
		   return false;
		});
		$(".creative_filds_block ul li:last-child a")[0].click();
		$(".close-w").on("click",function(){
			var id = $(this).parent().parent().parent().attr("id");
			$(this).parent().parent().parent().fadeOut();
			$(".creative_filds_block a").each(function(){
				if($(this).attr("href") == "#" + id){
					$(this).parent().fadeOut();
				}
			});
		});
		post_id++;
	});

});