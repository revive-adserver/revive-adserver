(function($) {
  $.fn.help = function(s) {
    return this.each(function() {
      new $.fn.helpObject(this, s);              
      });
  };  
  
  $.fn.helpObject = function(help, settings) {
    var defaults = {
      'parentXOffset' : 0,
      'parentYOffset' : 0
    }
    var options = $.extend({ }, defaults, settings);
    
     $(help).hide();
     var $wrapper = wrap($(help));
  	 $("[help='" + help.id + "']").addClass("popup-help-link")
  	   .bind('click', {'elementId' : $wrapper.get(0).id}, show);
  	 $wrapper.click(hide);      
    
      /**
      * Handler to show help elemnt
      * @param object event event object
      * @param int pageX forced X coordinate (optional)
      * @param int pageY forced Y coordinate (optional)
      */
      function show(event, pageX, pageY) 
      {
        var $wrapper = $("#" + event.data['elementId']);
        
        //hide other help popups
        $(".popup-help").fadeOut("fast");
//        var posX = event.pageX - options.parentXOffset; 
//        var posY = event.pageY + 5 - options.parentYOffset;
    
        var clickPosition = getClickPositionInDocument(event, pageX, pageY);
        var posX = clickPosition.X - options.parentXOffset; 
        var posY = clickPosition.Y + 5 - options.parentYOffset;
    
    
        $wrapper.fadeIn("fast").css("display", "block");
        
        var wrapperWidth = $wrapper.outerWidth({ margin: true });
        var wrapperHeight = $wrapper.outerHeight({ margin: true });
        var scrollY = event.pageY - event.clientY; 
        
        var xDiff = $(window).width() - (posX + wrapperWidth + 10); 
        var yDiff = $(window).height() - (posY - scrollY + wrapperHeight);
        
        
        if (xDiff <= 0) {
          posX -= Math.abs(xDiff);
          posX = Math.max(10, posX);
        }
        
        if (yDiff <= 0) {
          posY -= (wrapperHeight + 10);
          posY = Math.max(10 + scrollY, posY);
        }
        
        $wrapper.css({top: posY, left: posX});
      }
  
      function hide()
      {
          $(this).fadeOut("fast");
      }
	
      function wrap($help)
      {
         var $wrapper = $help.wrap("<div class='popup-help'></div>").parent(); 
            $wrapper.attr("id", $help.get(0).id + "wrapper");
            $wrapper.prepend("<div class='close'> <span class='link'>[x]</span> </div>");
            $wrapper.hide();
            $help.addClass("help-content").show();
            return $wrapper;	
      }

  
      function getClickPositionInDocument(e, pageX, pageY)
      {
          //determine x click
          if (e.pageX) {
              clickX = e.pageX;
          }
          else if (pageX) {
              clickX = pageX;
          }
          else if (e.clientX) {
              if (document.documentElement.scrollLeft) {
                  scrollX = document.documentElement.scrollLeft;
              }
              else {
                  scrollX = document.body.scrollLeft;
              }
              clickX = e.clientX + scrollX;
          }
          
          //determine y click 
          if (e.pageY) {
              clickY = e.pageY;
          }
          else if (pageY) {
              clickY = pageY;
          }
          else if (e.clientY) {
              if (document.documentElement.scrollTop) {
                  scrollY = document.documentElement.scrollTop;
              }
              else {
                  scrollY = document.body.scrollTop;
              }
              clickY = e.clientY + scrollY;
          }
          
          if (clickX < 0) {
              clickX = 0;
          }
          if (clickY < 0) { 
              clickY = 0;
          }
          
          return {'X' : clickX, 'Y' : clickY};
      }
  };              
})(jQuery);

(function($) {
  $(document).ready(function(){
    //init help, apply offset for thirdLevelContent to get abs positioning right
    
    $("[id^='help-']").help({
        'parentXOffset' : 200,
        'parentYOffset' : 200
        }
    );
  });
})(jQuery);
