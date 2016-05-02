/*Phone Menu*/
jQuery(document).ready(function() {
  "use strict";
  jQuery('.toggle').on("click", function() {
    if (jQuery('.submenu').is(":hidden")) {
      jQuery('.submenu').slideDown("fast");
    } else {
      jQuery('.submenu').slideUp("fast");
    }
    return false;
  });
  slideEffectAjax();
  /* Menu */
  jQuery(".topnav").accordion({
    accordion: false
    , speed: 300
    , closedSign: '+'
    , openedSign: '-'
  });
  jQuery("#nav > li").hover(function() {
    var el = jQuery(this).find(".level0-wrapper");
    el.hide();
    el.css("left", "0");
    el.stop(true, true).delay(150).fadeIn(300, "easeOutCubic");
  }, function() {
    jQuery(this).find(".level0-wrapper").stop(true, true).delay(300).fadeOut(300, "easeInCubic");
  });
  var scrolled = false;
  jQuery("#nav li.level0.drop-menu").mouseover(function() {
    if (jQuery(window).width() >= 740) {
      jQuery(this).children('ul.level1').fadeIn(100);
    }
    return false;
  }).mouseleave(function() {
    if (jQuery(window).width() >= 740) {
      jQuery(this).children('ul.level1').fadeOut(100);
    }
    return false;
  });
  jQuery("#nav li.level0.drop-menu li").mouseover(function() {
    if (jQuery(window).width() >= 740) {
      jQuery(this).children('ul').css({
        top: 0
        , left: "165px"
      });
      var offset = jQuery(this).offset();
      if (offset && (jQuery(window).width() < offset.left + 325)) {
        jQuery(this).children('ul').removeClass("right-sub");
        jQuery(this).children('ul').addClass("left-sub");
        jQuery(this).children('ul').css({
          top: 0
          , left: "-167px"
        });
      } else {
        jQuery(this).children('ul').removeClass("left-sub");
        jQuery(this).children('ul').addClass("right-sub");
      }
      jQuery(this).children('ul').fadeIn(100);
    }
  }).mouseleave(function() {
    if (jQuery(window).width() >= 740) {
      jQuery(this).children('ul').fadeOut(100);
    }
  });
  /* best seller slider */
  jQuery("#best-seller-slider .slider-items").owlCarousel({
    items: 4, //10 items above 1000px browser width
    itemsDesktop: [1024, 4], //5 items between 1024px and 901px
    itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
    itemsTablet: [600, 2], //2 items between 600 and 0;
    itemsMobile: [320, 1]
    , navigation: true
    , navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"]
    , slideSpeed: 500
    , pagination: false
  });
  /* featured slider */
  jQuery("#featured-slider .slider-items").owlCarousel({
    items: 2, //10 items above 1000px browser width
    itemsDesktop: [1024, 3], //5 items between 1024px and 901px
    itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
    itemsTablet: [600, 2], //2 items between 600 and 0;
    itemsMobile: [320, 1]
    , navigation: true
    , navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"]
    , slideSpeed: 500
    , pagination: false
  });
  /* Bag Seller Slider */
  jQuery("#bag-seller-slider .slider-items").owlCarousel({
    items: 3, //10 items above 1000px browser width
    itemsDesktop: [1024, 3], //5 items between 1024px and 901px
    itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
    itemsTablet: [600, 2], //2 items between 600 and 0;
    itemsMobile: [320, 1]
    , navigation: true
    , navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"]
    , slideSpeed: 500
    , pagination: false
  });
  /* Shoes Slider */
  jQuery("#shoes-slider .slider-items").owlCarousel({
    items: 3, //10 items above 1000px browser width
    itemsDesktop: [1024, 3], //5 items between 1024px and 901px
    itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
    itemsTablet: [600, 2], //2 items between 600 and 0;
    itemsMobile: [320, 1]
    , navigation: true
    , navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"]
    , slideSpeed: 500
    , pagination: false
  });
  /* Recommended Slider */
  jQuery("#recommend-slider .slider-items").owlCarousel({
    items: 6, //10 items above 1000px browser width
    itemsDesktop: [1024, 4], //5 items between 1024px and 901px
    itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
    itemsTablet: [600, 2], //2 items between 600 and 0;
    itemsMobile: [320, 1]
    , navigation: true
    , navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"]
    , slideSpeed: 500
    , pagination: false
  });
  /* Brand Logo Slider */
  jQuery("#brand-logo-slider .slider-items").owlCarousel({
    autoplay: true
    , items: 6, //10 items above 1000px browser width
    itemsDesktop: [1024, 4], //5 items between 1024px and 901px
    itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
    itemsTablet: [600, 2], //2 items between 600 and 0;
    itemsMobile: [320, 1]
    , navigation: true
    , navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"]
    , slideSpeed: 500
    , pagination: false
  });
  /* Category Description Slider */
  jQuery("#category-desc-slider .slider-items").owlCarousel({
    autoplay: true
    , items: 1, //10 items above 1000px browser width
    itemsDesktop: [1024, 1], //5 items between 1024px and 901px
    itemsDesktopSmall: [900, 1], // 3 items betweem 900px and 601px
    itemsTablet: [600, 1], //2 items between 600 and 0;
    itemsMobile: [320, 1]
    , navigation: true
    , navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"]
    , slideSpeed: 500
    , pagination: false
  });
  /* Related Products Slider */
  jQuery("#related-products-slider .slider-items").owlCarousel({
    items: 4, //10 items above 1000px browser width
    itemsDesktop: [1024, 4], //5 items between 1024px and 901px
    itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
    itemsTablet: [600, 2], //2 items between 600 and 0;
    itemsMobile: [320, 1]
    , navigation: true
    , navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"]
    , slideSpeed: 500
    , pagination: false
  });
  /* Upsell Products */
  jQuery("#upsell-products-slider .slider-items").owlCarousel({
    items: 4, //10 items above 1000px browser width
    itemsDesktop: [1024, 4], //5 items between 1024px and 901px
    itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
    itemsTablet: [600, 2], //2 items between 600 and 0;
    itemsMobile: [320, 1]
    , navigation: true
    , navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"]
    , slideSpeed: 500
    , pagination: false
  });
  /* More Views Slider */
  jQuery("#more-views-slider .slider-items").owlCarousel({
    autoplay: true
    , items: 3, //10 items above 1000px browser width
    itemsDesktop: [1024, 4], //5 items between 1024px and 901px
    itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
    itemsTablet: [600, 2], //2 items between 600 and 0;
    itemsMobile: [320, 1]
    , navigation: true
    , navigationText: ["<a class=\"flex-prev\"></a>", "<a class=\"flex-next\"></a>"]
    , slideSpeed: 500
    , pagination: false
  });
  /* sidebar menu */
  jQuery("ul.accordion li.parent, ul.accordion li.parents, ul#magicat li.open").each(function() {
    jQuery(this).append('<em class="open-close">&nbsp;</em>');
  });
  jQuery('ul.accordion, ul#magicat').accordionNew();
  jQuery("ul.accordion li.active, ul#magicat li.active").each(function() {
    jQuery(this).children().next("div").css('display', 'block');
  });
  jQuery('.accordion').accordion();
  jQuery('.accordion').each(function(index) {
    var activeItems = jQuery(this).find('li.active');
    activeItems.each(function(i) {
      jQuery(this).children('ul').css('display', 'block');
      if (i == activeItems.length - 1) {
        jQuery(this).addClass("current");
      }
    });
  });
});
var isTouchDevice = ('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0);
jQuery(window).on("load", function() {
  if (isTouchDevice) {
    jQuery('#nav a.level-top').on("click", function(e) {
      jQueryt = jQuery(this);
      jQueryparent = jQueryt.parent();
      if (jQueryparent.hasClass('parent')) {
        if (!jQueryt.hasClass('menu-ready')) {
          jQuery('#nav a.level-top').removeClass('menu-ready');
          jQueryt.addClass('menu-ready');
          return false;
        } else {
          jQueryt.removeClass('menu-ready');
        }
      }
    });
  }
  //on load
  jQuery().UItoTop();
}); //end: on load
//help slider 
/* Need Help */
jQuery('.show_hide').on("click", function() {
  jQuery("#hideShow").show();
  jQuery("#hideShow1").hide();
});
jQuery('.show_hide1').on("click", function() {
  jQuery("#hideShow1").show();
  jQuery("#hideShow").hide();
});
jQuery('#hideDiv').on("click", function() {
  jQuery("#hideShow").hide();
});
jQuery('#hideDiv1').on("click", function() {
  jQuery("#hideShow1").hide();
});
//]]>
/* UItoTop */
jQuery.fn.UItoTop = function(options) {
  var defaults = {
    text: ''
    , min: 200
    , inDelay: 600
    , outDelay: 400
    , containerID: 'toTop'
    , containerHoverID: 'toTopHover'
    , scrollSpeed: 1200
    , easingType: 'linear'
  };
  var settings = jQuery.extend(defaults, options);
  var containerIDhash = '#' + settings.containerID;
  var containerHoverIDHash = '#' + settings.containerHoverID;
  jQuery('body').append('<a href="#" id="' + settings.containerID + '">' + settings.text + '</a>');
  jQuery(containerIDhash).hide().on("click", function() {
    jQuery('html, body').animate({
      scrollTop: 0
    }, settings.scrollSpeed, settings.easingType);
    jQuery('#' + settings.containerHoverID, this).stop().animate({
      'opacity': 0
    }, settings.inDelay, settings.easingType);
    return false;
  }).prepend('<span id="' + settings.containerHoverID + '"></span>').hover(function() {
    jQuery(containerHoverIDHash, this).stop().animate({
      'opacity': 1
    }, 600, 'linear');
  }, function() {
    jQuery(containerHoverIDHash, this).stop().animate({
      'opacity': 0
    }, 700, 'linear');
  });
  jQuery(window).scroll(function() {
    var sd = jQuery(window).scrollTop();
    if (typeof document.body.style.maxHeight === "undefined") {
      jQuery(containerIDhash).css({
        'position': 'absolute'
        , 'top': jQuery(window).scrollTop() + jQuery(window).height() - 50
      });
    }
    if (sd > settings.min) jQuery(containerIDhash).fadeIn(settings.inDelay);
    else jQuery(containerIDhash).fadeOut(settings.Outdelay);
  });
};
/* Top cart */
function slideEffectAjax() {
  jQuery('.top-cart-contain').mouseenter(function() {
    jQuery(this).find(".top-cart-content").stop(true, true).slideDown();
  });
  jQuery('.top-cart-contain').mouseleave(function() {
    jQuery(this).find(".top-cart-content").stop(true, true).slideUp();
  });
}
jQuery.extend(jQuery.easing, {
  easeInCubic: function(x, t, b, c, d) {
    return c * (t /= d) * t * t + b;
  }
  , easeOutCubic: function(x, t, b, c, d) {
    return c * ((t = t / d - 1) * t * t + 1) + b;
  }
, });
(function(jQuery) {
  jQuery.fn.extend({
    accordion: function() {
      return this.each(function() {
        function activate(el, effect) {
          jQuery(el).siblings(panelSelector)[(effect || activationEffect)](((effect == "show") ? activationEffectSpeed : false), function() {
            jQuery(el).parents().show();
          });
        }
      });
    }
  });
})(jQuery);
/* Responsive Nav */
(function(jQuery) {
  jQuery.fn.extend({
    accordion: function(options) {
      var defaults = {
        accordion: 'true'
        , speed: 300
        , closedSign: '[+]'
        , openedSign: '[-]'
      };
      var opts = jQuery.extend(defaults, options);
      var jQuerythis = jQuery(this);
      jQuerythis.find("li").each(function() {
        if (jQuery(this).find("ul").size() != 0) {
          jQuery(this).find("a:first").after("<em>" + opts.closedSign + "</em>");
          if (jQuery(this).find("a:first").attr('href') == "#") {
            jQuery(this).find("a:first").on("click", function() {
              return false;
            });
          }
        }
      });
      jQuerythis.find("li em").on("click", function() {
        if (jQuery(this).parent().find("ul").size() != 0) {
          if (opts.accordion) {
            //Do nothing when the list is open
            if (!jQuery(this).parent().find("ul").is(':visible')) {
              parents = jQuery(this).parent().parents("ul");
              visible = jQuerythis.find("ul:visible");
              visible.each(function(visibleIndex) {
                var close = true;
                parents.each(function(parentIndex) {
                  if (parents[parentIndex] == visible[visibleIndex]) {
                    close = false;
                    return false;
                  }
                });
                if (close) {
                  if (jQuery(this).parent().find("ul") != visible[visibleIndex]) {
                    jQuery(visible[visibleIndex]).slideUp(opts.speed, function() {
                      jQuery(this).parent("li").find("em:first").html(opts.closedSign);
                    });
                  }
                }
              });
            }
          }
          if (jQuery(this).parent().find("ul:first").is(":visible")) {
            jQuery(this).parent().find("ul:first").slideUp(opts.speed, function() {
              jQuery(this).parent("li").find("em:first").delay(opts.speed).html(opts.closedSign);
            });
          } else {
            jQuery(this).parent().find("ul:first").slideDown(opts.speed, function() {
              jQuery(this).parent("li").find("em:first").delay(opts.speed).html(opts.openedSign);
            });
          }
        }
      });
    }
  });
  jQuery.fn.extend({
    accordionNew: function() {
      return this.each(function() {
        var jQueryul = jQuery(this)
          , elementDataKey = 'accordiated'
          , activeClassName = 'active'
          , activationEffect = 'slideToggle'
          , panelSelector = 'ul, div'
          , activationEffectSpeed = 'fast'
          , itemSelector = 'li';
        if (jQueryul.data(elementDataKey)) return false;
        jQuery.each(jQueryul.find('ul, li>div'), function() {
          jQuery(this).data(elementDataKey, true);
          jQuery(this).hide();
        });
        jQuery.each(jQueryul.find('em.open-close'), function() {
          jQuery(this).on("click", function(e) {
            activate(this, activationEffect);
            return void(0);
          });
          jQuery(this).bind('activate-node', function() {
            jQueryul.find(panelSelector).not(jQuery(this).parents()).not(jQuery(this).siblings()).slideUp(activationEffectSpeed);
            activate(this, 'slideDown');
          });
        });
        var active = (location.hash) ? jQueryul.find('a[href=' + location.hash + ']')[0] : jQueryul.find('li.current a')[0];
        if (active) {
          activate(active, false);
        }

        function activate(el, effect) {
          jQuery(el).parent(itemSelector).siblings().removeClass(activeClassName).children(panelSelector).slideUp(activationEffectSpeed);
          jQuery(el).siblings(panelSelector)[(effect || activationEffect)](((effect == "show") ? activationEffectSpeed : false), function() {
            if (jQuery(el).siblings(panelSelector).is(':visible')) {
              jQuery(el).parents(itemSelector).not(jQueryul.parents()).addClass(activeClassName);
            } else {
              jQuery(el).parent(itemSelector).removeClass(activeClassName);
            }
            if (effect == 'show') {
              jQuery(el).parents(itemSelector).not(jQueryul.parents()).addClass(activeClassName);
            }
            jQuery(el).parents().show();
          });
        }
      });
    }
  });
})(jQuery);;
(function(window) {
  'use strict';

  function classReg(className) {
    return new RegExp("(^|\\s+)" + className + "(\\s+|jQuery)");
  }
  var hasClass, addClass, removeClass;
  if ('classList' in document.documentElement) {
    hasClass = function(elem, c) {
      return elem.classList.contains(c);
    };
    addClass = function(elem, c) {
      elem.classList.add(c);
    };
    removeClass = function(elem, c) {
      elem.classList.remove(c);
    };
  } else {
    hasClass = function(elem, c) {
      return classReg(c).test(elem.className);
    };
  }

  function toggleClass(elem, c) {
    var fn = hasClass(elem, c) ? removeClass : addClass;
    fn(elem, c);
  }
  var classie = {
    // full names
    hasClass: hasClass
    , addClass: addClass
    , removeClass: removeClass
    , toggleClass: toggleClass, // short names
    has: hasClass
    , add: addClass
    , remove: removeClass
    , toggle: toggleClass
  };
  // transport
  if (typeof define === 'function' && define.amd) {
    // AMD
    define(classie);
  } else {
    // browser global
    window.classie = classie;
  }
  // EventListener | @jon_neal | //github.com/jonathantneal/EventListener
  !window.addEventListener && window.Element && (function() {
    function addToPrototype(name, method) {
      Window.prototype[name] = HTMLDocument.prototype[name] = Element.prototype[name] = method;
    }
    var registry = [];
    addToPrototype("addEventListener", function(type, listener) {
      var target = this;
      registry.unshift({
        __listener: function(event) {
          event.currentTarget = target;
          event.pageX = event.clientX + document.documentElement.scrollLeft;
          event.pageY = event.clientY + document.documentElement.scrollTop;
          event.preventDefault = function() {
            event.returnValue = false
          };
          event.relatedTarget = event.fromElement || null;
          event.stopPropagation = function() {
            event.cancelBubble = true
          };
          event.relatedTarget = event.fromElement || null;
          event.target = event.srcElement || target;
          event.timeStamp = +new Date;
          listener.call(target, event);
        }
        , listener: listener
        , target: target
        , type: type
      });
      this.attachEvent("on" + type, registry[0].__listener);
    });
  })();

  function UISearch(el, options) {
    this.el = el;
    this.inputEl = el.querySelector('form > input.search-bar-input');
    this._initEvents();
  }
  UISearch.prototype = {
      _initEvents: function() {
        var self = this
          , initSearchFn = function(ev) {
            ev.stopPropagation();
            // trim its value
            self.inputEl.value = self.inputEl.value.trim();
            if (!classie.has(self.el, 'search-bar-open')) { // open it
              ev.preventDefault();
              self.open();
            } else if (classie.has(self.el, 'search-bar-open') && /^\s*jQuery/.test(self.inputEl.value)) { // close it
              ev.preventDefault();
              self.close();
            }
          }
        this.el.addEventListener('click', initSearchFn);
        this.el.addEventListener('touchstart', initSearchFn);
        this.inputEl.addEventListener('click', function(ev) {
          ev.stopPropagation();
        });
        this.inputEl.addEventListener('touchstart', function(ev) {
          ev.stopPropagation();
        });
      }
      , open: function() {
        var self = this;
        classie.add(this.el, 'search-bar-open');
        // focus the input
        // close the search input if body is clicked
        var bodyFn = function(ev) {
          self.close();
          this.removeEventListener('click', bodyFn);
          this.removeEventListener('touchstart', bodyFn);
        };
        document.addEventListener('click', bodyFn);
        document.addEventListener('touchstart', bodyFn);
      }
      , close: function() {
        this.inputEl.blur();
        classie.remove(this.el, 'search-bar-open');
      }
    }
    // add to global namespace
  window.UISearch = UISearch;
})(window);