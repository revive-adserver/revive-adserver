// Reimplement using jQuery validation plugin!
function validatePublisher(form, suffix, fieldSuffix, errorSuffix, customAction)
{
  $("#url-empty" + suffix + errorSuffix).hide();
  $("#required-missing" + suffix + errorSuffix).hide();

  if ($("#url" + fieldSuffix).get(0).value.length == 0)
  {
    $("#url" + fieldSuffix).addClass("inerror");
    $("#url-empty" + suffix + errorSuffix).show();
  }
  else
  {
    $("#url" + fieldSuffix).removeClass("inerror");
  }

  if (customAction)
  {
    customAction(form, suffix, fieldSuffix);
  }

  var result = $("#url" + fieldSuffix).get(0).value.length > 0;

  return result;
}


function initInstallerSites()
{
  $("#add-new-site").click(installerAddNewSite);
  $(".remove-site").click(installerRemoveSite);
  $(".site-url").keyup(checkAddSiteEnabled);
  initHelp();
  checkAddSiteEnabled();
}


function installerAddNewSite()
{
  document.lastTabIndex = document.lastTabIndex - 2;
  var maxId = $("#max-id").get(0);
  maxId.value = parseInt(maxId.value) + 1;

  var clone = $("#site-proto").clone(true);
  clone.get(0).id = "site-cont" + maxId.value;
  $("#sites").append(clone).removeClass("one-site");

  $("#url-empty", clone).get(0).id += maxId.value;
  $("#required-missing", clone).get(0).id += maxId.value;
  $(":input", clone).each(function () {
    if ($.trim(this.id).length > 0)
    {
      this.id = this.id + maxId.value;
      this.tabIndex = document.lastTabIndex++;
    }

  });
  $("label", clone).each(function () {
    if ($.trim(this.htmlFor).length > 0)
    {
      this.htmlFor += maxId.value;
    }
  });

  checkAddSiteEnabled();

  $("#add-new-site").get(0).tabIndex = document.lastTabIndex++;
  $("#btn_tagssetup").get(0).tabIndex = document.lastTabIndex++;
}

function installerRemoveSite()
{
  $(this).parents(".site").remove();
  if ($("#sites .site").size() < 2) {
    $("#sites").addClass("one-site");
  }
  checkAddSiteEnabled();
}


function checkAddSiteEnabled()
{
  var enabled = true;
  $("#sites .site-url").each(function(i) {
    if ($.trim(this.value).length == 0 && this.id != 'url')
    {
      enabled = false;
    }
  });

  $("#add-new-site").get(0).disabled = !enabled;
  if (enabled)
  {
    $("#add-new-site-info").fadeOut("fast");
  }
  else
  {
    $("#add-new-site-info").fadeIn("fast");
  }
}


function installerValidateSites()
{
  var maxId = $("#max-id").get(0).value;
  var form = $("#frmOpenads").get(0);
  var valid = true;

  for (var i = 1; i <= maxId; i++)
  {
    if ($("#url" + i).get(0))
    {
      valid = valid && validatePublisher(form, "", i + "", i + "", function(form, suffix, fieldSuffix) {
        if ($("#url" + fieldSuffix).get(0).value.length == 0)
        {
          $("#site-cont" + fieldSuffix).addClass("url-error");
        }
        else
        {
          $("#site-cont" + fieldSuffix).removeClass("url-error");
        }
      });
    }
  }

  return valid;
}


function initInstallerTags()
{
  $("#tag-type").change(tagTypeChanged);
  $("#ad-size").change(adSizeChanged);
  $("#site").change(siteChanged);
  $('pre').bind('mouseover', selectElement);
}


function tagTypeChanged()
{
  if (this.value == "js")
  {
    $("#header-script").show();
  }
  else
  {
    $("#header-script").hide();
  }

  $("pre.invocation-codes:not(." + this.value + ")").hide();
  $("pre.invocation-codes").filter("." + this.value).show();
}


function adSizeChanged()
{
  if (this.value == "*")
  {
    $(".zone-cont").show();
  }
  else
  {
    $(".zone-cont:not(." + this.value + ")").hide();
    $("." + this.value).show();
  }
}


function siteChanged()
{
  if (this.value == "*")
  {
    $(".publisher-cont").show();
  }
  else
  {
    $(".publisher-cont").hide();
    $("#" + this.value).show();
  }
}


function initHelp()
{
  $(".advsignup-help").add(".popup-help-link").click(showHelp);
  $(".popup-help").click(hideOaHelp);
}


function showHelp()
{
  $(".popup-help").hide();

  var $help = $(this).prev();
  if ($(this).attr("help") != undefined) {
  	$help = $("#" + $(this).attr("help"));
  }
  $help.fadeIn("fast").css("display", "inline");
}


function hideOaHelp()
{
  $(this).fadeOut("fast");
}


function selectElement()
{
  if (window.getSelection)
  {


    var r = document.createRange();
    r.selectNodeContents($(this)[0]);
    var s = window.getSelection();
    if (s.rangeCount)
    {
      s.collapseToStart();
      s.removeAllRanges();
    }
    s.addRange(r);
  }
  else if (document.body.createTextRange)
  {
    var r = document.body.createTextRange();
    r.moveToElementText($(this)[0]);
    r.select();
  }
}


/** Advertisers and campaigns **/
function initRejectedOARows()
{
	$(".oa td.sts:contains('Rejected')").each(function() {
    var cell = $(this);
    var statusRow = cell.parents("tr").next("tr").hide();

    cell.css("color", "green").click(function() {
      statusRow.show();
    });
	});
}


function copyValidationConstraints(fromObj, toObj)
{
  toObj.validateCheck = fromObj.validateCheck;
  toObj.validateReq = fromObj.validateReq;
  toObj.validateDescr = fromObj.validateDescr;
}

/** work as **/
function initAccoutSwitcher(searchUrl)
{
  $switcher = $("#oaNavigationExtra .accountSwitcher");
  //$("#oaNavigation").append("<div class='accountSwitcherOverlay'>&nbsp;</div>");

  $switcher.accountswitch({
    searchUrl: searchUrl
  });

  $breadcrumb = $("#thirdLevelHeader > .breadcrumb");

  $(".switchTrigger").hover(function() {
      $(".triggerContainer").addClass("hover");
    }, function() {
      $(".triggerContainer").removeClass("hover");
  });

  $(".switchTrigger, .triggerContainer > a", $switcher).click(function() {
    $breadcrumb.toggleClass("reduced");
    $switcher.toggleClass("expanded");
    $switcher.accountswitch({action: 'show'});
    $(".accountSwitcherOverlay").toggle();
    return false;
  });

  $(".accountsPanel li").hover(function() {
      $this = $(this);
      if (!$this.is(".opt,.more")) {
        $this.addClass("hover");
      }
    }, function() {
      $(this).removeClass("hover");
  });

  $(document).click(function(event) {
    if ($(event.target).parents(".expanded").length == 0) {
      $breadcrumb.removeClass("reduced");
      $switcher.removeClass("expanded");
      $(".accountSwitcherOverlay").hide();
    }
  });

  $(document).keydown(function(event) {
    if ($(".expanded").length > 0 && event.keyCode == 27) {
      $breadcrumb.removeClass("reduced");
      $switcher.removeClass("expanded");
      $(".accountSwitcherOverlay").hide();
    }
    return true;
  });
}


function maskNonNumeric(event)
{
    if (event.charCode && (event.charCode < 48 || event.charCode > 57)) {
        event.preventDefault();
    }
}


// Campaign screen
function initCampaignStatus()
{
    var statusRows = $("[@id^='rsn_row']");
    statusRows.hide();

    if ($("#sts_reject").attr("checked") == true ) {
        statusRows.show();
    }



    $("input[name='status']").click(function(){
        if (this.value == "22") {
            statusRows.show();
        }
        else {
            statusRows.hide();
        }
    });
}


// CAMPAIGN PROPERTIES FUNCTIONS
function initCampaignForm(formId)
{
    //setup calendars
    Calendar.setup({
        inputField : 'start',
        ifFormat   : '%d %B %Y',
        button     : 'start_button',
        align      : 'Bl',
        weekNumbers: false,
        firstDay   : calendarBeginOfWeek,
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
       firstDay : calendarBeginOfWeek,
       electric : false,
       onUpdate : function() {
           $("#end").change();
       }
    });


    //listeners
    var $impressionsField = $("#impressions");
    var $impressionsUnlimitedField = $("#impr_unlimited");

    var $clicksField = $("#clicks");
    var $clicksUnlimitedField = $("#click_unlimited");

    var $conversionsField =  $("#conversions");
    var $conversionsUnlimitedField = $("#conv_unlimited");

    var $pricingField = $("#pricing_revenue_type");
    var $revenueField = $("#revenue");
    var $startDateField = $("#start");
    var $endDateField = $("#end");
    var $priorityField = $("#high_priority_value");
    var $dateFields = $("input[id$='Set_immediate']");

    $("#priority-h, #priority-e, #priority-l")
        .click(function() {
              var infoId = 'info-' + this.id;
              $("div[id^='info-priority']").not('#' + infoId).slideFadeOut('slow');
              $('#' + infoId).slideFadeIn('slow');
              updateCampaignTypeForm();
         });

     $('#weight').keypress(maskNonNumeric);

    $("#pricing_revenue_type").change(function() {
        updateCampaignPricingSection();
        updateCampaignDateAndLimitsAndType();
    });


	initCampaignBookedInput($impressionsField, $impressionsUnlimitedField, 'openadsRemainingImpressions');
	initCampaignBookedInput($clicksField, $clicksUnlimitedField,  'openadsRemainingClicks');
    if ($conversionsField && $conversionsUnlimitedField) {
        initCampaignBookedInput($conversionsField, $conversionsUnlimitedField);
    }

    initEcpmInput($pricingField);
    initEcpmInput($revenueField);
    initEcpmInput($startDateField);
    initEcpmInput($endDateField);
    initEcpmInput($priorityField);
    initEcpmInput($dateFields);
    updateEcpm(false);

    $("#priority-e, #endSet_immediate, #endSet_specific, #impr_unlimited, #click_unlimited, #conv_unlimited").click(function() {
        updateCampaignDateAndLimitsAndType();
        updateCampaignPrioritySection();
    });

    $("#high_priority_value").change(function() {
        updateCampaignTypeForm();
    });

    $("#startSet_immediate, #startSet_specific, #endSet_immediate, #endSet_specific")
        .click(updateCampaignDateSection);


    $("#startSet_immediate").click(function() {
        campaignFormDateReset('start');
    });

    $("#endSet_immediate").click(function() {
        campaignFormDateReset('end');
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

     $("#" + formId).submit(function() {
             formUnFormat(this.impressions);
             formUnFormat(this.clicks);
             formUnFormat(this.conversions);

             return campaignFormPriorityCheck(this)
                 &&  campaignFormDatesRangeCheck(this);
     });

    //update fields states to reflect current values
    formFormat($impressionsField.get(0), true);
    formFormat($clicksField.get(0), true);
    if ($conversionsField) {
        formFormat($conversionsField.get(0), true);
    }

    //show hide sections
    updateCampaignTypeForm();
    updateTypeNotes(true);
}


function updateCampaignDateAndLimitsAndType()
{
    var campaignType = getCampaignType();

    var $limitFields = $("#impressions, #clicks, #conversions");
    var $unlimitedCheckboxes = $("#impr_unlimited, #click_unlimited, #conv_unlimited");

    var dateSet = $("#endSet_specific").attr('checked');
    var limitClicked = false;

	$unlimitedCheckboxes.each(function() {
	   if (this.checked == false) {
	       limitClicked = true;
	       return false; //break the loop
	   }
	});

	if (campaignType == CAMPAIGN_TYPE_REMNANT || campaignType == CAMPAIGN_TYPE_ECPM
        || campaignType == CAMPAIGN_TYPE_OVERRIDE)
    {
	     $("#excl-limit-date-both-set, #low-limit-date-both-set, #ecpm-limit-date-both-set").hide();

	     if (dateSet == true) {
			$limitFields.val("").attr("disabled", "true");
			$unlimitedCheckboxes.attr({
			  checked: true,
			  disabled : true
			});

	        showHideLimitDisabledNotes();
	     }
	     else {
	          $unlimitedCheckboxes.attr("disabled", false);
	          $("#impr-disabled-note, #click-disabled-note, #conv-disabled-note").hide();

		     if (limitClicked) {
		        $("#endSet_specific").attr("disabled", true);
		        $("#date-section-limit-date-set").show();
		     }
		     else {
		        $("#endSet_specific").attr("disabled", false);
		        $("#date-section-limit-date-set").hide();
		     }
	     }
	}
    else { //no type or high
        //clear all remnant/override warnings
        $unlimitedCheckboxes.attr("disabled", false);
        $("#endSet_specific").attr("disabled", false);
        $("#impr-disabled-note, #click-disabled-note, #conv-disabled-note").hide();
        $("#date-section-limit-date-set").hide();

        //check if both date and limit is set and disable override
        if ((campaignType == CAMPAIGN_TYPE_CONTRACT_NORMAL || campaignType == CAMPAIGN_TYPE_CONTRACT_ECPM) && dateSet && limitClicked) {
            $("#excl-limit-date-both-set, #low-limit-date-both-set, #ecpm-limit-date-both-set").show();
            $("#priority-e, #priority-l").attr("disabled", true);
        }
        else {
            $("#excl-limit-date-both-set, #low-limit-date-both-set, #ecpm-limit-date-both-set").hide();
            $("#priority-e, #priority-l").attr("disabled", false);
        }
    }
    updateCampaignPricingSection();
}

function showHideLimitDisabledNotes()
{
	var pricing = $("#pricing_revenue_type").val();
	if (MODEL_CPM == pricing) {
	  $("#click-disabled-note, #conv-disabled-note").hide();
	  $("#impr-disabled-note").show();
	}
	else if (MODEL_CPC == pricing) {
	  $("#impr-disabled-note, #conv-disabled-note").hide();
	  $("#click-disabled-note").show();
	}
	else if (MODEL_CPA == pricing) {
	  $("#impr-disabled-note, #click-disabled-note").hide();
	  $("#conv-disabled-note").show();
	}
	if (MODEL_MT == pricing) {
	    $("#impr-disabled-note, #click-disabled-note, #conv-disabled-note").hide();
	}
}

function initEcpmInput($input)
{
    $input.change(function() {
           updateEcpm(true);
    });
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
        campaignFormUnlimitedUpdate(this, $input.get(0), true, centralRemainingId);
        updateCampaignPricingSectionNotes($input.get(0), this);
    });
}


function updateCampaignTypeForm()
{
    var $allSectionsButPriority = $("#sect_date, #sect_pricing, #sect_cap, #sect_misc");
    var campaignType = getCampaignType();
    var minImpressions = $("[id^='ecpm_min_row']");
    var remnantEcpmNote = $("#remnant_ecpm_note");
    var contractEcpmNote = $("#contract_ecpm_note");

    updateCampaignDateAndLimitsAndType();

    if (campaignType == CAMPAIGN_TYPE_CONTRACT_NORMAL ||
        campaignType == CAMPAIGN_TYPE_OVERRIDE ||
        campaignType == CAMPAIGN_TYPE_CONTRACT_ECPM ||
        campaignType == CAMPAIGN_TYPE_REMNANT ||
        campaignType == CAMPAIGN_TYPE_ECPM) {
        $allSectionsButPriority.show();
        updateCampaignDateSection();
        updateCampaignPricingSection();
        updateCampaignPrioritySection();
    } else {
        //hide all form sections
        $allSectionsButPriority.hide();
        $("#sect_priority_low_excl, #sect_priority_high").hide();
    }
    if(campaignType == CAMPAIGN_TYPE_ECPM || campaignType == CAMPAIGN_TYPE_CONTRACT_ECPM) {
        $("#sect_priority_low_excl").hide();
        $("[id^='sect_priority_ecpm']").show();
    } else {
        $("[id^='sect_priority_ecpm']").hide();
    }
    if (campaignType == CAMPAIGN_TYPE_ECPM) {
        minImpressions.show();
        remnantEcpmNote.show();
        contractEcpmNote.hide();
    } else {
        minImpressions.hide();
        remnantEcpmNote.hide();
        contractEcpmNote.show();
    }
}


function updateTypeNotes(fast)
{
    var infoId = null;

    $("#priority-h, #priority-e, #priority-l").each(function() {
        if (this.checked == true) {
            infoId = 'info-' + this.id;
            return false;
        }
    });

    if (infoId) {
        if (fast == true) {
		    $("div[id^='info-priority']").not('#' + infoId).hide();
		    $('#' + infoId).show();
        }
        else {
		    $("div[id^='info-priority']").not('#' + infoId).slideFadeOut('slow');
		    $('#' + infoId).slideFadeIn('slow');
        }
    }
}


function updateCampaignDateSection()
{
    var $startDateSpan = $("#specificStartDateSpan");
    var $endDateSpan = $("#specificEndDateSpan");

    if ($("#startSet_immediate").attr("checked") == true) {
        $startDateSpan.hide();
    }
    else {
        $startDateSpan.show();
    }

    if ($("#endSet_immediate").attr("checked") == true) {
        $endDateSpan.hide();
    }
    else {
        $endDateSpan.show();
    }
}


function updateCampaignPricingSection()
{
    var pricing = $("#pricing_revenue_type").val();

    var revenueRows = $("[@id^='pricing_revenue_row']");
    var imprRows = $("[@id^='pricing_impr_booked']");
    var clickRows = $("[@id^='pricing_click_booked']");
    var convRows = $("[@id^='pricing_conv_booked']");

    imprRows.hide();
    clickRows.hide();
    convRows.hide();

    if ('' == pricing) {
        revenueRows.hide();
    }
    else if (MODEL_CPM == pricing) {
        var impressionsField = $("#impressions").get(0);
        var impressionsUnlimitedField = $("#impr_unlimited").get(0);

	    //now set proper state of booked fields
	    campaignFormUnlimitedUpdate(impressionsUnlimitedField, impressionsField, false);
	    updateCampaignPricingSectionNotes(impressionsField, impressionsUnlimitedField);

        revenueRows.show();
        imprRows.show();
    }
    else if (MODEL_CPC == pricing) {
	    var impressionsField = $("#impressions").get(0);
	    var impressionsUnlimitedField = $("#impr_unlimited").get(0);
	    var clicksField = $("#clicks").get(0);
	    var clicksUnlimitedField = $("#click_unlimited").get(0);

        campaignFormUnlimitedUpdate(impressionsUnlimitedField, impressionsField, false);
        campaignFormUnlimitedUpdate(clicksUnlimitedField, clicksField);
        updateCampaignPricingSectionNotes(impressionsField, impressionsUnlimitedField);
        updateCampaignPricingSectionNotes(clicksField, clicksUnlimitedField);

        revenueRows.show();
        clickRows.show();
        imprRows.show();
    }
    else if (MODEL_CPA == pricing) {
        var impressionsField = $("#impressions").get(0);
        var impressionsUnlimitedField = $("#impr_unlimited").get(0);
        var clicksField = $("#clicks").get(0);
        var clicksUnlimitedField = $("#click_unlimited").get(0);
        var conversionsField =  $("#conversions").get(0);
        var conversionsUnlimitedField = $("#conv_unlimited").get(0);

        campaignFormUnlimitedUpdate(impressionsUnlimitedField, impressionsField, false);
        campaignFormUnlimitedUpdate(clicksUnlimitedField, clicksField, false);
        campaignFormUnlimitedUpdate(conversionsUnlimitedField, conversionsField, false);

        updateCampaignPricingSectionNotes(impressionsField, impressionsUnlimitedField);
        updateCampaignPricingSectionNotes(clicksField, clicksUnlimitedField);
        updateCampaignPricingSectionNotes(conversionsField, conversionsUnlimitedField);

        revenueRows.show();
        convRows.show();
        clickRows.show();
        imprRows.show();
    }
    else if (MODEL_MT == pricing) {
        revenueRows.show();
    }
}


function updateCampaignPrioritySection()
{
    var $highPrioritySection = $("#sect_priority_high");
    var $lowExclPrioritySection = $("#sect_priority_low_excl");
    var campaignType = getCampaignType();

    if (campaignType == CAMPAIGN_TYPE_REMNANT || campaignType == CAMPAIGN_TYPE_ECPM) {
        $highPrioritySection.hide();
        if (campaignType == CAMPAIGN_TYPE_REMNANT) {
            $lowExclPrioritySection.show();
        }
    }
    else if (campaignType == CAMPAIGN_TYPE_CONTRACT_NORMAL || campaignType == CAMPAIGN_TYPE_OVERRIDE || campaignType == CAMPAIGN_TYPE_CONTRACT_ECPM) {
	   //if override selected - show weight
	   if (campaignType == CAMPAIGN_TYPE_OVERRIDE) {
	        $highPrioritySection.hide();
	        $lowExclPrioritySection.show();
	   }
	   else { //high
	        $lowExclPrioritySection.hide();
	        // date and limit set distribution will be automatic
	        if ($("#endSet_specific").attr("checked") == true
	           && campaignHasAnyLimitSet()) {
                $("#high_distribution_span").hide();
	        }
	        else { //otherwise ask for limit per day
                $("#high_distribution_span").show();
	        }
	        $highPrioritySection.show();
	   }
    }
}


function campaignHasAnyLimitSet()
{
    var pricing = $("#pricing_revenue_type").val();

    if ('' == pricing) {
        return false;
    }
    else if (MODEL_CPM == pricing) {
        var impressionsField = $("#impressions").get(0);
        var impressionsUnlimitedField = $("#impr_unlimited").get(0);
        //not set to unlimited and impr value is fine
        return campaignLimitIsSet(impressionsField, impressionsUnlimitedField);
    }
    else if (MODEL_CPC == pricing) {
        var impressionsField = $("#impressions").get(0);
        var impressionsUnlimitedField = $("#impr_unlimited").get(0);
        var clicksField = $("#clicks").get(0);
        var clicksUnlimitedField = $("#click_unlimited").get(0);

        return campaignLimitIsSet(impressionsField, impressionsUnlimitedField)
            || campaignLimitIsSet(clicksField, clicksUnlimitedField);
    }
    else if (MODEL_CPA == pricing) {
        var impressionsField = $("#impressions").get(0);
        var impressionsUnlimitedField = $("#impr_unlimited").get(0);
        var clicksField = $("#clicks").get(0);
        var clicksUnlimitedField = $("#click_unlimited").get(0);
        var conversionsField =  $("#conversions").get(0);
        var conversionsUnlimitedField = $("#conv_unlimited").get(0);

        return campaignLimitIsSet(impressionsField, impressionsUnlimitedField)
            || campaignLimitIsSet(clicksField, clicksUnlimitedField)
            || campaignLimitIsSet(conversionsField, conversionsUnlimitedField);
    }
    else if (MODEL_MT == pricing) {
        return false;
    }
}


function campaignLimitIsSet(input, unlimitedInput)
{
    return unlimitedInput.checked == false
            && input.value != '' && input.value != '-'
}


function campaignFormPriorityCheck(form)
{
    var campaignType = getCampaignType();

    if (campaignType == CAMPAIGN_TYPE_CONTRACT_NORMAL || campaignType == CAMPAIGN_TYPE_OVERRIDE
        || campaignType == CAMPAIGN_TYPE_CONTRACT_ECPM)
    {
	    if (campaignType == CAMPAIGN_TYPE_OVERRIDE && !parseInt($("#weight").val())) {
	        return confirm (strCampaignWarningOverrideNoWeight);
	    }
	    else if (campaignType != CAMPAIGN_TYPE_OVERRIDE
            && ($("#endSet_immediate").attr("checked") == true || !campaignHasAnyLimitSet())
            && !parseInt($("#target_value").val()) ) {
            return confirm (strCampaignWarningNoTargetMessage);
	    }
    }
    if (campaignType == CAMPAIGN_TYPE_REMNANT) {
        if (!parseInt($("#weight").val())) {
            return confirm (strCampaignWarningRemnantNoWeight);
        }
    }
    if (campaignType == CAMPAIGN_TYPE_ECPM || campaignType == CAMPAIGN_TYPE_CONTRACT_ECPM) {
        if (!parseFloat($("#revenue").val()) || parseFloat($("#revenue").val()) <= 0) {
            return confirm (strCampaignWarningEcpmNoRevenue);
        }
    }

    return true;
}


function getCampaignType()
{
    //TODO get type from hidden if no checkboxes visible
    if( $("#priority-h, #priority-e, #priority-l").length > 0) {

	    if ($("#priority-h").attr("checked") == true) {
            if (($("[@name=contract_ecpm_enabled]").val() == 1) &&
                $("#high_priority_value").val() >= PRIORITY_ECPM_FROM &&
                $("#high_priority_value").val() <= PRIORITY_ECPM_TO) {
                return CAMPAIGN_TYPE_CONTRACT_ECPM;
            } else {
                return CAMPAIGN_TYPE_CONTRACT_NORMAL;
            }
	    }
	    else if ($("#priority-e").attr("checked") == true) {
	        return CAMPAIGN_TYPE_OVERRIDE;
	    }
	    else if ($("#priority-l").attr("checked") == true) {
            if ($("[@name=remnant_ecpm_enabled]").val() == 1) {
                return CAMPAIGN_TYPE_ECPM;
            } else {
                return CAMPAIGN_TYPE_REMNANT;
            }
	    }

	    return null;
	}
	else {
	   return $("#campaign_type").val();
	}
}


function campaignFormDatesRangeCheck(form)
{
    var activeDate;
    var expireDate;
    var activation_enabled = isDateSetActive('start', form);
    var expiry_enabled = isDateSetActive('end', form);
    // No sense in comparing inactive values
    if  (activation_enabled) {
        activateDate = newDateFromNamedFields(document, form, 'start');
        if (!activateDate) {
            alert('The start date of this campaign is not a valid date');
            return false;
        }
    }
    if (expiry_enabled) {
        expireDate = newDateFromNamedFields(document, form, 'end');
        if (!expireDate) {
            alert('The end date of this campaign is not a valid date');
            return false;
        }
    }
    if (activation_enabled && expiry_enabled) {
        if  (!isDateEqual(activateDate, expireDate) && isDateBefore(expireDate, activateDate)) {
            alert('The selected dates for this campaign are invalid\n(Campaign ends before it starts!).\n');
            return false;
        }
    }
    return true;
}




function campaignFormDateCheck(elemName)
{
    var date = $("#" + elemName).val();
    if (date == '') {
        $("[@name='" + elemName + "Set']").get(0).checked = true;
    }
    else {
        $("[@name='" + elemName + "Set']").get(1).checked = true;
    }
    updateCampaignDateSection();
}


function campaignFormDateReset(elemToReset)
{
            $("#" + elemToReset).val('');
}


function formFormat(field, allowzero)
{
        if (typeof(allowzero) == 'undefined') { allowzero = false; }
        if ((field.value == '') || (field.value == 0 && allowzero == false)) {
            field.value = '-';
        }
        if (field.value != '-') {
            field.value = max_formatNumberIgnoreDecimals(field.value);
        }
}


function formUnFormat(field)
{
	if (field.value != '-' && field.value != '') {
	    field.value = max_formattedNumberStringToFloat(field.value);
	}
	else {
	    field.value = '';
	}
}

(function($) {
  $.fn.expandableContainer = function() {
    return this.each(function() {
        var o = {
            hookClass: "more-less",
            moreContainerClass: "moreContainer"
        };

        var $container = $(this);
        var $moreContainer = $('.' + o.moreContainerClass, $container);
        var $hook = $('.' + o.hookClass, $container);


        //hide more content until requested
        $moreContainer.hide();
        $hook.show();

        $container.find("li a.hasForm").click(showForm);

        //bind listeners
        $hook.toggle(expand, collapse);
        //$container.hover(expand, collapse);


        function showForm()
        {
			if (jQuery.browser.msie && parseInt(jQuery.browser.version) == 6) {
			    $(this).siblings('.form').show();
			}
			else {
                $(this).siblings('.form').show('normal');
            }
            $(this).parent('li').addClass('expanded');
        }

        function expand()
        {
                if (jQuery.browser.msie && parseInt(jQuery.browser.version) == 6) {
                    $moreContainer.stop().show();
                }
                else {
                    $moreContainer.stop().slideFadeIn('normal');
                }

                $hook.addClass('expanded');
        }

        function collapse()
        {
                $container.find("li .form").hide('normal');
                if (jQuery.browser.msie && parseInt(jQuery.browser.version) == 6) {
                    $moreContainer.stop().hide();
                }
                else {
                    $moreContainer.stop().slideFadeOut('normal');
                }
                $hook.removeClass('expanded');
        }

    });
  };
})(jQuery);

(function($) {
  $.fn.selectText = function() {
    return this.each(function() {

        $(this).bind('mousedown', selectText)
                .bind('click', selectText)
                .bind('mousemove', selectText);

		function selectText()
		{
		    $(this).select();
		}
    });
  };
})(jQuery);

(function($) {
  $.fn.selectFile = function() {
    return this.each(function() {
        $form = $(this);



    });
  };
})(jQuery);

