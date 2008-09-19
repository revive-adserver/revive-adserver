(function($) {
  $.fn.campaignThorium = function() {
    return this.each(function() {
        var o = {
            enableThoriumId: "enable_mktplace",
            floorPriceId: "floor_price"
        };
        
        var $form = $(this);
        var $revenueField = $('#revenue', $form);
        var $pricingField = $('#pricing_revenue_type', $form);

        var $enableThoriumChbx = $('#' + o.enableThoriumId, $form);
        var $floorPriceField = $('#' + o.floorPriceId, $form);
        
        init();
        
        
        function init()
        {
            var mplaceEnabled = $enableThoriumChbx.attr('checked');
            $floorPriceField.attr('disabled', !mplaceEnabled);
            $enableThoriumChbx.click(onEnableMarketplaceClick);
        }
        
        function onEnableMarketplaceClick()
        {
            var mplaceEnabled = $enableThoriumChbx.attr('checked');
            $floorPriceField.attr('disabled', !mplaceEnabled);
            
            if (mplaceEnabled) {
              var pricing = $pricingField.val();
              if (MODEL_CPM == pricing) {
                $floorPriceField.val($revenueField.val());
              }
            }
        }
    });
  };
})(jQuery);

(function($) {
    $.fn.paymentFormThorium = function() {
        return this.each(function() {
            var $form = $(this);
            var $hasTaxId = $("input[@name='hasTaxId']", $form);

            $('#company_reg_no').parent('td').parent('tr').hide().prev('tr').toggle();
            $("input[@name='hasTaxId']").change(onHasTaxClick);
            
            function onHasTaxClick()
            {
                if ($("input[@name='hasTaxId']:checked").val() == 1) { 
                    $('#company_reg_no').parent('td').parent('tr').show().prev('tr').show();
                } else {
                    $('#company_reg_no').parent('td').parent('tr').hide().prev('tr').hide();
                } 
            }
        })
    }
})(jQuery);

function initBidPreferences()  
{
    $(document).ready(function() {
        $("#creative-types input[type=checkbox], #creative-attrs input[type=checkbox]").click(function() {
            if (this.checked) {
                $(this).parent().addClass('rejected');    
            }
            else {
                $(this).parent().removeClass('rejected');
            }
        });
     });
}