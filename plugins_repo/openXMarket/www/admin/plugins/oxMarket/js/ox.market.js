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
          unavailableClass: 'unavailable'
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
  };


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
    };
  

  $.fn.campaignMarket = function(options) {
    return this.each(function() {
        var defaults = {
            enableMarketId: "enable_mktplace",
            floorPriceId: "floor_price"
        };
        var settings = $.extend({}, defaults, options);
        
        var $form = $(this);
        
        var $marketSection = $("#sect_market");
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
            
            $("#priority-h, #priority-e, #priority-l", $form).click(onTypeChange);
            $eCPMSpan.bind("ecpmUpdate", function(event, data) {
                    addLastCPMHidden(); 
                    if (data.userTriggered) {
                        updateFloorPrice();
                    }
                });
                
            $("#endSet_immediate, #endSet_specific").click(function() {
                onEndDateChange();
            });                
                
            $floorPriceField.confirmFloorPriceUpdate(function() {
            	if (isECPMEnabled()) {
            		return parseFloat($eCPMSpan.text().replace(/,/, ''));
            	} else {
            		return $revenueField.val();
            	}
            }, function() {
            	return $pricingField.val() == MODEL_CPM;
            });
            
            onTypeChange();            
        }
        
        
        function onEndDateChange()
        {
            var campaignType = getCampaignType();
            var dateSet = $("#endSet_specific").attr('checked');
            if (CAMPAIGN_TYPE_CONTRACT_NORMAL == campaignType) {
                if (dateSet) { 
                    $marketSection.hide();
                    $enableMarketChbx.attr("disabled", true);
                }
                else {
                    $marketSection.show();
                    $enableMarketChbx.attr("disabled", false);
                }
            }
        }        
        
        
        function onTypeChange()
        {
            var campaignType = getCampaignType();
        
            //2.1.1    Contract (Exclusive) campaigns will no longer show the Market checkbox / floor price field.
            if (CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE == campaignType) {
                $marketSection.hide();
                $enableMarketChbx.attr("disabled", true);
            }
            else {
                $marketSection.show();
                $enableMarketChbx.attr("disabled", false);
            }
            //2.1.2    Contract campaigns that have a specified end date will no longer show the Market checkbox / floor price field.
            onEndDateChange();
        
            //if new campaign then disable/enable marketplace optin checbox
            //for existing campaigns do not touch it
            campaignId = $("input[name='campaignid']", $form).val();
            if (campaignId == '') {
                if (CAMPAIGN_TYPE_REMNANT == campaignType || CAMPAIGN_TYPE_ECPM == campaignType) {
                    $enableMarketChbx.attr("checked", true);
                    $enableMarketChbx.trigger("enableMarketplaceClick");
                }
                else if( CAMPAIGN_TYPE_CONTRACT_NORMAL == campaignType) {
                    $enableMarketChbx.attr("checked", false);
                    $enableMarketChbx.trigger("enableMarketplaceClick");
                }
            }
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

            //if eCPM is not enabled
            if (!isECPMEnabled()) {
            
                if (MODEL_CPM == pricing && floorLessThen(currentFloor, currentRevenue)) {
                    $floorPriceField.val(parseFloat(currentRevenue));
                } 
            }
            else {
                var ecpm = $eCPMSpan.text().replace(/,/, '');
                 if (floorLessThen(currentFloor, ecpm)) {
                    $floorPriceField.val(parseFloat(ecpm));
                 }
            }
        }
        
        
        function addLastCPMHidden()
        {
            var $lastECPMHidden = $("#last_ecpm");        
            if ($lastECPMHidden.length === 0) {
                 $form.append('<input type="hidden" name="last_ecpm" id="last_ecpm" value="" />');
                 $lastECPMHidden = $("#last_ecpm");
            }
            $lastECPMHidden.val($eCPMSpan.text().replace(/,/, ''));
        }
        
        
        function setValidatorMessage(message)
        {
            var validator = $form.getValidator();
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
  
  
  $.fn.campaignContractMarket = function(options) {
    return this.each(function() {
        var defaults = {
            impressions_delivered : 0
        };
        var settings = $.extend({}, defaults, options);
        var $form = $(this);        
        
        init();
        
        function init()
        {
          setupCalendars(); 
      
          $("#startSet_immediate, #startSet_specific, #endSet_immediate, #endSet_specific")
              .click(updateCampaignDateSection);
              
          $("#endSet_immediate, #endSet_specific, #impr_unlimited").click(function() {
              updateCampaignPrioritySection();
          });                
              
          initCampaignBookedInput($("#impressions"), $("#impr_unlimited"));
          
         $form.submit(function() {
                 formUnFormat(this.impressions);
    
                 return campaignFormDatesRangeCheck(this) 
                    && campaignFormPriorityCheck(this);
         });
            
          updateCampaignDateSection();
          updateCampaignPricingSection();
          updateCampaignPrioritySection();
        }
        
        
        function setupCalendars()
        {
          //setup calendars
          Calendar.setup({
              inputField : 'start',
              ifFormat   : '%d %B %Y',
              button     : 'start_button',
              align      : 'Bl',
              weekNumbers: false,
              firstDay   : settings.calendarBeginOfWeek,
              electric   : false,
              onUpdate   : function() {
                  $("#start").change();
              }
          });
          
          Calendar.setup({
             inputField : 'end',
             ifFormat : '%d %B %Y',
             button : 'end_button',
             align : 'Bl',
             weekNumbers: false,
             firstDay : settings.calendarBeginOfWeek,
             electric : false,
             onUpdate : function() {
                 $("#end").change();
             }
          });
          
          $("#start")
              .change(function() {
                  campaignFormDateCheck('start');
              });
      
          $("#end")
              .change(function() {
                  campaignFormDateCheck('end');
                  updateCampaignPrioritySection();
              });
        }
        
        
        function updateCampaignDateSection()
        {
            var $startDateSpan = $("#specificStartDateSpan");
            var $endDateSpan = $("#specificEndDateSpan");
        
            if ($("#startSet_immediate").attr("checked") === true) {
                $startDateSpan.hide();
            }
            else {
                $startDateSpan.show();
            }
        
            if ($("#endSet_immediate").attr("checked") === true) {
                $endDateSpan.hide();
            }
            else {
                $endDateSpan.show();
            }
        }

        
        function updateCampaignPricingSection()
        {
                var impressionsField = $("#impressions").get(0);
                var impressionsUnlimitedField = $("#impr_unlimited").get(0);
        
                //now set proper state of booked fields
                campaignFormUnlimitedUpdate(impressionsUnlimitedField, impressionsField, false);
                updateCampaignPricingSectionNotes(impressionsField, impressionsUnlimitedField);
        }
        
        
        function initCampaignBookedInput($input, $unlimitedField, centralRemainingId)
        {
            //set up listeners
            $input
                .focus(function() {
                    formUnFormat(this);
                  })
                .keypress(maskNonNumeric)
                .keyup(function() {
                  updateCampaignPricingSectionNotes(this);
                  updateCampaignPrioritySection();
                  })
                .blur(function() {
                  formFormat(this, true);
                  updateCampaignPricingSectionNotes(this);
                  updateCampaignPrioritySection();
                });
        
            $unlimitedField.click(function() {
                campaignFormUnlimitedUpdate(this, $input.get(0), true);
                updateCampaignPricingSectionNotes($input.get(0), this);
            });
        }
        
        
        function campaignFormUnlimitedUpdate(unlimitedField, limitField, focus)
        {
            if (unlimitedField.checked === true) {
                limitField.value = '-';
                limitField.disabled = true;
            }
            else {
                if (limitField.value == '-') {
                    limitField.value = "";
                }
                limitField.disabled = false;
                if (focus == true) {
                    limitField.focus();
                }
            }
        }
        
                
        function updateCampaignPricingSectionNotes(field, unlimitedField)
        {
            var name = field.name;
            var isUnlimited = unlimitedField !== undefined && unlimitedField.checked;
        
            // Update remaining impressions/click/conversions note
            var $remainingNoteSpan = $('#' +  name + '_remaining_span');
            var delivered = settings[field.name + '_delivered'];
            var booked = field.value;
            if (booked == '-') {
                booked = 0;
            }
            if (!isUnlimited && max_formattedNumberStringToFloat(booked) >= 0) {
                var remaining = max_formattedNumberStringToFloat(booked) - delivered;
                $('#' +  name + '_remaining_count').html(max_formatNumberIgnoreDecimals(remaining));
                $remainingNoteSpan.show();
            }
            else {
                $remainingNoteSpan.hide();
            }
        }
        
        
        function updateCampaignPrioritySection()
        {
           var campaignType = getCampaignType();
        
            // date and limit set distribution will be automatic
            if ($("#endSet_specific").attr("checked") === true && campaignHasLimitSet()) {
                $("#high_distribution_span").hide();
            }
            else { //otherwise ask for limit per day
                $("#high_distribution_span").show();
            }
        }
        
        
        function campaignHasLimitSet()
        {
                var impressionsField = $("#impressions").get(0);
                var impressionsUnlimitedField = $("#impr_unlimited").get(0);
                //not set to unlimited and impr value is fine
                return campaignLimitIsSet(impressionsField, impressionsUnlimitedField);
        }
        
        
        function campaignFormPriorityCheck(form)
        {
          if (($("#endSet_immediate").attr("checked") === true || !campaignHasLimitSet())
              && !parseInt($("#target_value").val()) ) {
              return confirm (settings.strings.strCampaignWarningNoTargetMessage);
          }
        
          return true;
        }        
    });
  };
  
  
  $.fn.zoneMarket = function(options) {
    return this.each(function() {
        var defaults = {
            enableMarketId: "enable_mktplace"
        };
        var settings = $.extend({}, defaults, options);
        
        $marketCheckbox = $('#' + settings.enableMarketId);
        $customSizeRadio = $('#size-c');
        $definedSizeRadio = $('#size-d');
        $widthField = $('#width');
        $heightField = $('#height');
        $bannerZoneRadio = $('#delivery-b');
        $typeRadios = $('input[name=delivery]');
        $sizetypeRadios = $('input[name=sizetype]');
        $sizeSelect = $('#size');
        
        init();
        
        function init()
        {
            $sizetypeRadios.change(updateMarketOptinAvailability);
            $widthField.keyup(updateMarketOptinAvailability);
            $heightField.keyup(updateMarketOptinAvailability);
            $typeRadios.change(updateMarketOptinAvailability);
            $sizeSelect.change(updateMarketOptinAvailability);
            
            if ($.browser.msie) {
                $typeRadios.click(updateMarketOptinAvailability);
                $sizetypeRadios.click(updateMarketOptinAvailability);
            }
            
            
            updateMarketOptinAvailability();
        }
        
        function updateMarketOptinAvailability()
        {
            //market work for banner zone with width and height specified
            if ($bannerZoneRadio.attr("checked") !== true) {   //if other than banner zone is selected 
                $marketCheckbox.attr('disabled', true);
            }
            else {
                if (checkSizeSupported()) {
                    $marketCheckbox.attr('disabled', false);
                }
                else {            
                    $marketCheckbox.attr('disabled', true);
                }
             }
        }
        
        
        function checkSizeSupported()
        {
            var isSupported = false;
            var selectedSize = '';
            
            //custom
            if ($customSizeRadio.attr("checked") === true 
                || ($definedSizeRadio.attr('checked') === true && $sizeSelect.val() == '-')) {
                var width = $.trim($widthField.val());
                var height = $.trim($heightField.val());
                
                selectedSize = width + 'x' +  height;
            }
            //IAB dropdown
            else {
                selectedSize = $sizeSelect.val();
            }
            
            if (settings.sizes[selectedSize] !== undefined) {
                isSupported = true;    
            }
            
            return isSupported;
        }
    });
  };
  
  
  $.fn.advertiserIndex = function(options) {
    return this.each(function() {
        var defaults = {
            showInfo: false
        };
        var settings = $.extend({}, defaults, options);
        
        $threeWays = $('.three-ways-container');
        $threeWaysLink = $('#three-ways-link');
        $advertiserName = $("table tr.systemAdvertiser td span.iconAdvertiserSystem");
        
        init();
        
        function init()
        {
            $advertiserIndexContent = $("#market-advertiser-index");
            $advertiserName.after($advertiserIndexContent);
            $advertiserIndexContent.show();
        
            $threeWaysLink.click(function() {
                updateThreeWaysBox();
            });

            if (settings.showInfo) {
                updateThreeWaysBox();
            }
        }
        
        
        function updateThreeWaysBox()
        {
                //info box is hidden by default and has collapse class set
                //toggling for the firts time
                //- shows container
                //-removes collapse class
                //-adds expand class
                //Subsequent calls do reverse
                $threeWays.toggle();
                $threeWaysLink.toggleClass('expand');
                $threeWaysLink.toggleClass('collapse');
        }
        
    });
  };  
  
  
  $.fn.advertiserCampaigns = function(options) {
    return this.each(function() {
        var defaults = {
            showInfo: false
        };
        var settings = $.extend({}, defaults, options);

        init();
  
        function init()
        {
            $("#campaigns-info-link").expandCollapse({toggledSelector: ".campaigns-info-container"});
        }  
    });
  };  

  $.fn.expandCollapse = function(options) {
      var defaults = {
        };
        var settings = $.extend({}, defaults, options);
        
        return this.each(function() {
            var $this = $(this);
            var $toggled = $(settings.toggledSelector);
            $this.click(updateToggled);
            
            function updateToggled()
            {
                if ($(this).is('.expand')) {
                    $toggled.hide();
                }
                else {
                    $toggled.show();
                }
                $this.toggleClass('expand');
                $this.toggleClass('collapse');
                
                return false;
            }
        });
  }
    

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
  
  
  $.fn.marketOptIn = function(options) {
      var defaults = {
      };
      var settings = $.extend({}, defaults, options);
      var $optIn = this;
      
      // Select campaign if typing its floor price
      $optIn.keyup(function(event) {
          var $target = $(event.target);
          if ($target.is("input.cpm")) {
            if (event.keyCode >= 48 || event.keyCode == 8 || event.keyCode == 46) {
                var $input = $target;
                var $checkbox = $input.parent().parent().find(":checkbox");
                var previous = $checkbox.attr("checked");
                var next = $input.val().length > 0;
                $checkbox.attr("checked", next);
                $checkbox.parents("tr").eq(0).addClass("selected");
            }
          }
      });
      $optIn.keypress(function(event) {
          var $target = $(event.target);
          if ($target.is("input.cpm")) {
            if (event.keyCode == 13) {
            	event.preventDefault();
            	return false;
            }
          }
      });
      
      // AJAX search
      $("#search").typeWatch({callback: function() {
      	refresh('market-campaigns-settings-list.php');
      	},
          wait: 500
      });
      
      // AJAX paging
      $optIn.click(function(event) {
          var $target = $(event.target);
          if ($target.is("a.page")) {
          	// Show a different page
          	refresh($target.attr('href'));
          	return false;
          }
          if ($target.is("a")) {
          	// Select really all
          	if ($target.parent().is("#selectAllCampaigns")) {
                  $("#selectAllCampaigns").hide();
                  $("#allSelected").show();
                  $("#allSelectedHidden").val("true");
                  return false;
          	}
          	
          	// Clear really all selection
          	if ($target.parent().is("#allSelected")) {
                  cancelAllSelection();
                  $optIn.find(":checkbox").attr("checked", false);
                  $optIn.find("tr.selected").removeClass("selected");
                  return false;
          	}
          	
          	// Sorting
          	if ($target.parent().is("th")) {
              	refresh($target.attr('href'));
              	return false;
          	}
          }
      });
      
      // AJAX filtering
      $optIn.find("a.dropDownLink").click(function() {
      	refresh(this.href);
      	$optIn.find(".dropDown").trigger("close").find("span > span").html($(this).text());
      	return false;
      });
      
      $optIn.find(".tableWrapper").bind("multichange", function() {
      	if ($("#toggleAll").is(":checked")) {
      		$("#selectAllContainer, #selectAllCampaigns").show();
      	} else {
      		cancelAllSelection();
      	}
      });
      
	installListeners();
      return this;
      
      function refresh(url) {
      	var ignored = $.extend({
      		'allSelected': true, 
      		'optInSubmit': true, 
      		'optOutSubmit': true 
      	}, getGetParams(url));
      	var data = $optIn.elementValues(null, ignored);
      	data["action"] = "refresh";
      	var $indicator = $("#loading-indicator").attr("title", "").removeClass("ajax-error").fadeIn(200);
		  	$("#thirdLevelTools > div.messagePlaceholder > div.localMessage").hide();
      	$.ajax({
      		data: data,
      		type: 'POST',
      		url: url,
      		success: function(data) {
      		  if (!checkReload(data)) {
      			  if (data.indexOf("<!-- market-quickstart-campaigns -->") >= 0) {
		    		  $("#tableContent").html(data);
		    		  $optIn.find(".tableWrapper").trigger("dataUpdate");
		    		  installListeners();
		    		  $indicator.fadeOut(200);
      			  } else {
      				  showError(data.substring(0, Math.min(data.length, 64)) + "...");
      			  }
      		  }
      		},
      		error: function(XMLHttpRequest, textStatus, errorThrown) {
      			showError();
      		}
      	});
      	
      	function showError(error) {
      		$indicator.attr("title", "Could not load campaigns. Please try again. " + 
      				(error ? "Error: " + error : "")).addClass("ajax-error");
      	}
      }
      
      function cancelAllSelection() {
          $("#selectAllContainer, #selectAllCampaigns, #allSelected").hide();
          $("#allSelectedHidden").val("");
      }
        
      function checkReload(data) {
        if (data.indexOf("<!-- install -->") >= 0 || data.indexOf("<!-- login -->") >= 0) {
          document.location.reload();
          return true;
        }
        return false;
      }
      
      function installListeners() {
          $("#market-cpm-callout").help({
              'parentXOffset' : window.floorPriceColumnContextHelpXOffset || 695,
              'parentYOffset' : window.floorPriceColumnContextHelpXOffset || 500 + ($.browser.msie ? 10 : 0)
              }
          );
          $optIn.find("input.cpm").confirmFloorPriceUpdate(function() {
          	return this.nextAll("input[type=hidden]").eq(0).val();
          });
          
          if ($.browser.msie && $.browser.version < 7) {
            $("button[name=optInSubmit]").click(function() {
            	$("button[name=optOutSubmit]").attr("disabled", "disabled");
            });
            $("button[name=optOutSubmit]").click(function() {
            	$("button[name=optInSubmit]").attr("disabled", "disabled");
            });
          }
      }
      
      function getGetParams(url) {
      	var questionMarkIndex = url.indexOf("?");
      	var params = {};
      	if (questionMarkIndex < 0) {
      		return params;
      	}
      	var paramString = url.substring(questionMarkIndex + 1);
      	var pairs = paramString.split("&");
      	for (var i = 0; i < pairs.length; i++) {
      		var nameValue = pairs[i].split("=");
      		params[nameValue[0]] = nameValue[1];
      	}
      	return params;
      }
  };
  
  $.fn.elementValues = function(allowed, ignored) {
      var values = {};
      this.find(":input").not(":radio:not(:checked)").each(function () {
        var $this = $(this);
        var name = $this.attr("name");
        if (name.indexOf('[') > 0) {
      	  name = name.substring(0, name.indexOf('['));
        }
        if ((allowed && !allowed[name]) || ignored[name]) {
      	  return true;
        }
        if ($this.is(":checkbox")) {
      	  values[$this.attr("name")] = $this.is(":checked") ? 1 : 0;
        } else {
          if (!values[name]) {
            values[name] = [];
          }
          values[name].push($this.val());
        }
      });
      return values ;
  };
})(jQuery);


(function($) {
	  var $dialog = $("#market-floor-price-dialog");
	  var revertCpmCallback;

	  $.fn.confirmFloorPriceDialog = function(cookiePath) {
		  $dialog = $(this);
		  
		  $dontShowCheckbox = $dialog.find("#dont-show-again");
		  $dontShowCheckbox.click(dontShowAgainChanged);
		  dontShowAgainChanged();
		  
		  $dialog.find("#market-keep-entered").click(function() {
		    if ($dontShowCheckbox.attr("checked")) {
		        $.cookie('mqs-floor', 'keep', {expires: null, path: cookiePath} );
		    }
		    hideDialog()
		  });
		  
		  $dialog.find("#market-change-to-cpm").click(function() { 
		    if ($dontShowCheckbox.attr("checked")) {
		        $.cookie('mqs-floor', 'revert', {expires: null, path: cookiePath} );
		    }
		    hideDialog()
		    if (revertCpmCallback) {
		    	revertCpmCallback.call(window);
		    } 
		  });
	  };

	  $.fn.confirmFloorPriceUpdate = function(revertValueCallback, revertCondition) {
		return this.blur(function() {
			var $cpmInput = $(this);
			if ($.data($cpmInput.get(0), 'dialogShown')) {
				return;
			}
			
			var cookie = $.cookie('mqs-floor');
		    if (cookie == 'keep') {
		        return;
		    }
		    if (cookie == 'revert') {
		    	checkAndRevert(false);
		        return;
		    }
	
		    checkAndRevert(true);
		    return;
		    
		    function checkAndRevert(showDialog) {
			    if (!revertCondition || (revertCondition && revertCondition.call(window))) {
			    	var value = $cpmInput.val();
		        	if (value.match(/^\d+\.?\d*$/)) {
			        	var currentValue = parseFloat(value);
			    		var minRecommendedValue = revertValueCallback.call($cpmInput);
			    		if (currentValue < minRecommendedValue) {
			    			if (showDialog) {
						    	revertCpmCallback = revert;
						    	$.data($cpmInput.get(0), 'dialogShown', true);
						    	$dialog.find("#recommended-min-floor-price").html(minRecommendedValue);
						    	// show dialog
							    $dialog.modal({
							        persist: true,
							        overlayCss: { backgroundColor: "#000" },
							        escClose: false
							    });
			    			} else {
			    				revert();
			    			}
			    		}
		        	}
			    }
		    }
		    
		    function revert() {
		    	var minRecommendedValue = revertValueCallback.call($cpmInput);
		    	$cpmInput.val(minRecommendedValue);
		    }
	    }).change(function() {
	    	$.data($(this).get(0), 'dialogShown', false);
	    });
	  }

	  function dontShowAgainChanged() {
		$dialog.find("#market-keep-entered").val(($dontShowCheckbox.attr("checked") ? "Always" : "Yes,") 
	          + " keep the floor price I entered");
		$dialog.find("#market-change-to-cpm").val(($dontShowCheckbox.attr("checked") ? "Always" : "No,") 
	          + " change to campaign's CPM/eCPM");
	  }

	  function hideDialog() {
		$.modal.close()
	  }
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
