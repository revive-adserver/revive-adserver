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
    
    var windowWidth = $(window).width();
    var wrapperWidth =  $wrapper.width();
    
    if (posX + wrapperWidth  + 5 > windowWidth) {
      posX -= wrapperWidth  + 30;
      posX = Math.max(10, posX);
    }
     console.log('new posX: ' + posX);
    
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
    $wrapper.prepend("<div class='close'><span class='link'>Close</span></div>");
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
