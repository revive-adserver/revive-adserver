(function($) {
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