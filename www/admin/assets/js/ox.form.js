(function($) {
    $.fn.initForm = function(options) {
        var defaults = {
            rules: {},
            messages: {}
        };
        var settings = $.extend({}, defaults, options);
    
        return this.each(function() {
            var $this = $(this);
            
            if (!$this.is("form")) {
                return true;
            }
            
            $this.validate({
                event: "keyup",
                focusInvalid: true,
		        errorPlacement: function($error, $element) {
		            if ($element.is("input[type=checkbox]") || $element.is("input[type=radio]")) {
		                $nextSibling = $element.next();
                        if ($nextSibling.is("label")) {
                            $error.insertAfter($nextSibling);
                            $("<br>").insertAfter($nextSibling);
                        }
                        else {
                            $error.insertAfter($element);
                        }
		            }
		            else {
		                $error.insertAfter($element);
		            }
		        },
                errorContainer: '#errors',
                rules: settings.rules,
                messages: settings.messages
            });
        });
    };
})(jQuery);