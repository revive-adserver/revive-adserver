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

        var $enableMarketChbx = $('#' + settings.enableMarketId, $form);
        var $floorPriceField = $('#' + settings.floorPriceId, $form);
        
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
        
        
        function updateFloorPrice()
        {
            var mplaceEnabled = $enableMarketChbx.attr('checked');
            $floorPriceField.attr('disabled', !mplaceEnabled);
            
            if (mplaceEnabled) {
              var pricing = $pricingField.val();
              var currentFloor = $floorPriceField.val();
              var currentRevenue = $revenueField.val();
              var defaultFloor = settings.defaultFloorPrice;
              //if user selected CPM and floor is empty or it has default value allow to override it
              if (MODEL_CPM == pricing && currentRevenue != '' && 
                ($.trim($floorPriceField.val()) == '' || (defaultFloor != '' &&  currentFloor == defaultFloor) )) {
                $floorPriceField.val(currentRevenue);
              }
            }
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
        var $radioButtons = this.find(":radio[@name=optInType]");
        var $remnantRadio = this.find(":radio[@value=remnant]");
        var $selectedRadio = this.find(":radio[@value=selected]");
        $radioButtons.change(updateVisibility);
        if ($.browser.msie) {
            $radioButtons.click(updateVisibility);
        }
        
        this.find("table input.cpm").keyup(function(event) {
            if (event.keyCode >= 48 || event.keyCode == 8 || event.keyCode == 46) {
                var $input = $(this);
                var $checkbox = $input.parent().parent().find(":checkbox");
                var previous = $checkbox.attr("checked");
                var next = $input.val().length > 0;
                $checkbox.attr("checked", next);
                $selectedRadio.attr("checked", true);
                if (previous != next) {
                    updateCount();
                }
            }
        });
        
        this.find(".tableWrapper").bind("multichange", function() {
            $selectedRadio.attr("checked", true);
            updateVisibility.call($optIn.find(":radio:checked"));
            updateCount();
        });
        updateCount();
        updateVisibility.call(this.find(":radio:checked"));
        return this;
        
        function updateCount() {
            if ($selectedRadio.is(":checked")) {
                var count = $optIn.find(".toggleSelection input:checked").size();
                $("#selectedCount").text(count + ' ');
                $("#submit").attr("disabled", count == 0);
            }
        }
        
        function updateVisibility() {
            var value = $(this).val();
            if (value == 'remnant') {
                $("#selectedCount").hide();
                $("#remnantCount, #remnantOptedInCount").show();
                $("#minCpm").attr('disabled', false).focus();
                $("#submit").attr("disabled", false);
            } else {
                $("#selectedCount").show();
                $("#remnantCount, #remnantOptedInCount").hide();
                $("#minCpm").attr('disabled', true);
                updateCount();
            }
        }
    };
})(jQuery);