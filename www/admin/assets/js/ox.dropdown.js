(function($) {
    $.extend({
        activateDropDown: new function() {
            var active = null;

            function onToggle(event) {
                event.stopPropagation();
                
                $(this).parent('.dropDown').each(function() {
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');  
                        $(this).trigger('dropdownClose');
                        active = null;
                    } else {
                        $(this).addClass('active'); 
                        $(this).trigger('dropdownOpen', [ event.target ]);
                        active = this;
                    }
                });
            }
            
            function onClose() {
                $(active).removeClass('active');  
                $(active).trigger('dropdownClose');
                active = null;
            }
            
            function onKey(event) {
                if (event.keyCode == 27) {
                    onClose();
                }
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
                    $('body').bind('keydown', onKey);
                    $(this).bind("close", onClose);
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
                
