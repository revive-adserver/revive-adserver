(function($) {
    $.extend({
        activateDropDown: new function() {

            function onToggle(event) {
                event.stopPropagation();
                
                $(this).parent('.dropDown').each(function() {
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');  
                    } else {
                        $(this).addClass('active'); 
                    }
                });
            }
            
            function onClose() {
                $(this).find('.dropDown').each(function() {
                    $(this).removeClass('active');  
                });
            }

			function preventClose(event) {
				event.stopPropagation();
			}

            this.construct = function(settings) {
                return this.each(function() {
                    $(this).children('span').bind('click', onToggle);
                    $(this).children('div.mask').bind('click', onToggle);
                    $(this).children('div.panel').children().bind('click', preventClose);
                    $('body').bind('click', onClose);
                });
            };
        }
    });

    // extend plugin scope
    $.fn.extend({
        activateDropDown: $.activateDropDown.construct
    });

    // extend all forms
    $(document).ready(function() {
        $('.dropDown').activateDropDown();
    });

})(jQuery);
                