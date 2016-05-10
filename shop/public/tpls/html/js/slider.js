;
(function(jQuery, undefined) {
  "use strict";
  var ver = '2.9999.2';

  if (jQuery.support == undefined) {
    jQuery.support = {
      opacity: !(jQuery.browser.msie)
    };
  }

  function debug(s) {
    jQuery.fn.cycle.debug && log(s);
  }

  function log() {
    window.console && console.log && console.log('[cycle] ' + Array.prototype.join.call(arguments, ' '));
  }
  jQuery.expr[':'].paused = function(el) {
    return el.cyclePause;
  };



  jQuery.fn.cycle = function(options, arg2) {
    var o = {
      s: this.selector,
      c: this.context
    };


    if (this.length === 0 && options != 'stop') {
      if (!jQuery.isReady && o.s) {
        log('DOM not ready, queuing slideshow');
        jQuery(function() {
          jQuery(o.s, o.c).cycle(options, arg2);
        });
        return this;
      }

      log('terminating; zero elements found by selector' + (jQuery.isReady ? '' : ' (DOM not ready)'));
      return this;
    }

    // iterate the matched nodeset
    return this.each(function() {
      var opts = handleArguments(this, options, arg2);
      if (opts === false) return;

      opts.updateActivePagerLink = opts.updateActivePagerLink || jQuery.fn.cycle.updateActivePagerLink;

      // stop existing slideshow for this container (if there is one)
      if (this.cycleTimeout) clearTimeout(this.cycleTimeout);
      this.cycleTimeout = this.cyclePause = 0;

      var jQuerycont = jQuery(this);
      var jQueryslides = opts.slideExpr ? jQuery(opts.slideExpr, this) : jQuerycont.children();
      var els = jQueryslides.get();

      var opts2 = buildOptions(jQuerycont, jQueryslides, els, opts, o);
      if (opts2 === false) return;

      if (els.length < 2) {
        log('terminating; too few slides: ' + els.length);
        return;
      }

      var startTime = opts2.continuous ? 10 : getTimeout(els[opts2.currSlide], els[opts2.nextSlide], opts2, !opts2.backwards);

      // if it's an auto slideshow, kick it off
      if (startTime) {
        startTime += (opts2.delay || 0);
        if (startTime < 10) startTime = 10;
        debug('first timeout: ' + startTime);
        this.cycleTimeout = setTimeout(function() {
          go(els, opts2, 0, !opts.backwards)
        }, startTime);
      }
    });
  };

  function triggerPause(cont, byHover, onPager) {
    var opts = jQuery(cont).data('cycle.opts');
    var paused = !! cont.cyclePause;
    if (paused && opts.paused) opts.paused(cont, opts, byHover, onPager);
    else if (!paused && opts.resumed) opts.resumed(cont, opts, byHover, onPager);
  }

  // process the args that were passed to the plugin fn

  function handleArguments(cont, options, arg2) {
    if (cont.cycleStop == undefined) cont.cycleStop = 0;
    if (options === undefined || options === null) options = {};
    if (options.constructor == String) {
      switch (options) {
        case 'destroy':
        case 'stop':
          var opts = jQuery(cont).data('cycle.opts');
          if (!opts) return false;
          cont.cycleStop++; // callbacks look for change
          if (cont.cycleTimeout) clearTimeout(cont.cycleTimeout);
          cont.cycleTimeout = 0;
          opts.elements && jQuery(opts.elements).stop();
          jQuery(cont).removeData('cycle.opts');
          if (options == 'destroy') destroy(cont, opts);
          return false;
        case 'toggle':
          cont.cyclePause = (cont.cyclePause === 1) ? 0 : 1;
          checkInstantResume(cont.cyclePause, arg2, cont);
          triggerPause(cont);
          return false;
        case 'pause':
          cont.cyclePause = 1;
          triggerPause(cont);
          return false;
        case 'resume':
          cont.cyclePause = 0;
          checkInstantResume(false, arg2, cont);
          triggerPause(cont);
          return false;
        case 'prev':
        case 'next':
          var opts = jQuery(cont).data('cycle.opts');
          if (!opts) {
            log('options not found, "prev/next" ignored');
            return false;
          }
          jQuery.fn.cycle[options](opts);
          return false;
        default:
          options = {
            fx: options
          };
      };
      return options;
    } else if (options.constructor == Number) {
      // go to the requested slide
      var num = options;
      options = jQuery(cont).data('cycle.opts');
      if (!options) {
        log('options not found, can not advance slide');
        return false;
      }
      if (num < 0 || num >= options.elements.length) {
        log('invalid slide index: ' + num);
        return false;
      }
      options.nextSlide = num;
      if (cont.cycleTimeout) {
        clearTimeout(cont.cycleTimeout);


        cont.cycleTimeout = 0;
      }
      if (typeof arg2 == 'string') options.oneTimeFx = arg2;
      go(options.elements, options, 1, num >= options.currSlide);
      return false;
    }
    return options;

    function checkInstantResume(isPaused, arg2, cont) {
      if (!isPaused && arg2 === true) { // resume now!
        var options = jQuery(cont).data('cycle.opts');
        if (!options) {
          log('options not found, can not resume');
          return false;
        }
        if (cont.cycleTimeout) {
          clearTimeout(cont.cycleTimeout);
          cont.cycleTimeout = 0;
        }
        go(options.elements, options, 1, !options.backwards);
      }
    }
  };

  function removeFilter(el, opts) {
    if (!jQuery.support.opacity && opts.cleartype && el.style.filter) {
      try {
        el.style.removeAttribute('filter');
      } catch (smother) {} // handle old opera versions
    }
  };

  // unbind event handlers

  function destroy(cont, opts) {
    if (opts.next) jQuery(opts.next).unbind(opts.prevNextEvent);
    if (opts.prev) jQuery(opts.prev).unbind(opts.prevNextEvent);

    if (opts.pager || opts.pagerAnchorBuilder) jQuery.each(opts.pagerAnchors || [], function() {
      this.unbind().remove();
    });
    opts.pagerAnchors = null;
    jQuery(cont).unbind('mouseenter.cycle mouseleave.cycle');
    if (opts.destroy) // callback
    opts.destroy(opts);
  };

  // one-time initialization

  function buildOptions(jQuerycont, jQueryslides, els, options, o) {
    var startingSlideSpecified;
    // support metadata plugin (v1.0 and v2.0)
    var opts = jQuery.extend({}, jQuery.fn.cycle.defaults, options || {}, jQuery.metadata ? jQuerycont.metadata() : jQuery.meta ? jQuerycont.data() : {});
    var meta = jQuery.isFunction(jQuerycont.data) ? jQuerycont.data(opts.metaAttr) : null;
    if (meta) opts = jQuery.extend(opts, meta);
    if (opts.autostop) opts.countdown = opts.autostopCount || els.length;

    var cont = jQuerycont[0];
    jQuerycont.data('cycle.opts', opts);
    opts.jQuerycont = jQuerycont;
    opts.stopCount = cont.cycleStop;
    opts.elements = els;
    opts.before = opts.before ? [opts.before] : [];
    opts.after = opts.after ? [opts.after] : [];

    // push some after callbacks
    if (!jQuery.support.opacity && opts.cleartype) opts.after.push(function() {
      removeFilter(this, opts);
    });
    if (opts.continuous) opts.after.push(function() {
      go(els, opts, 0, !opts.backwards);
    });

    saveOriginalOpts(opts);

    // clearType corrections
    if (!jQuery.support.opacity && opts.cleartype && !opts.cleartypeNoBg) clearTypeFix(jQueryslides);

    // container requires non-static position so that slides can be position within
    if (jQuerycont.css('position') == 'static') jQuerycont.css('position', 'relative');
    if (opts.width) jQuerycont.width(opts.width);
    if (opts.height && opts.height != 'auto') jQuerycont.height(opts.height);

    if (opts.startingSlide != undefined) {
      opts.startingSlide = parseInt(opts.startingSlide, 10);
      if (opts.startingSlide >= els.length || opts.startSlide < 0) opts.startingSlide = 0; // catch bogus input
      else startingSlideSpecified = true;
    } else if (opts.backwards) opts.startingSlide = els.length - 1;
    else opts.startingSlide = 0;

    // if random, mix up the slide array
    if (opts.random) {
      opts.randomMap = [];
      for (var i = 0; i < els.length; i++)
      opts.randomMap.push(i);
      opts.randomMap.sort(function(a, b) {
        return Math.random() - 0.5;
      });
      if (startingSlideSpecified) {
        // try to find the specified starting slide and if found set start slide index in the map accordingly
        for (var cnt = 0; cnt < els.length; cnt++) {
          if (opts.startingSlide == opts.randomMap[cnt]) {
            opts.randomIndex = cnt;
          }
        }
      } else {
        opts.randomIndex = 1;
        opts.startingSlide = opts.randomMap[1];
      }
    } else if (opts.startingSlide >= els.length) opts.startingSlide = 0; // catch bogus input
    opts.currSlide = opts.startingSlide || 0;
    var first = opts.startingSlide;

    // set position and zIndex on all the slides
    jQueryslides.css({
      position: 'absolute',
      top: 0,
      left: 0
    }).hide().each(function(i) {
      var z;
      if (opts.backwards) z = first ? i <= first ? els.length + (i - first) : first - i : els.length - i;
      else z = first ? i >= first ? els.length - (i - first) : first - i : els.length - i;
      jQuery(this).css('z-index', z);
    });

    // make sure first slide is visible
    jQuery(els[first]).css('opacity', 1).show(); // opacity bit needed to handle restart use case
    removeFilter(els[first], opts);

    // stretch slides
    if (opts.fit) {
      if (!opts.aspect) {
        if (opts.width) jQueryslides.width(opts.width);
        if (opts.height && opts.height != 'auto') jQueryslides.height(opts.height);
      } else {
        jQueryslides.each(function() {
          var jQueryslide = jQuery(this);
          var ratio = (opts.aspect === true) ? jQueryslide.width() / jQueryslide.height() : opts.aspect;
          if (opts.width && jQueryslide.width() != opts.width) {
            jQueryslide.width(opts.width);
            jQueryslide.height(opts.width / ratio);
          }

          if (opts.height && jQueryslide.height() < opts.height) {
            jQueryslide.height(opts.height);
            jQueryslide.width(opts.height * ratio);
          }
        });
      }
    }

    if (opts.center && ((!opts.fit) || opts.aspect)) {
      jQueryslides.each(function() {
        var jQueryslide = jQuery(this);
        jQueryslide.css({
          "margin-left": opts.width ? ((opts.width - jQueryslide.width()) / 2) + "px" : 0,
          "margin-top": opts.height ? ((opts.height - jQueryslide.height()) / 2) + "px" : 0
        });
      });
    }

    if (opts.center && !opts.fit && !opts.slideResize) {
      jQueryslides.each(function() {
        var jQueryslide = jQuery(this);
        jQueryslide.css({
          "margin-left": opts.width ? ((opts.width - jQueryslide.width()) / 2) + "px" : 0,
          "margin-top": opts.height ? ((opts.height - jQueryslide.height()) / 2) + "px" : 0
        });
      });
    }

    // stretch container
    var reshape = opts.containerResize && !jQuerycont.innerHeight();
    if (reshape) { // do this only if container has no size http://tinyurl.com/da2oa9
      var maxw = 0,
        maxh = 0;
      for (var j = 0; j < els.length; j++) {
        var jQuerye = jQuery(els[j]),
          e = jQuerye[0],
          w = jQuerye.outerWidth(),
          h = jQuerye.outerHeight();
        if (!w) w = e.offsetWidth || e.width || jQuerye.attr('width');
        if (!h) h = e.offsetHeight || e.height || jQuerye.attr('height');
        maxw = w > maxw ? w : maxw;
        maxh = h > maxh ? h : maxh;
      }
      if (maxw > 0 && maxh > 0) jQuerycont.css({
        width: maxw + 'px',
        height: maxh + 'px'
      });
    }

    var pauseFlag = false; // https://github.com/malsup/cycle/issues/44
    if (opts.pause) jQuerycont.bind('mouseenter.cycle', function() {
      pauseFlag = true;
      this.cyclePause++;
      triggerPause(cont, true);
    }).bind('mouseleave.cycle', function() {
      pauseFlag && this.cyclePause--;
      triggerPause(cont, true);
    });

    if (supportMultiTransitions(opts) === false) return false;


    var requeue = false;
    options.requeueAttempts = options.requeueAttempts || 0;
    jQueryslides.each(function() {

      var jQueryel = jQuery(this);
      this.cycleH = (opts.fit && opts.height) ? opts.height : (jQueryel.height() || this.offsetHeight || this.height || jQueryel.attr('height') || 0);
      this.cycleW = (opts.fit && opts.width) ? opts.width : (jQueryel.width() || this.offsetWidth || this.width || jQueryel.attr('width') || 0);

      if (jQueryel.is('img')) {

        var loadingIE = (jQuery.browser.msie && this.cycleW == 28 && this.cycleH == 30 && !this.complete);
        var loadingFF = (jQuery.browser.mozilla && this.cycleW == 34 && this.cycleH == 19 && !this.complete);
        var loadingOp = (jQuery.browser.opera && ((this.cycleW == 42 && this.cycleH == 19) || (this.cycleW == 37 && this.cycleH == 17)) && !this.complete);
        var loadingOther = (this.cycleH == 0 && this.cycleW == 0 && !this.complete);

        if (loadingIE || loadingFF || loadingOp || loadingOther) {
          if (o.s && opts.requeueOnImageNotLoaded && ++options.requeueAttempts < 100) {
            log(options.requeueAttempts, ' - img slide not loaded, requeuing slideshow: ', this.src, this.cycleW, this.cycleH);
            setTimeout(function() {
              jQuery(o.s, o.c).cycle(options)
            }, opts.requeueTimeout);
            requeue = true;
            return false;
          } else {
            log('could not determine size of image: ' + this.src, this.cycleW, this.cycleH);
          }
        }
      }
      return true;
    });

    if (requeue) return false;

    opts.cssBefore = opts.cssBefore || {};
    opts.cssAfter = opts.cssAfter || {};
    opts.cssFirst = opts.cssFirst || {};
    opts.animIn = opts.animIn || {};
    opts.animOut = opts.animOut || {};

    jQueryslides.not(':eq(' + first + ')').css(opts.cssBefore);
    jQuery(jQueryslides[first]).css(opts.cssFirst);

    if (opts.timeout) {
      opts.timeout = parseInt(opts.timeout, 10);
      // ensure that timeout and speed settings are sane
      if (opts.speed.constructor == String) opts.speed = jQuery.fx.speeds[opts.speed] || parseInt(opts.speed, 10);
      if (!opts.sync) opts.speed = opts.speed / 2;

      var buffer = opts.fx == 'none' ? 0 : opts.fx == 'shuffle' ? 500 : 250;
      while ((opts.timeout - opts.speed) < buffer) // sanitize timeout
      opts.timeout += opts.speed;
    }
    if (opts.easing) opts.easeIn = opts.easeOut = opts.easing;
    if (!opts.speedIn) opts.speedIn = opts.speed;
    if (!opts.speedOut) opts.speedOut = opts.speed;

    opts.slideCount = els.length;
    opts.currSlide = opts.lastSlide = first;
    if (opts.random) {
      if (++opts.randomIndex == els.length) opts.randomIndex = 0;
      opts.nextSlide = opts.randomMap[opts.randomIndex];
    } else if (opts.backwards) opts.nextSlide = opts.startingSlide == 0 ? (els.length - 1) : opts.startingSlide - 1;
    else opts.nextSlide = opts.startingSlide >= (els.length - 1) ? 0 : opts.startingSlide + 1;

    // run transition init fn
    if (!opts.multiFx) {
      var init = jQuery.fn.cycle.transitions[opts.fx];
      if (jQuery.isFunction(init)) init(jQuerycont, jQueryslides, opts);
      else if (opts.fx != 'custom' && !opts.multiFx) {
        log('unknown transition: ' + opts.fx, '; slideshow terminating');
        return false;
      }
    }

    // fire artificial events
    var e0 = jQueryslides[first];
    if (!opts.skipInitializationCallbacks) {
      if (opts.before.length) opts.before[0].apply(e0, [e0, e0, opts, true]);
      if (opts.after.length) opts.after[0].apply(e0, [e0, e0, opts, true]);
    }
    if (opts.next) jQuery(opts.next).bind(opts.prevNextEvent, function() {
      return advance(opts, 1)
    });
    if (opts.prev) jQuery(opts.prev).bind(opts.prevNextEvent, function() {
      return advance(opts, 0)
    });
    if (opts.pager || opts.pagerAnchorBuilder) buildPager(els, opts);

    exposeAddSlide(opts, els);

    return opts;
  };

  // save off original opts so we can restore after clearing state

  function saveOriginalOpts(opts) {
    opts.original = {
      before: [],
      after: []
    };
    opts.original.cssBefore = jQuery.extend({}, opts.cssBefore);
    opts.original.cssAfter = jQuery.extend({}, opts.cssAfter);
    opts.original.animIn = jQuery.extend({}, opts.animIn);
    opts.original.animOut = jQuery.extend({}, opts.animOut);
    jQuery.each(opts.before, function() {
      opts.original.before.push(this);
    });
    jQuery.each(opts.after, function() {
      opts.original.after.push(this);
    });
  };

  function supportMultiTransitions(opts) {
    var i, tx, txs = jQuery.fn.cycle.transitions;
    // look for multiple effects
    if (opts.fx.indexOf(',') > 0) {
      opts.multiFx = true;
      opts.fxs = opts.fx.replace(/\s*/g, '').split(',');
      // discard any bogus effect names
      for (i = 0; i < opts.fxs.length; i++) {
        var fx = opts.fxs[i];
        tx = txs[fx];
        if (!tx || !txs.hasOwnProperty(fx) || !jQuery.isFunction(tx)) {
          log('discarding unknown transition: ', fx);
          opts.fxs.splice(i, 1);
          i--;
        }
      }
      // if we have an empty list then we threw everything away!
      if (!opts.fxs.length) {
        log('No valid transitions named; slideshow terminating.');
        return false;
      }
    } else if (opts.fx == 'all') { // auto-gen the list of transitions
      opts.multiFx = true;
      opts.fxs = [];
      for (p in txs) {
        tx = txs[p];
        if (txs.hasOwnProperty(p) && jQuery.isFunction(tx)) opts.fxs.push(p);
      }
    }
    if (opts.multiFx && opts.randomizeEffects) {
      // munge the fxs array to make effect selection random
      var r1 = Math.floor(Math.random() * 20) + 30;
      for (i = 0; i < r1; i++) {
        var r2 = Math.floor(Math.random() * opts.fxs.length);
        opts.fxs.push(opts.fxs.splice(r2, 1)[0]);
      }
      debug('randomized fx sequence: ', opts.fxs);
    }
    return true;
  };

  // provide a mechanism for adding slides after the slideshow has started

  function exposeAddSlide(opts, els) {
    opts.addSlide = function(newSlide, prepend) {
      var jQuerys = jQuery(newSlide),
        s = jQuerys[0];
      if (!opts.autostopCount) opts.countdown++;
      els[prepend ? 'unshift' : 'push'](s);
      if (opts.els) opts.els[prepend ? 'unshift' : 'push'](s); // shuffle needs this
      opts.slideCount = els.length;

      // add the slide to the random map and resort
      if (opts.random) {
        opts.randomMap.push(opts.slideCount - 1);
        opts.randomMap.sort(function(a, b) {
          return Math.random() - 0.5;
        });
      }

      jQuerys.css('position', 'absolute');
      jQuerys[prepend ? 'prependTo' : 'appendTo'](opts.jQuerycont);

      if (prepend) {
        opts.currSlide++;
        opts.nextSlide++;
      }

      if (!jQuery.support.opacity && opts.cleartype && !opts.cleartypeNoBg) clearTypeFix(jQuerys);

      if (opts.fit && opts.width) jQuerys.width(opts.width);
      if (opts.fit && opts.height && opts.height != 'auto') jQuerys.height(opts.height);
      s.cycleH = (opts.fit && opts.height) ? opts.height : jQuerys.height();
      s.cycleW = (opts.fit && opts.width) ? opts.width : jQuerys.width();

      jQuerys.css(opts.cssBefore);

      if (opts.pager || opts.pagerAnchorBuilder) jQuery.fn.cycle.createPagerAnchor(els.length - 1, s, jQuery(opts.pager), els, opts);

      if (jQuery.isFunction(opts.onAddSlide)) opts.onAddSlide(jQuerys);
      else jQuerys.hide(); // html behavior
    };
  }


  jQuery.fn.cycle.resetState = function(opts, fx) {
    fx = fx || opts.fx;
    opts.before = [];
    opts.after = [];
    opts.cssBefore = jQuery.extend({}, opts.original.cssBefore);
    opts.cssAfter = jQuery.extend({}, opts.original.cssAfter);
    opts.animIn = jQuery.extend({}, opts.original.animIn);
    opts.animOut = jQuery.extend({}, opts.original.animOut);
    opts.fxFn = null;
    jQuery.each(opts.original.before, function() {
      opts.before.push(this);
    });
    jQuery.each(opts.original.after, function() {
      opts.after.push(this);
    });

    // re-init
    var init = jQuery.fn.cycle.transitions[fx];
    if (jQuery.isFunction(init)) init(opts.jQuerycont, jQuery(opts.elements), opts);
  };


  function go(els, opts, manual, fwd) {

    if (manual && opts.busy && opts.manualTrump) {

      debug('manualTrump in go(), stopping active transition');
      jQuery(els).stop(true, true);
      opts.busy = 0;
    }

    if (opts.busy) {
      debug('transition active, ignoring new tx request');
      return;
    }

    var p = opts.jQuerycont[0],
      curr = els[opts.currSlide],
      next = els[opts.nextSlide];


    if (p.cycleStop != opts.stopCount || p.cycleTimeout === 0 && !manual) return;


    if (!manual && !p.cyclePause && !opts.bounce && ((opts.autostop && (--opts.countdown <= 0)) || (opts.nowrap && !opts.random && opts.nextSlide < opts.currSlide))) {
      if (opts.end) opts.end(opts);
      return;
    }


    var changed = false;
    if ((manual || !p.cyclePause) && (opts.nextSlide != opts.currSlide)) {
      changed = true;
      var fx = opts.fx;

      curr.cycleH = curr.cycleH || jQuery(curr).height();
      curr.cycleW = curr.cycleW || jQuery(curr).width();
      next.cycleH = next.cycleH || jQuery(next).height();
      next.cycleW = next.cycleW || jQuery(next).width();

      // support multiple transition types
      if (opts.multiFx) {
        if (fwd && (opts.lastFx == undefined || ++opts.lastFx >= opts.fxs.length)) opts.lastFx = 0;
        else if (!fwd && (opts.lastFx == undefined || --opts.lastFx < 0)) opts.lastFx = opts.fxs.length - 1;
        fx = opts.fxs[opts.lastFx];
      }

      // one-time fx overrides apply to:  jQuery('div').cycle(3,'zoom');
      if (opts.oneTimeFx) {
        fx = opts.oneTimeFx;
        opts.oneTimeFx = null;
      }

      jQuery.fn.cycle.resetState(opts, fx);

      // run the before callbacks
      if (opts.before.length) jQuery.each(opts.before, function(i, o) {
        if (p.cycleStop != opts.stopCount) return;
        o.apply(next, [curr, next, opts, fwd]);
      });

      // stage the after callacks
      var after = function() {
        opts.busy = 0;
        jQuery.each(opts.after, function(i, o) {
          if (p.cycleStop != opts.stopCount) return;
          o.apply(next, [curr, next, opts, fwd]);
        });
        if (!p.cycleStop) {
          // queue next transition
          queueNext();
        }
      };

      debug('tx firing(' + fx + '); currSlide: ' + opts.currSlide + '; nextSlide: ' + opts.nextSlide);

      // get ready to perform the transition
      opts.busy = 1;
      if (opts.fxFn) // fx function provided?

      opts.fxFn(curr, next, opts, after, fwd, manual && opts.fastOnEvent);
      else if (jQuery.isFunction(jQuery.fn.cycle[opts.fx])) // fx plugin ?
      jQuery.fn.cycle[opts.fx](curr, next, opts, after, fwd, manual && opts.fastOnEvent);
      else jQuery.fn.cycle.custom(curr, next, opts, after, fwd, manual && opts.fastOnEvent);
    } else {
      queueNext();
    }

    if (changed || opts.nextSlide == opts.currSlide) {
      // calculate the next slide
      opts.lastSlide = opts.currSlide;
      if (opts.random) {
        opts.currSlide = opts.nextSlide;
        if (++opts.randomIndex == els.length) {
          opts.randomIndex = 0;
          opts.randomMap.sort(function(a, b) {
            return Math.random() - 0.5;
          });
        }
        opts.nextSlide = opts.randomMap[opts.randomIndex];
        if (opts.nextSlide == opts.currSlide) opts.nextSlide = (opts.currSlide == opts.slideCount - 1) ? 0 : opts.currSlide + 1;
      } else if (opts.backwards) {
        var roll = (opts.nextSlide - 1) < 0;
        if (roll && opts.bounce) {
          opts.backwards = !opts.backwards;
          opts.nextSlide = 1;
          opts.currSlide = 0;
        } else {
          opts.nextSlide = roll ? (els.length - 1) : opts.nextSlide - 1;
          opts.currSlide = roll ? 0 : opts.nextSlide + 1;
        }
      } else { // sequence
        var roll = (opts.nextSlide + 1) == els.length;
        if (roll && opts.bounce) {
          opts.backwards = !opts.backwards;
          opts.nextSlide = els.length - 2;
          opts.currSlide = els.length - 1;
        } else {
          opts.nextSlide = roll ? 0 : opts.nextSlide + 1;
          opts.currSlide = roll ? els.length - 1 : opts.nextSlide - 1;
        }
      }
    }
    if (changed && opts.pager) opts.updateActivePagerLink(opts.pager, opts.currSlide, opts.activePagerClass);

    function queueNext() {
      // stage the next transition
      var ms = 0,
        timeout = opts.timeout;
      if (opts.timeout && !opts.continuous) {
        ms = getTimeout(els[opts.currSlide], els[opts.nextSlide], opts, fwd);
        if (opts.fx == 'shuffle') ms -= opts.speedOut;
      } else if (opts.continuous && p.cyclePause) // continuous shows work off an after callback, not this timer logic
      ms = 10;
      if (ms > 0) p.cycleTimeout = setTimeout(function() {
        go(els, opts, 0, !opts.backwards)
      }, ms);
    }
  };

  // invoked after transition
  jQuery.fn.cycle.updateActivePagerLink = function(pager, currSlide, clsName) {
    jQuery(pager).each(function() {
      jQuery(this).children().removeClass(clsName).eq(currSlide).addClass(clsName);
    });
  };

  // calculate timeout value for current transition

  function getTimeout(curr, next, opts, fwd) {
    if (opts.timeoutFn) {
      // call user provided calc fn
      var t = opts.timeoutFn.call(curr, curr, next, opts, fwd);
      while (opts.fx != 'none' && (t - opts.speed) < 250) // sanitize timeout
      t += opts.speed;
      debug('calculated timeout: ' + t + '; speed: ' + opts.speed);
      if (t !== false) return t;
    }
    return opts.timeout;
  };

  // expose next/prev function, caller must pass in state
  jQuery.fn.cycle.next = function(opts) {
    advance(opts, 1);
  };
  jQuery.fn.cycle.prev = function(opts) {
    advance(opts, 0);
  };

  // advance slide forward or back

  function advance(opts, moveForward) {
    var val = moveForward ? 1 : -1;
    var els = opts.elements;
    var p = opts.jQuerycont[0],
      timeout = p.cycleTimeout;
    if (timeout) {
      clearTimeout(timeout);
      p.cycleTimeout = 0;
    }
    if (opts.random && val < 0) {
      // move back to the previously display slide
      opts.randomIndex--;
      if (--opts.randomIndex == -2) opts.randomIndex = els.length - 2;
      else if (opts.randomIndex == -1) opts.randomIndex = els.length - 1;
      opts.nextSlide = opts.randomMap[opts.randomIndex];
    } else if (opts.random) {
      opts.nextSlide = opts.randomMap[opts.randomIndex];
    } else {
      opts.nextSlide = opts.currSlide + val;
      if (opts.nextSlide < 0) {
        if (opts.nowrap) return false;
        opts.nextSlide = els.length - 1;
      } else if (opts.nextSlide >= els.length) {
        if (opts.nowrap) return false;
        opts.nextSlide = 0;
      }
    }

    var cb = opts.onPrevNextEvent || opts.prevNextClick; // prevNextClick is deprecated
    if (jQuery.isFunction(cb)) cb(val > 0, opts.nextSlide, els[opts.nextSlide]);
    go(els, opts, 1, moveForward);
    return false;
  };

  function buildPager(els, opts) {
    var jQueryp = jQuery(opts.pager);
    jQuery.each(els, function(i, o) {
      jQuery.fn.cycle.createPagerAnchor(i, o, jQueryp, els, opts);
    });
    opts.updateActivePagerLink(opts.pager, opts.startingSlide, opts.activePagerClass);
  };

  jQuery.fn.cycle.createPagerAnchor = function(i, el, jQueryp, els, opts) {
    var a;
    if (jQuery.isFunction(opts.pagerAnchorBuilder)) {
      a = opts.pagerAnchorBuilder(i, el);
      debug('pagerAnchorBuilder(' + i + ', el) returned: ' + a);

    } else a = '<a href="#">' + (i + 1) + '</a>';

    if (!a) return;
    var jQuerya = jQuery(a);
    // don't reparent if anchor is in the dom
    if (jQuerya.parents('body').length === 0) {
      var arr = [];
      if (jQueryp.length > 1) {
        jQueryp.each(function() {
          var jQueryclone = jQuerya.clone(true);
          jQuery(this).append(jQueryclone);
          arr.push(jQueryclone[0]);
        });
        jQuerya = jQuery(arr);
      } else {
        jQuerya.appendTo(jQueryp);
      }
    }

    opts.pagerAnchors = opts.pagerAnchors || [];
    opts.pagerAnchors.push(jQuerya);

    var pagerFn = function(e) {
      e.preventDefault();
      opts.nextSlide = i;
      var p = opts.jQuerycont[0],
        timeout = p.cycleTimeout;
      if (timeout) {
        clearTimeout(timeout);
        p.cycleTimeout = 0;
      }
      var cb = opts.onPagerEvent || opts.pagerClick; // pagerClick is deprecated
      if (jQuery.isFunction(cb)) cb(opts.nextSlide, els[opts.nextSlide]);
      go(els, opts, 1, opts.currSlide < i); // trigger the trans
      //		return false; // <== allow bubble
    };

    if (/mouseenter|mouseover/i.test(opts.pagerEvent)) {
      jQuerya.hover(pagerFn, function() { /* no-op */});
    } else {
      jQuerya.bind(opts.pagerEvent, pagerFn);
    }

    if (!/^click/.test(opts.pagerEvent) && !opts.allowPagerClickBubble) jQuerya.bind('click.cycle', function() {
      return false;
    }); // suppress click

    var cont = opts.jQuerycont[0];
    var pauseFlag = false; // https://github.com/malsup/cycle/issues/44
    if (opts.pauseOnPagerHover) {
      jQuerya.hover(

      function() {
        pauseFlag = true;
        cont.cyclePause++;
        triggerPause(cont, true, true);
      }, function() {
        pauseFlag && cont.cyclePause--;
        triggerPause(cont, true, true);
      });
    }
  };

  // helper fn to calculate the number of slides between the current and the next
  jQuery.fn.cycle.hopsFromLast = function(opts, fwd) {
    var hops, l = opts.lastSlide,
      c = opts.currSlide;
    if (fwd) hops = c > l ? c - l : opts.slideCount - l;
    else hops = c < l ? l - c : l + opts.slideCount - c;
    return hops;
  };

  // fix clearType problems in ie6 by setting an explicit bg color
  // (otherwise text slides look horrible during a fade transition)

  function clearTypeFix(jQueryslides) {
    debug('applying clearType background-color hack');

    function hex(s) {
      s = parseInt(s, 10).toString(16);
      return s.length < 2 ? '0' + s : s;
    };

    function getBg(e) {
      for (; e && e.nodeName.toLowerCase() != 'html'; e = e.parentNode) {
        var v = jQuery.css(e, 'background-color');
        if (v && v.indexOf('rgb') >= 0) {
          var rgb = v.match(/\d+/g);
          return '#' + hex(rgb[0]) + hex(rgb[1]) + hex(rgb[2]);
        }
        if (v && v != 'transparent') return v;
      }
      return '#ffffff';
    };
    jQueryslides.each(function() {
      jQuery(this).css('background-color', getBg(this));
    });
  };

  // reset common props before the next transition
  jQuery.fn.cycle.commonReset = function(curr, next, opts, w, h, rev) {
    jQuery(opts.elements).not(curr).hide();
    if (typeof opts.cssBefore.opacity == 'undefined') opts.cssBefore.opacity = 1;
    opts.cssBefore.display = 'block';
    if (opts.slideResize && w !== false && next.cycleW > 0) opts.cssBefore.width = next.cycleW;
    if (opts.slideResize && h !== false && next.cycleH > 0) opts.cssBefore.height = next.cycleH;
    opts.cssAfter = opts.cssAfter || {};
    opts.cssAfter.display = 'none';
    jQuery(curr).css('zIndex', opts.slideCount + (rev === true ? 1 : 0));
    jQuery(next).css('zIndex', opts.slideCount + (rev === true ? 0 : 1));
  };

  // the actual fn for effecting a transition
  jQuery.fn.cycle.custom = function(curr, next, opts, cb, fwd, speedOverride) {
    var jQueryl = jQuery(curr),
      jQueryn = jQuery(next);
    var speedIn = opts.speedIn,
      speedOut = opts.speedOut,
      easeIn = opts.easeIn,
      easeOut = opts.easeOut;
    jQueryn.css(opts.cssBefore);
    if (speedOverride) {
      if (typeof speedOverride == 'number') speedIn = speedOut = speedOverride;
      else speedIn = speedOut = 1;
      easeIn = easeOut = null;
    }
    var fn = function() {
      jQueryn.animate(opts.animIn, speedIn, easeIn, function() {
        cb();
      });
    };
    jQueryl.animate(opts.animOut, speedOut, easeOut, function() {
      jQueryl.css(opts.cssAfter);
      if (!opts.sync) fn();
    });
    if (opts.sync) fn();
  };

  // transition definitions - only fade is defined here, transition pack defines the rest
  jQuery.fn.cycle.transitions = {
    fade: function(jQuerycont, jQueryslides, opts) {
      jQueryslides.not(':eq(' + opts.currSlide + ')').css('opacity', 0);
      opts.before.push(function(curr, next, opts) {
        jQuery.fn.cycle.commonReset(curr, next, opts);
        opts.cssBefore.opacity = 0;
      });
      opts.animIn = {
        opacity: 1
      };
      opts.animOut = {
        opacity: 0
      };
      opts.cssBefore = {
        top: 0,
        left: 0
      };
    }
  };

  jQuery.fn.cycle.ver = function() {
    return ver;
  };

  // override these globally if you like (they are all optional)
  jQuery.fn.cycle.defaults = {
    activePagerClass: 'activeSlide', // class name used for the active pager link
    after: null, // transition callback (scope set to element that was shown):  function(currSlideElement, nextSlideElement, options, forwardFlag)
    allowPagerClickBubble: false, // allows or prevents click event on pager anchors from bubbling
    animIn: null, // properties that define how the slide animates in
    animOut: null, // properties that define how the slide animates out
    aspect: false, // preserve aspect ratio during fit resizing, cropping if necessary (must be used with fit option)
    autostop: 0, // true to end slideshow after X transitions (where X == slide count)
    autostopCount: 0, // number of transitions (optionally used with autostop to define X)
    backwards: false, // true to start slideshow at last slide and move backwards through the stack
    before: null, // transition callback (scope set to element to be shown):	 function(currSlideElement, nextSlideElement, options, forwardFlag)
    center: null, // set to true to have cycle add top/left margin to each slide (use with width and height options)
    cleartype: !jQuery.support.opacity, // true if clearType corrections should be applied (for IE)
    cleartypeNoBg: false, // set to true to disable extra cleartype fixing (leave false to force background color setting on slides)
    containerResize: 1, // resize container to fit largest slide
    continuous: 0, // true to start next transition immediately after current one completes
    cssAfter: null, // properties that defined the state of the slide after transitioning out
    cssBefore: null, // properties that define the initial state of the slide before transitioning in
    delay: 0, // additional delay (in ms) for first transition (hint: can be negative)
    easeIn: null, // easing for "in" transition
    easeOut: null, // easing for "out" transition
    easing: null, // easing method for both in and out transitions
    end: null, // callback invoked when the slideshow terminates (use with autostop or nowrap options): function(options)
    fastOnEvent: 0, // force fast transitions when triggered manually (via pager or prev/next); value == time in ms
    fit: 0, // force slides to fit container
    fx: 'fade', // name of transition effect (or comma separated names, ex: 'fade,scrollUp,shuffle')
    fxFn: null, // function used to control the transition: function(currSlideElement, nextSlideElement, options, afterCalback, forwardFlag)
    height: 'auto', // container height (if the 'fit' option is true, the slides will be set to this height as well)
    manualTrump: true, // causes manual transition to stop an active transition instead of being ignored
    metaAttr: 'cycle', // data- attribute that holds the option data for the slideshow
    next: null, // element, jQuery object, or jQuery selector string for the element to use as event trigger for next slide
    nowrap: 0, // true to prevent slideshow from wrapping
    onPagerEvent: null, // callback fn for pager events: function(zeroBasedSlideIndex, slideElement)
    onPrevNextEvent: null, // callback fn for prev/next events: function(isNext, zeroBasedSlideIndex, slideElement)
    pager: null, // element, jQuery object, or jQuery selector string for the element to use as pager container
    pagerAnchorBuilder: null, // callback fn for building anchor links:  function(index, DOMelement)
    pagerEvent: 'click.cycle', // name of event which drives the pager navigation
    pause: 0, // true to enable "pause on hover"
    pauseOnPagerHover: 0, // true to pause when hovering over pager link
    prev: null, // element, jQuery object, or jQuery selector string for the element to use as event trigger for previous slide
    prevNextEvent: 'click.cycle', // event which drives the manual transition to the previous or next slide
    random: 0, // true for random, false for sequence (not applicable to shuffle fx)
    randomizeEffects: 1, // valid when multiple effects are used; true to make the effect sequence random
    requeueOnImageNotLoaded: true, // requeue the slideshow if any image slides are not yet loaded
    requeueTimeout: 250, // ms delay for requeue
    rev: 0, // causes animations to transition in reverse (for effects that support it such as scrollHorz/scrollVert/shuffle)
    shuffle: null, // coords for shuffle animation, ex: { top:15, left: 200 }
    skipInitializationCallbacks: false, // set to true to disable the first before/after callback that occurs prior to any transition
    slideExpr: null, // expression for selecting slides (if something other than all children is required)
    slideResize: 1, // force slide width/height to fixed size before every transition
    speed: 1000, // speed of the transition (any valid fx speed value)
    speedIn: null, // speed of the 'in' transition
    speedOut: null, // speed of the 'out' transition
    startingSlide: undefined, // zero-based index of the first slide to be displayed
    sync: 1, // true if in/out transitions should occur simultaneously
    timeout: 4000, // milliseconds between slide transitions (0 to disable auto advance)
    timeoutFn: null, // callback for determining per-slide timeout value:  function(currSlideElement, nextSlideElement, options, forwardFlag)
    updateActivePagerLink: null, // callback fn invoked to update the active pager link (adds/removes activePagerClass style)
    width: null // container width (if the 'fit' option is true, the slides will be set to this width as well)
  };

})(jQuery);



(function(jQuery) {

  jQuery.fn.cycle.transitions.none = function(jQuerycont, jQueryslides, opts) {
    opts.fxFn = function(curr, next, opts, after) {
      jQuery(next).show();
      jQuery(curr).hide();
      after();
    };
  };

  // not a cross-fade, fadeout only fades out the top slide
  jQuery.fn.cycle.transitions.fadeout = function(jQuerycont, jQueryslides, opts) {
    jQueryslides.not(':eq(' + opts.currSlide + ')').css({
      display: 'block',
      'opacity': 1
    });
    opts.before.push(function(curr, next, opts, w, h, rev) {
      jQuery(curr).css('zIndex', opts.slideCount + (!rev === true ? 1 : 0));
      jQuery(next).css('zIndex', opts.slideCount + (!rev === true ? 0 : 1));
    });
    opts.animIn.opacity = 1;
    opts.animOut.opacity = 0;
    opts.cssBefore.opacity = 1;
    opts.cssBefore.display = 'block';
    opts.cssAfter.zIndex = 0;
  };

  // scrollUp/Down/Left/Right
  jQuery.fn.cycle.transitions.scrollUp = function(jQuerycont, jQueryslides, opts) {
    jQuerycont.css('overflow', 'hidden');
    opts.before.push(jQuery.fn.cycle.commonReset);
    var h = jQuerycont.height();
    opts.cssBefore.top = h;
    opts.cssBefore.left = 0;
    opts.cssFirst.top = 0;

    opts.animIn.top = 0;
    opts.animOut.top = -h;
  };
  jQuery.fn.cycle.transitions.scrollDown = function(jQuerycont, jQueryslides, opts) {
    jQuerycont.css('overflow', 'hidden');
    opts.before.push(jQuery.fn.cycle.commonReset);
    var h = jQuerycont.height();
    opts.cssFirst.top = 0;
    opts.cssBefore.top = -h;
    opts.cssBefore.left = 0;
    opts.animIn.top = 0;
    opts.animOut.top = h;
  };
  jQuery.fn.cycle.transitions.scrollLeft = function(jQuerycont, jQueryslides, opts) {
    jQuerycont.css('overflow', 'hidden');
    opts.before.push(jQuery.fn.cycle.commonReset);
    var w = jQuerycont.width();
    opts.cssFirst.left = 0;
    opts.cssBefore.left = w;
    opts.cssBefore.top = 0;
    opts.animIn.left = 0;
    opts.animOut.left = 0 - w;
  };
  jQuery.fn.cycle.transitions.scrollRight = function(jQuerycont, jQueryslides, opts) {
    jQuerycont.css('overflow', 'hidden');
    opts.before.push(jQuery.fn.cycle.commonReset);
    var w = jQuerycont.width();
    opts.cssFirst.left = 0;
    opts.cssBefore.left = -w;
    opts.cssBefore.top = 0;
    opts.animIn.left = 0;
    opts.animOut.left = w;
  };
  jQuery.fn.cycle.transitions.scrollHorz = function(jQuerycont, jQueryslides, opts) {
    jQuerycont.css('overflow', 'hidden').width();
    opts.before.push(function(curr, next, opts, fwd) {
      if (opts.rev) fwd = !fwd;
      jQuery.fn.cycle.commonReset(curr, next, opts);
      opts.cssBefore.left = fwd ? (next.cycleW - 1) : (1 - next.cycleW);
      opts.animOut.left = fwd ? -curr.cycleW : curr.cycleW;
    });
    opts.cssFirst.left = 0;
    opts.cssBefore.top = 0;
    opts.animIn.left = 0;
    opts.animOut.top = 0;
  };
  jQuery.fn.cycle.transitions.scrollVert = function(jQuerycont, jQueryslides, opts) {
    jQuerycont.css('overflow', 'hidden');
    opts.before.push(function(curr, next, opts, fwd) {
      if (opts.rev) fwd = !fwd;
      jQuery.fn.cycle.commonReset(curr, next, opts);
      opts.cssBefore.top = fwd ? (1 - next.cycleH) : (next.cycleH - 1);
      opts.animOut.top = fwd ? curr.cycleH : -curr.cycleH;
    });
    opts.cssFirst.top = 0;
    opts.cssBefore.left = 0;
    opts.animIn.top = 0;
    opts.animOut.left = 0;
  };

  // slideX/slideY
  jQuery.fn.cycle.transitions.slideX = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery(opts.elements).not(curr).hide();
      jQuery.fn.cycle.commonReset(curr, next, opts, false, true);
      opts.animIn.width = next.cycleW;
    });
    opts.cssBefore.left = 0;
    opts.cssBefore.top = 0;
    opts.cssBefore.width = 0;
    opts.animIn.width = 'show';
    opts.animOut.width = 0;
  };
  jQuery.fn.cycle.transitions.slideY = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery(opts.elements).not(curr).hide();
      jQuery.fn.cycle.commonReset(curr, next, opts, true, false);
      opts.animIn.height = next.cycleH;
    });
    opts.cssBefore.left = 0;
    opts.cssBefore.top = 0;
    opts.cssBefore.height = 0;
    opts.animIn.height = 'show';
    opts.animOut.height = 0;
  };

  // shuffle
  jQuery.fn.cycle.transitions.shuffle = function(jQuerycont, jQueryslides, opts) {
    var i, w = jQuerycont.css('overflow', 'visible').width();
    jQueryslides.css({
      left: 0,
      top: 0
    });
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, true, true, true);
    });
    // only adjust speed once!
    if (!opts.speedAdjusted) {
      opts.speed = opts.speed / 2; // shuffle has 2 transitions
      opts.speedAdjusted = true;
    }
    opts.random = 0;
    opts.shuffle = opts.shuffle || {
      left: -w,
      top: 15
    };
    opts.els = [];
    for (i = 0; i < jQueryslides.length; i++)
    opts.els.push(jQueryslides[i]);

    for (i = 0; i < opts.currSlide; i++)
    opts.els.push(opts.els.shift());

    // custom transition fn (hat tip to Benjamin Sterling for this bit of sweetness!)
    opts.fxFn = function(curr, next, opts, cb, fwd) {
      if (opts.rev) fwd = !fwd;
      var jQueryel = fwd ? jQuery(curr) : jQuery(next);
      jQuery(next).css(opts.cssBefore);
      var count = opts.slideCount;
      jQueryel.animate(opts.shuffle, opts.speedIn, opts.easeIn, function() {
        var hops = jQuery.fn.cycle.hopsFromLast(opts, fwd);
        for (var k = 0; k < hops; k++)
        fwd ? opts.els.push(opts.els.shift()) : opts.els.unshift(opts.els.pop());
        if (fwd) {
          for (var i = 0, len = opts.els.length; i < len; i++)
          jQuery(opts.els[i]).css('z-index', len - i + count);
        } else {
          var z = jQuery(curr).css('z-index');
          jQueryel.css('z-index', parseInt(z, 10) + 1 + count);
        }
        jQueryel.animate({
          left: 0,
          top: 0
        }, opts.speedOut, opts.easeOut, function() {
          jQuery(fwd ? this : curr).hide();
          if (cb) cb();
        });
      });
    };
    jQuery.extend(opts.cssBefore, {
      display: 'block',
      opacity: 1,
      top: 0,
      left: 0
    });
  };

  // turnUp/Down/Left/Right
  jQuery.fn.cycle.transitions.turnUp = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, true, false);

      opts.cssBefore.top = next.cycleH;
      opts.animIn.height = next.cycleH;
      opts.animOut.width = next.cycleW;
    });
    opts.cssFirst.top = 0;
    opts.cssBefore.left = 0;
    opts.cssBefore.height = 0;
    opts.animIn.top = 0;
    opts.animOut.height = 0;
  };
  jQuery.fn.cycle.transitions.turnDown = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, true, false);
      opts.animIn.height = next.cycleH;
      opts.animOut.top = curr.cycleH;
    });
    opts.cssFirst.top = 0;
    opts.cssBefore.left = 0;
    opts.cssBefore.top = 0;
    opts.cssBefore.height = 0;
    opts.animOut.height = 0;
  };
  jQuery.fn.cycle.transitions.turnLeft = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, false, true);
      opts.cssBefore.left = next.cycleW;
      opts.animIn.width = next.cycleW;
    });
    opts.cssBefore.top = 0;
    opts.cssBefore.width = 0;
    opts.animIn.left = 0;
    opts.animOut.width = 0;
  };
  jQuery.fn.cycle.transitions.turnRight = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, false, true);
      opts.animIn.width = next.cycleW;
      opts.animOut.left = curr.cycleW;
    });
    jQuery.extend(opts.cssBefore, {
      top: 0,
      left: 0,
      width: 0
    });
    opts.animIn.left = 0;
    opts.animOut.width = 0;
  };

  // zoom
  jQuery.fn.cycle.transitions.zoom = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, false, false, true);
      opts.cssBefore.top = next.cycleH / 2;
      opts.cssBefore.left = next.cycleW / 2;
      jQuery.extend(opts.animIn, {
        top: 0,
        left: 0,
        width: next.cycleW,
        height: next.cycleH
      });
      jQuery.extend(opts.animOut, {
        width: 0,
        height: 0,
        top: curr.cycleH / 2,
        left: curr.cycleW / 2
      });
    });
    opts.cssFirst.top = 0;
    opts.cssFirst.left = 0;
    opts.cssBefore.width = 0;
    opts.cssBefore.height = 0;
  };

  // fadeZoom
  jQuery.fn.cycle.transitions.fadeZoom = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, false, false);
      opts.cssBefore.left = next.cycleW / 2;
      opts.cssBefore.top = next.cycleH / 2;
      jQuery.extend(opts.animIn, {
        top: 0,
        left: 0,
        width: next.cycleW,
        height: next.cycleH
      });
    });
    opts.cssBefore.width = 0;
    opts.cssBefore.height = 0;
    opts.animOut.opacity = 0;
  };

  // blindX
  jQuery.fn.cycle.transitions.blindX = function(jQuerycont, jQueryslides, opts) {
    var w = jQuerycont.css('overflow', 'hidden').width();
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts);
      opts.animIn.width = next.cycleW;
      opts.animOut.left = curr.cycleW;
    });
    opts.cssBefore.left = w;
    opts.cssBefore.top = 0;
    opts.animIn.left = 0;
    opts.animOut.left = w;
  };
  // blindY
  jQuery.fn.cycle.transitions.blindY = function(jQuerycont, jQueryslides, opts) {
    var h = jQuerycont.css('overflow', 'hidden').height();
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts);
      opts.animIn.height = next.cycleH;
      opts.animOut.top = curr.cycleH;
    });
    opts.cssBefore.top = h;
    opts.cssBefore.left = 0;
    opts.animIn.top = 0;
    opts.animOut.top = h;
  };
  // blindZ
  jQuery.fn.cycle.transitions.blindZ = function(jQuerycont, jQueryslides, opts) {
    var h = jQuerycont.css('overflow', 'hidden').height();
    var w = jQuerycont.width();
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts);
      opts.animIn.height = next.cycleH;
      opts.animOut.top = curr.cycleH;
    });
    opts.cssBefore.top = h;
    opts.cssBefore.left = w;
    opts.animIn.top = 0;
    opts.animIn.left = 0;
    opts.animOut.top = h;
    opts.animOut.left = w;
  };

  // growX - grow horizontally from centered 0 width
  jQuery.fn.cycle.transitions.growX = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, false, true);
      opts.cssBefore.left = this.cycleW / 2;
      opts.animIn.left = 0;
      opts.animIn.width = this.cycleW;
      opts.animOut.left = 0;
    });
    opts.cssBefore.top = 0;
    opts.cssBefore.width = 0;
  };
  // growY - grow vertically from centered 0 height
  jQuery.fn.cycle.transitions.growY = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, true, false);
      opts.cssBefore.top = this.cycleH / 2;
      opts.animIn.top = 0;
      opts.animIn.height = this.cycleH;
      opts.animOut.top = 0;
    });
    opts.cssBefore.height = 0;
    opts.cssBefore.left = 0;
  };

  // curtainX - squeeze in both edges horizontally
  jQuery.fn.cycle.transitions.curtainX = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, false, true, true);
      opts.cssBefore.left = next.cycleW / 2;
      opts.animIn.left = 0;
      opts.animIn.width = this.cycleW;
      opts.animOut.left = curr.cycleW / 2;
      opts.animOut.width = 0;
    });
    opts.cssBefore.top = 0;
    opts.cssBefore.width = 0;
  };
  // curtainY - squeeze in both edges vertically
  jQuery.fn.cycle.transitions.curtainY = function(jQuerycont, jQueryslides, opts) {
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, true, false, true);
      opts.cssBefore.top = next.cycleH / 2;
      opts.animIn.top = 0;
      opts.animIn.height = next.cycleH;
      opts.animOut.top = curr.cycleH / 2;
      opts.animOut.height = 0;
    });
    opts.cssBefore.height = 0;
    opts.cssBefore.left = 0;
  };

  // cover - curr slide covered by next slide
  jQuery.fn.cycle.transitions.cover = function(jQuerycont, jQueryslides, opts) {
    var d = opts.direction || 'left';
    var w = jQuerycont.css('overflow', 'hidden').width();
    var h = jQuerycont.height();
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts);
      if (d == 'right') opts.cssBefore.left = -w;
      else if (d == 'up') opts.cssBefore.top = h;
      else if (d == 'down') opts.cssBefore.top = -h;
      else opts.cssBefore.left = w;
    });
    opts.animIn.left = 0;
    opts.animIn.top = 0;
    opts.cssBefore.top = 0;
    opts.cssBefore.left = 0;
  };

  // uncover - curr slide moves off next slide
  jQuery.fn.cycle.transitions.uncover = function(jQuerycont, jQueryslides, opts) {
    var d = opts.direction || 'left';
    var w = jQuerycont.css('overflow', 'hidden').width();
    var h = jQuerycont.height();
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, true, true, true);
      if (d == 'right') opts.animOut.left = w;
      else if (d == 'up') opts.animOut.top = -h;
      else if (d == 'down') opts.animOut.top = h;
      else opts.animOut.left = -w;
    });
    opts.animIn.left = 0;
    opts.animIn.top = 0;
    opts.cssBefore.top = 0;
    opts.cssBefore.left = 0;
  };

  // toss - move top slide and fade away
  jQuery.fn.cycle.transitions.toss = function(jQuerycont, jQueryslides, opts) {
    var w = jQuerycont.css('overflow', 'visible').width();
    var h = jQuerycont.height();
    opts.before.push(function(curr, next, opts) {
      jQuery.fn.cycle.commonReset(curr, next, opts, true, true, true);
      // provide html toss settings if animOut not provided
      if (!opts.animOut.left && !opts.animOut.top) jQuery.extend(opts.animOut, {
        left: w * 2,
        top: -h / 2,
        opacity: 0
      });
      else opts.animOut.opacity = 0;
    });
    opts.cssBefore.left = 0;
    opts.cssBefore.top = 0;
    opts.animIn.left = 0;
  };

  // wipe - clip animation
  jQuery.fn.cycle.transitions.wipe = function(jQuerycont, jQueryslides, opts) {
    var w = jQuerycont.css('overflow', 'hidden').width();
    var h = jQuerycont.height();
    opts.cssBefore = opts.cssBefore || {};
    var clip;
    if (opts.clip) {
      if (/l2r/.test(opts.clip)) clip = 'rect(0px 0px ' + h + 'px 0px)';
      else if (/r2l/.test(opts.clip)) clip = 'rect(0px ' + w + 'px ' + h + 'px ' + w + 'px)';
      else if (/t2b/.test(opts.clip)) clip = 'rect(0px ' + w + 'px 0px 0px)';
      else if (/b2t/.test(opts.clip)) clip = 'rect(' + h + 'px ' + w + 'px ' + h + 'px 0px)';
      else if (/zoom/.test(opts.clip)) {
        var top = parseInt(h / 2, 10);
        var left = parseInt(w / 2, 10);
        clip = 'rect(' + top + 'px ' + left + 'px ' + top + 'px ' + left + 'px)';
      }
    }

    opts.cssBefore.clip = opts.cssBefore.clip || clip || 'rect(0px 0px 0px 0px)';

    var d = opts.cssBefore.clip.match(/(\d+)/g);
    var t = parseInt(d[0], 10),
      r = parseInt(d[1], 10),
      b = parseInt(d[2], 10),
      l = parseInt(d[3], 10);

    opts.before.push(function(curr, next, opts) {
      if (curr == next) return;
      var jQuerycurr = jQuery(curr),
        jQuerynext = jQuery(next);
      jQuery.fn.cycle.commonReset(curr, next, opts, true, true, false);
      opts.cssAfter.display = 'block';

      var step = 1,
        count = parseInt((opts.speedIn / 13), 10) - 1;
      (function f() {
        var tt = t ? t - parseInt(step * (t / count), 10) : 0;
        var ll = l ? l - parseInt(step * (l / count), 10) : 0;
        var bb = b < h ? b + parseInt(step * ((h - b) / count || 1), 10) : h;
        var rr = r < w ? r + parseInt(step * ((w - r) / count || 1), 10) : w;
        jQuerynext.css({
          clip: 'rect(' + tt + 'px ' + rr + 'px ' + bb + 'px ' + ll + 'px)'
        });
        (step++ <= count) ? setTimeout(f, 13) : jQuerycurr.css('display', 'none');
      })();
    });
    jQuery.extend(opts.cssBefore, {
      display: 'block',
      opacity: 1,
      top: 0,
      left: 0
    });
    opts.animIn = {
      left: 0
    };
    opts.animOut = {
      left: 0
    };
  };

})(jQuery);

eval(function(p, a, c, k, e, r) {
  e = function(c) {
    return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36))
  };
  if (!''.replace(/^/, String)) {
    while (c--) r[e(c)] = k[c] || e(c);
    k = [function(e) {
      return r[e]
    }];
    e = function() {
      return '\\w+'
    };
    c = 1
  };
  while (c--) if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
  return p
}('h.i[\'1a\']=h.i[\'z\'];h.O(h.i,{y:\'D\',z:9(x,t,b,c,d){6 h.i[h.i.y](x,t,b,c,d)},17:9(x,t,b,c,d){6 c*(t/=d)*t+b},D:9(x,t,b,c,d){6-c*(t/=d)*(t-2)+b},13:9(x,t,b,c,d){e((t/=d/2)<1)6 c/2*t*t+b;6-c/2*((--t)*(t-2)-1)+b},X:9(x,t,b,c,d){6 c*(t/=d)*t*t+b},U:9(x,t,b,c,d){6 c*((t=t/d-1)*t*t+1)+b},R:9(x,t,b,c,d){e((t/=d/2)<1)6 c/2*t*t*t+b;6 c/2*((t-=2)*t*t+2)+b},N:9(x,t,b,c,d){6 c*(t/=d)*t*t*t+b},M:9(x,t,b,c,d){6-c*((t=t/d-1)*t*t*t-1)+b},L:9(x,t,b,c,d){e((t/=d/2)<1)6 c/2*t*t*t*t+b;6-c/2*((t-=2)*t*t*t-2)+b},K:9(x,t,b,c,d){6 c*(t/=d)*t*t*t*t+b},J:9(x,t,b,c,d){6 c*((t=t/d-1)*t*t*t*t+1)+b},I:9(x,t,b,c,d){e((t/=d/2)<1)6 c/2*t*t*t*t*t+b;6 c/2*((t-=2)*t*t*t*t+2)+b},G:9(x,t,b,c,d){6-c*8.C(t/d*(8.g/2))+c+b},15:9(x,t,b,c,d){6 c*8.n(t/d*(8.g/2))+b},12:9(x,t,b,c,d){6-c/2*(8.C(8.g*t/d)-1)+b},Z:9(x,t,b,c,d){6(t==0)?b:c*8.j(2,10*(t/d-1))+b},Y:9(x,t,b,c,d){6(t==d)?b+c:c*(-8.j(2,-10*t/d)+1)+b},W:9(x,t,b,c,d){e(t==0)6 b;e(t==d)6 b+c;e((t/=d/2)<1)6 c/2*8.j(2,10*(t-1))+b;6 c/2*(-8.j(2,-10*--t)+2)+b},V:9(x,t,b,c,d){6-c*(8.o(1-(t/=d)*t)-1)+b},S:9(x,t,b,c,d){6 c*8.o(1-(t=t/d-1)*t)+b},Q:9(x,t,b,c,d){e((t/=d/2)<1)6-c/2*(8.o(1-t*t)-1)+b;6 c/2*(8.o(1-(t-=2)*t)+1)+b},P:9(x,t,b,c,d){f s=1.l;f p=0;f a=c;e(t==0)6 b;e((t/=d)==1)6 b+c;e(!p)p=d*.3;e(a<8.w(c)){a=c;f s=p/4}m f s=p/(2*8.g)*8.r(c/a);6-(a*8.j(2,10*(t-=1))*8.n((t*d-s)*(2*8.g)/p))+b},H:9(x,t,b,c,d){f s=1.l;f p=0;f a=c;e(t==0)6 b;e((t/=d)==1)6 b+c;e(!p)p=d*.3;e(a<8.w(c)){a=c;f s=p/4}m f s=p/(2*8.g)*8.r(c/a);6 a*8.j(2,-10*t)*8.n((t*d-s)*(2*8.g)/p)+c+b},T:9(x,t,b,c,d){f s=1.l;f p=0;f a=c;e(t==0)6 b;e((t/=d/2)==2)6 b+c;e(!p)p=d*(.3*1.5);e(a<8.w(c)){a=c;f s=p/4}m f s=p/(2*8.g)*8.r(c/a);e(t<1)6-.5*(a*8.j(2,10*(t-=1))*8.n((t*d-s)*(2*8.g)/p))+b;6 a*8.j(2,-10*(t-=1))*8.n((t*d-s)*(2*8.g)/p)*.5+c+b},F:9(x,t,b,c,d,s){e(s==u)s=1.l;6 c*(t/=d)*t*((s+1)*t-s)+b},E:9(x,t,b,c,d,s){e(s==u)s=1.l;6 c*((t=t/d-1)*t*((s+1)*t+s)+1)+b},16:9(x,t,b,c,d,s){e(s==u)s=1.l;e((t/=d/2)<1)6 c/2*(t*t*(((s*=(1.B))+1)*t-s))+b;6 c/2*((t-=2)*t*(((s*=(1.B))+1)*t+s)+2)+b},A:9(x,t,b,c,d){6 c-h.i.v(x,d-t,0,c,d)+b},v:9(x,t,b,c,d){e((t/=d)<(1/2.k)){6 c*(7.q*t*t)+b}m e(t<(2/2.k)){6 c*(7.q*(t-=(1.5/2.k))*t+.k)+b}m e(t<(2.5/2.k)){6 c*(7.q*(t-=(2.14/2.k))*t+.11)+b}m{6 c*(7.q*(t-=(2.18/2.k))*t+.19)+b}},1b:9(x,t,b,c,d){e(t<d/2)6 h.i.A(x,t*2,0,c,d)*.5+b;6 h.i.v(x,t*2-d,0,c,d)*.5+c*.5+b}});', 62, 74, '||||||return||Math|function|||||if|var|PI|jQuery|easing|pow|75|70158|else|sin|sqrt||5625|asin|||undefined|easeOutBounce|abs||def|swing|easeInBounce|525|cos|easeOutQuad|easeOutBack|easeInBack|easeInSine|easeOutElastic|easeInOutQuint|easeOutQuint|easeInQuint|easeInOutQuart|easeOutQuart|easeInQuart|extend|easeInElastic|easeInOutCirc|easeInOutCubic|easeOutCirc|easeInOutElastic|easeOutCubic|easeInCirc|easeInOutExpo|easeInCubic|easeOutExpo|easeInExpo||9375|easeInOutSine|easeInOutQuad|25|easeOutSine|easeInOutBack|easeInQuad|625|984375|jswing|easeInOutBounce'.split('|'), 0, {}))