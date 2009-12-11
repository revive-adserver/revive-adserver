(function($) {
    $.fn.websiteForm = function(options) {
        return this.each(function() {
            var defaults = {};
            var settings = $.extend({}, defaults, options);
            
            var $form = $(this);
            $websiteURL = $("#url", $form);
            $websiteName = $("#name", $form);
            
            init();
            
            function init()
            {
                $websiteName.focus(buildWebsiteName);
            }
            
            
            function buildWebsiteName()
            {
                    if ($.trim($websiteName.val()) == "") {
                       val = $websiteURL.val();
                       val = val.replace(/^http[s]?:\/\//, "");
                       $websiteName.val(val);
                    }        
            }
        });
    };
    
    
    $.fn.zoneSizesForm = function(options) {
        return this.each(function() {
            var defaults = {};
            var settings = $.extend({}, defaults, options);
            
            var $form = $(this);
            $sizesLink = $("#sizesLink", $form);
            $sizesLine = $("#additionalSizeLine", $form);
            $allSizesShown = $("#allSizesShown", $form);
            
            init();
            
            function init()
            {
                $sizesLink.click(function() {
                    $allSizesShown.val('1');
                    updateAdditionalSizesVisibility();
                    return false;
                });
                
                $('.size-container ol li').hoverIntent({    
                     sensitivity: 5, // number = sensitivity threshold (must be 1 or higher)    
                     interval: 100, // number = milliseconds for onMouseOver polling interval    
                     over: showPreviewLink, // function = onMouseOver callback (REQUIRED)    
                     timeout: 500, // number = milliseconds delay before onMouseOut    
                     out: hidePreviewLink // function = onMouseOut callback (REQUIRED)    
                });
                
                //$('.size-container ol li select').focus(showPreviewLink);    
                
            }
            
            
            function showPreviewLink()
            {
                $context = $(this); 
                if($(this).is('select')) {
                    $context = $context.parent('li');
                }
            
                //console.log('hover in');
                $('label.suffix').hide();
                $('label.suffix', $context).fadeIn(100);
            }

            
            function hidePreviewLink()
            {
                  //console.log('hover out');
                  $('label.suffix', $(this)).hide();
            }
            
            
            function updateAdditionalSizesVisibility()
            {
              if ($allSizesShown.val() == '1') {            
                  $sizesLink.hideFormElement();
                  $sizesLine.showFormElement(true);
              }
              else {
                  $sizesLine.hideFormElement();
                  $sizesLink.showFormElement();
              }
            }
        });
    };
    




})(jQuery);