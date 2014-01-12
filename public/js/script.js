/* 
 * Mdular site script
 * @author:     Markus J Doetsch
 * @version:    0.1
 */

var Mdular = {
    debug             : true,
    animationSpeed    : 500,
    time              : new Date().getTime(),
    serverTime        : serverTime || 0
};

Mdular.init = function(){
    Mdular.collapsible('#site');
    Mdular.keepEqualized('header, #main');
}

/* Module: collapsible */
Mdular.collapsible = function(sel){
  var $el = $(sel),
      id = $el.attr('id'),
      btnId = 'collapse-'+id,
      butHtml = '<a href="#" class="btn btn-clean" rel="'+id+'" id="'+btnId+'"><span>&laquo;</span></a>';

  // insert the button
  $el.parent().append(butHtml);
  var $button = $('#'+btnId);

  // listen on the button
  $button.click(function(e){
      Mdular.collapse( $button );
      e.preventDefault();
  });

  // keep scrollbar if overflowing in expanded state
  if(window.innerHeight < $el[0].clientHeight){
    $('body').css({
      'overflow-y' : 'scroll'
    });
  }
}

Mdular.collapse = function($button){
  var $this = $( '#' + $button.attr('rel') ), 
      args = {},
      contentHeight = Mdular.getContentHeight($this, true);

  // set the target height  
  if( !$this.hasClass('collapsed') ){
      args['height'] = 0; //$targetEl.outerHeight(true);
  }else{
      args['height'] = contentHeight;
  }
  
  // animate TODO: use css transition if you can make it work with min-height
  //if(!$('html').hasClass('csstransforms3d')){
    
    $this.animate(args, Mdular.animationSpeed, function () {
      if (args['height'] === contentHeight) {
        $this.css({'height' : 'auto'});
      }
    });
    
  //}
  $this.toggleClass('collapsed');
  $button.toggleClass('active');
  $('#background').toggleClass('inactive');
}

/* equalize */
Mdular.keepEqualized = function (selector) {
  // unfortunately css min-height doesn't inherit well, so we solve it via js
  var $els = $(selector);

  // perform once
  Mdular.equalize($els);

  // listen for & debounce window resize
  Mdular.debounce(window, 'resize', function () {
    Mdular.equalize($els);
  }, 500);
}

Mdular.equalize = function ($els) {
    var height = 0,
        clHeight = document.documentElement.clientHeight;

    $els.css({'min-height' : 0});

    $els.each(function () {
        var h = this.clientHeight;

        if (h > height) {
          height = h;
        }
    });

    // smaller than viewport?
    if (height < clHeight) {
      height = clHeight;
    }

    $els.css({'min-height' : height});
}

/* Tools */
Mdular.debounce = function (target, event, callback, delay) {
    var debounced = false;

    function executeCallback () {
      // return if in debounced state
      if (debounced) {
        return;
      }

      // store debounced state
      debounced = true;

      // setTimeout to run callback & remove debounced state
      setTimeout(function () {

        callback.call(callback);
        debounced = false;
      }, delay);

      // execute callback
      callback.call(callback);
    }

    if (target.addEventListener) {
        target.addEventListener(event, executeCallback, false);
    } else if (target.attachEvent)  {
        target.attachEvent('on' + event, executeCallback);
    }
}

Mdular.getContentHeight = function($targetEl, outerHeight){
    var $this = $targetEl, 
        height = 0;
    
    // iterate over level-1 children
    $this.children().each(function(){
        var elHeight = ( outerHeight === true ? $( this ).outerHeight(true) : $(this).height() );
        if(elHeight > height){
            height = elHeight;
            //if(Mdular.debug) console.log('getContentHeight: ' + $(this).attr('id') + ' : ' + elHeight);
        }
    });
    
    return height;
}

/* Profiler */
Mdular.profiler = function () {
  "use strict";

  var 
  data        = [],
  results     = [],
  startTime   = Mdular.time,
  start       = function (identifier) {
    if (Mdular.profiler.data[identifier]) {
      throw new Error('profile already started for', identifier);
    }
    Mdular.profiler.data[identifier] = new Date();
  },
  end         = function (identifier) {
    if (!Mdular.profiler.data[identifier]) {
      throw new Error('profile not started for', identifier);
    }
    var result = new Date() - Mdular.profiler.data[identifier];
    Mdular.profiler.results[identifier] = result;
  },
  getResults  = function () {
    return results;
  };

  return {
    start       : start,
    end         : end,
    getResults  : getResults
  };
}();

$(document).ready(function(){
  document.documentElement.setAttribute('class', 'js');
  Mdular.init();
  //console.log('server time to init(): ' + Mdular.serverTime + ' (+' + (Mdular.time - Mdular.serverTime) + ')');
}); // /.ready