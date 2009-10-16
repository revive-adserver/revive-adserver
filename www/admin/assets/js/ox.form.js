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
            
            if (isEmpty(settings.rules)) {
                return;
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
                        $nextSibling = $element.next();
                        if ($nextSibling.is("label[for="+$element.attr('id')+"]")) {
                            $error.insertAfter($nextSibling);
                        }
                        else {
		                  $error.insertAfter($element);
                        }
		            }
		        },
                errorContainer: '#errors_' + $this.attr('id'), //errors_{$form.id}
                rules: settings.rules,
                messages: settings.messages
            });
        });
        
        //checkif given object properties are not empty, ignore properties from parent object
        function isEmpty(ob){
          for (var i in ob) { 
            if (ob.hasOwnProperty(i)) {
                return false;
            }
          }
          return true;
        }
    };
})(jQuery);