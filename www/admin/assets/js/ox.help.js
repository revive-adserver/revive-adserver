(function($) {
  $.fn.help = function(s) {
    return this.each(function() {
      new $.fn.helpObject(this, s);              
      });
  };  
  
  $.fn.helpObject = function(help, settings) {
   $(help).hide();
   var $wrapper = wrap($(help));
	 $("[help='" + help.id + "']").addClass("popup-help-link")
	   .bind('click', {'elementId' : $wrapper.get(0).id}, show);
	 $wrapper.click(hide);      
  };
  
  function show(event) {
    var $wrapper = $("#" + event.data['elementId']);
    
    //hide other help popups
    $(".popup-help").fadeOut("fast");
    var posX = event.pageX;
    var posY = event.pageY + 5;

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
	
})(jQuery);

(function($) {
  $(document).ready(function(){
    $("[id^='help-']").help();
  });
})(jQuery);
