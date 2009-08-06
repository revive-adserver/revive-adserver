(function($) {
  $.fn.marketSignup = function(options) {
        var defaults = {
            captchaBaseUrl: '',
            captchaRandomName: 't'
        };
        var settings = $.extend({}, defaults, options);
        var $form = $(this);
        var $accountModeRadios =  $("input[name=accountMode]");
        $accountModeRadios.click(updateForm);
        
        $("#captcha-image", $form).captcha({
            baseUrl: settings.captchaBaseUrl,
            reloadElemSelector : "#captcha-reload",
            randomHiddenSelector: "input[name=captchaRandom]",
            randomKeyName: settings.captchaRandomName
        });
        
        $("#m_new_username", $form).userNameCheck({
          userNameCheckUrl: settings.usernameCheckUrl,
          userNameParameterName: 'userName',
          checkTimeout: 500,
          availableResultText: 'available',
          unavailableResultText: 'taken',
          indicatorSelector: '#user-check-indicator',
          availableClass: 'available',
          unavailableClass: 'unavailable',
          callback: updateSubmitButton
        });
        
        updateForm();
        
        
        function updateForm()
        {
            $("[id^=line-]").hide();
            
            var selectedId = $accountModeRadios.filter(":checked").attr("id");
            
            if (selectedId) {
                $("[id^=line-" + selectedId + "]").show();
                $("[id^=line-account-both]").show();
            }
            
            if (this.id == 'account-login') {
                $("#m_username").focus();   
            }
            else {
                $("#m_new_email").focus();
            }
        }
        
        
        function updateSubmitButton(texElement, userNameAvailable) {
            /*if (userNameAvailable) {
                $("#save", $form).attr("disabled", false);
                $("#userhint", $form).fadeOut();
            } 
            else {
                $("#save", $form).attr("disabled", true);
                $("#userhint", $form).fadeIn();
            }*/
        };
  }


    $.fn.captcha = function(options) {
        var defaults = {
            reloadElemSelector : '',
            baseUrl: '',
            randomKeyName: 'reload',
            randomHiddenSelector: ''
        };
        var settings = $.extend({}, defaults, options);
        $image = $(this);
        
        var captchaUrl = settings.baseUrl != '' ? settings.baseUrl : $image.attr("src");
        var separator  = captchaUrl.indexOf("?") == -1 ? "?" : "&";

        if (settings.reloadElemSelector) {
            $(settings.reloadElemSelector).click(reloadCaptcha);
        }
        
        function reloadCaptcha()
        {
                var random = new Date().getTime();
                var reloadUrl = captchaUrl 
                    + separator
                    + settings.randomKeyName +"=" + random; 
                
                $image.attr("src", reloadUrl);
                
                if (settings.randomHiddenSelector != '') {
                    $(settings.randomHiddenSelector).val(random);
                }
                
                return false;
        }
    }
  

  $.fn.campaignMarket = function(options) {
    return this.each(function() {
        var defaults = {
            enableMarketId: "enable_mktplace",
            floorPriceId: "floor_price"
        };
        var settings = $.extend({}, defaults, options);
        
        var $form = $(this);
        var $revenueField = $('#revenue', $form);
        var $pricingField = $('#pricing_revenue_type', $form);
        var $eCPMSpan = $("#ecpm_val"); 

        var $enableMarketChbx = $('#' + settings.enableMarketId, $form);
        var $floorPriceField = $('#' + settings.floorPriceId, $form);
        var validNumberCheck = /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/;
        
        init();
        
        
        function init()
        {
            var mplaceEnabled = $enableMarketChbx.attr('checked');
            $floorPriceField.attr('disabled', !mplaceEnabled);
            $enableMarketChbx.click(updateFloorPrice);
            $enableMarketChbx.bind('enableMarketplaceClick', updateFloorPrice);
            $revenueField.blur(updateFloorPrice);
            $("#pricing_revenue_type").change(updateFloorPrice);
            
            $("#priority-h, #priority-e, #priority-l", $form).click(onTypeClick);
            $eCPMSpan.bind("ecpmUpdate", function(event, data) {
                    addLastCPMHidden(); 
                    if (data.userTriggered) {
                        updateFloorPrice();
                    }
                });
            
            //register custom validation method used to validate floor price agains CMP, eCPM
            //note that the message is not used - it will be overridden in validateFloorPrice
            jQuery.validator.addMethod("floor_price_compare", validateFloorPrice,     
                "Floor price must greater or equal to  CPM (or eCPM if used)"); //DUMMY message, not used
        }
        
        
        function onTypeClick()
        {
            var campaignType = getCampaignType();
        
            //if new campaign then disable/enable marketplace optin checbox
            //for existing campaigns do not touch it
            campaignId = $("input[name='campaignid']", $form).val();
            if (campaignId == '') {
                if (CAMPAIGN_TYPE_REMNANT == campaignType || CAMPAIGN_TYPE_ECPM == campaignType) {
                    $enableMarketChbx.attr("checked", true);
                    $enableMarketChbx.trigger("enableMarketplaceClick");
                }
                else if( CAMPAIGN_TYPE_CONTRACT_NORMAL == campaignType || CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE == campaignType) {
                    $enableMarketChbx.attr("checked", false);
                    $enableMarketChbx.trigger("enableMarketplaceClick");
                }
            }
        }
        
        
        function validateFloorPrice(value, element)
        {
            var mplaceEnabled = $enableMarketChbx.attr('checked');
            $floorPriceField.attr('disabled', !mplaceEnabled);
            
            if (!mplaceEnabled) {
                return true;
            }
            var pricing = $pricingField.val();
            var currentFloor = $.trim(value).replace(/,/, '');
            var currentRevenue = $.trim($revenueField.val()).replace(/,/, '');

//            console.log("VAL pricing:|"+pricing+"|, currentFloor:|"+currentFloor+"|, revenue:|"+currentRevenue);
            
                        //if eCPM is not enabled
            if (!isECPMEnabled()) {
//              console.log("VAL compare:|"+(currentFloor < currentRevenue));
              if (MODEL_CPM == pricing && floorLessThen(currentFloor, currentRevenue)) {
//                 console.log("invalid floor (R)" + currentFloor + " < " + currentRevenue);
                 setValidatorMessage(settings.floorValidationRateMessage);
                  return false;
              }  
            }
            else {
//               console.log("VAL compare (e):|"+(currentFloor < ecpm));
                var ecpm = $eCPMSpan.text().replace(/,/, '');
                if (floorLessThen(currentFloor, ecpm)) {
//                    console.log("invalid floor (E) " + currentFloor + " < " + ecpm);
                    setValidatorMessage(settings.floorValidationECPMMessage);
                    return false;
                }
            }
            
            return true;
        }
        
        
        function updateFloorPrice()
        {
            var mplaceEnabled = $enableMarketChbx.attr('checked');
            $floorPriceField.attr('disabled', !mplaceEnabled);
            
            if (!mplaceEnabled) {
                return;
            }
            var pricing = $pricingField.val();
            var currentFloor = $.trim($floorPriceField.val()).replace(/,/, '');
            var currentRevenue = $.trim($revenueField.val()).replace(/,/, '');
            var defaultFloor = settings.defaultFloorPrice;

//            console.log("pricing:|"+pricing+"|, currentFloor:|"+currentFloor+"|, revenue:|"+currentRevenue+"|, defaultFloor:|"+defaultFloor+"|");
          
            //if eCPM is not enabled
            if (!isECPMEnabled()) {
//                console.log("compare:|"+(currentFloor < currentRevenue));
            
                if (MODEL_CPM == pricing && floorLessThen(currentFloor, currentRevenue)) {
//                   console.log("setting floor from " + currentFloor + " to " + currentRevenue);
                    $floorPriceField.val(parseFloat(currentRevenue));
                } 
            }
            else {
                var ecpm = $eCPMSpan.text().replace(/,/, '');
//                console.log("compare (e):|"+(currentFloor < ecpm));
                 if (floorLessThen(currentFloor, ecpm)) {
//                   console.log("setting floor from (E)" + currentFloor + " to " + ecpm);
                    $floorPriceField.val(parseFloat(ecpm));
                 }
            }
        }
        
        
        function addLastCPMHidden()
        {
            var $lastECPMHidden = $("#last_ecpm")        
            if ($lastECPMHidden.length == 0) {
                 $form.append('<input type="hidden" name="last_ecpm" id="last_ecpm" value="" />');
                 $lastECPMHidden = $("#last_ecpm");
            }
            $lastECPMHidden.val($eCPMSpan.text().replace(/,/, ''));
        }
        
        
        function setValidatorMessage(message)
        {
            var validator = $form.getValidator()
            var floorPriceName = $floorPriceField.attr("name");
            messages = validator.settings.messages[floorPriceName];
            
            var messages = $.extend({}, messages, { 'floor_price_compare' : message });
            
            validator.settings.messages[floorPriceName] = messages; 
        }
                
        
        function floorLessThen(currentFloor, comparedValue)
        {
          var numbersValid = validNumberCheck.test(comparedValue) && validNumberCheck.test(currentFloor);
          
          if (numbersValid) {
              comparedValue = parseFloat(comparedValue);
              currentFloor = parseFloat(currentFloor);
          } 
          if (comparedValue != '' && numbersValid && (currentFloor < comparedValue)) {
            return true;
          }
          return false;  
        }
        
        function isECPMEnabled()
        {
            return $eCPMSpan.length > 0 && $eCPMSpan.height() > 0;        
        }
    });
  };
})(jQuery);


(function($) {
    $.fn.updateSelection = function(options) {
        var defaults = {
            selectedClass: "selected"
        };
        var settings = $.extend({}, defaults, options);
    
        return this.each(function() {
        
            var $this = $(this);
            $this.click(updateSelection);
            
            function updateSelection()
            {
                if (this.checked) {
                    $this.parent().addClass(settings.selectedClass);    
                }
                else {
                    $this.parent().removeClass(settings.selectedClass);
                }
            }
        });
    };
})(jQuery);


(function($) {
    $.fn.marketOptIn = function(options) {
        var defaults = {
        };
        var settings = $.extend({}, defaults, options);
        var $optIn = this;
        
        this.find("table input.cpm").keyup(function(event) {
            if (event.keyCode >= 48 || event.keyCode == 8 || event.keyCode == 46) {
                var $input = $(this);
                var $checkbox = $input.parent().parent().find(":checkbox");
                var previous = $checkbox.attr("checked");
                var next = $input.val().length > 0;
                $checkbox.attr("checked", next);
            }
        });
        
        $("#market-info-box-close").click(function() {
        	$optIn.find(".info-box").fadeOut(300, function() {
        		$optIn.find(".mainOptionContent").removeClass("has-info-box");
        		$.cookie("market-settings-info-box-hidden", true, {expires: 365 * 10});
        	});
        	return false;
        });
        
        return this;
    };
})(jQuery);

(function($) {
  $.fn.getValidator = function() {
     if (this.length == 0) {
        return null;
     }
     var form = this[0];
     var validator = jQuery.data(form, 'validator');
     
     return validator;
  };
})(jQuery);


(function($) {
  $.fn.addRule = function(rules) {
     if (this.length == 0) {
        return this;
     }
     var element = this[0];
     var validator = jQuery.data(element.form, 'validator');
     var existingRules = validator.settings.rules[element.name] 
      ||  (validator.settings.rules[element.name] = {});
     $.extend(existingRules, rules);
  };
})(jQuery);