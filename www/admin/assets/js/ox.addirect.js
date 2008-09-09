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

  if ($("#advsignup" + fieldSuffix).get(0).checked)
  {
    if ($("#category" + fieldSuffix).get(0).selectedIndex == 0)
    {
      $("#category" + fieldSuffix).addClass("inerror");
      $("#required-missing" + suffix + errorSuffix).show();
    }
    else
    {
      $("#category" + fieldSuffix).removeClass("inerror");
    }

    if ($("#language" + fieldSuffix).get(0).selectedIndex == 0)
    {
      $("#language" + fieldSuffix).addClass("inerror");
      $("#required-missing" + suffix + errorSuffix).show();
    }
    else
    {
      $("#language" + fieldSuffix).removeClass("inerror");
    }

    if ($("#country" + fieldSuffix).get(0).selectedIndex == 0)
    {
      $("#country" + fieldSuffix).addClass("inerror");
      $("#required-missing" + suffix + errorSuffix).show();
    }
    else
    {
      $("#country" + fieldSuffix).removeClass("inerror");
    }
  }
  else
  {
    $("#country" + fieldSuffix).removeClass("inerror");
    $("#language" + fieldSuffix).removeClass("inerror");
    $("#category" + fieldSuffix).removeClass("inerror");
    $("#required-missing" + suffix + errorSuffix).hide();
  }

  if (customAction)
  {
    customAction(form, suffix, fieldSuffix);
  }

  var result = ($("#url" + fieldSuffix).get(0).value.length > 0) &&
         ( !($("#advsignup" + fieldSuffix).get(0).checked) || (
         $("#category" + fieldSuffix).get(0).selectedIndex > 0 &&
         $("#language" + fieldSuffix).get(0).selectedIndex > 0 &&
         $("#country" + fieldSuffix).get(0).selectedIndex > 0));

  return result;
}


function initCaptchaDialog(dialogId, formId, captchaURL)
{
  var form = $(formId);
  var signupDialog = $("#" + dialogId);

  var onShow = function(hash)
  {
    var captcha = $("#captcha", hash.w);
    var time = new Date().getTime();
    $("#captcha-random").attr("value", time);
    captcha.attr("src", captchaURL + '&t=' +  time);
    hash.w.fadeIn("fast");
    $("input[@name='captcha-value']", signupDialog).get(0).focus();
  };

  signupDialog.jqm(
   { modal: true,
      overlay: 40,
      onShow: onShow}).jqmAddClose($("#dg-cancel", signupDialog));

  if (badCaptcha(formId)) {
    $("#wrong-captcha", signupDialog).show();
    signupDialog.jqmShow();
  }
  else {
    $("#wrong-captcha", signupDialog).hide();
    signupDialog.hide();
  }

  $("#dg-submit", signupDialog).click(function() {
    this.form.submit();
  });
}

//This function search for an JS variable "captchaInError" indicating
//that the provided captcha was wrong.
//For the sake of the prototype it also checks the URL, which should be removed in
//the production code
function badCaptcha(myFormId)
{
  return (window.captchaFormId && window.captchaFormId == myFormId
    && window.captchaInError == true)
    || (document.URL.indexOf("captcha=0") != -1);
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


function isCaptchaRequired()
{
  var form = $("#frmOpenads").get(0);
  var signupRequested = false;

  $(":checkbox[id^=advsignup]", form).each(function() {
    if (this.id != 'advsignup' && this.checked) {
      signupRequested = true;
      return false;
    }
  });

  return signupRequested;
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

function formStateStore(form)
{
  if (document.formState == undefined) {
    document.formState = new Array();
  }
  var formState = document.formState;
  var formSettings = new Array();
  if (form.advsignup) {
    formSettings["advsignup"] =  form.advsignup.checked;
  }
  if (form.country) {
   formSettings["country"] =  form.country.value;
  }
  if (form.language) {
   formSettings["language"] =  form.language.value;
  }
  if (form.category) {
   formSettings["category"] =  form.category.value;
  }

  formState[form.id] = formSettings;
  document.formState = formState;
}

function formStateChanged(form)
{
  if (document.formState == undefined || document.formState[form.id] == undefined ) {
    return false;
  }

  var formSettings = document.formState[form.id];
  var result = false;
  // show captcha if
  // 1) enabling advertiser singup
  result = form.advsignup && !formSettings["advsignup"] && form.advsignup.checked;

  // 2) already signed up and changed cat/lang/cntry
  result = result || (form.advsignup && formSettings["advsignup"] == true &&
    form.advsignup.checked) &&
    ((form.country && formSettings["country"] !=  form.country.value)
      || (form.language  && formSettings["language"] !=  form.language.value)
      || (form.category && formSettings["category"] !=  form.category.value));

  //when unsigning or signed up and no changes do nothing
  return result;
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
function initAccoutSwitcher()
{
  $switcher = $("#oaNavigationExtra .accountSwitcher");
  //$("#oaNavigation").append("<div class='accountSwitcherOverlay'>&nbsp;</div>");
  
  
  $(".triggerContainer").hover(function() {
      $(this).addClass("hover");
    }, function() {
      $(this).removeClass("hover");
  });
  
  
  $(".switchTrigger", $switcher).click(function() {
    $switcher.toggleClass("expanded");
    $(".accountSwitcherOverlay").toggle();
  });
  
  $(".accountsPanel li").hover(function() {
      $this = $(this);
      if (!$this.is(".opt")) { 
        $this.addClass("hover");
      }
    }, function() {
      $(this).removeClass("hover");
  });
  
  $(document).click(function(event) {
    if ($(event.target).parents(".expanded").length == 0) {
      $switcher.removeClass("expanded");
      $(".accountSwitcherOverlay").hide();
    }
  });
  
  $(document).keydown(function(event) {
    if ($(".expanded").length > 0 && event.keyCode == 27) {
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
        electric   : false
    });
    
    Calendar.setup({
       inputField : 'end',
       ifFormat : '%d %B %Y',
       button : 'end_button',
       align : 'Bl',
       weekNumbers: false,
       firstDay : calendarBeginOfWeek,
       electric : false
    });


    //listeners
    var $impressionsField = $("#impressions");
    var $impressionsUnlimitedField = $("#impr_unlimited");
    
    var $clicksField = $("#clicks");
    var $clicksUnlimitedField = $("#click_unlimited");
    
    var $conversionsField =  $("#conversions");
    var $conversionsUnlimitedField = $("#conv_unlimited");
    
    $("#priority-h, #priority-e, #priority-l")
        .click(function() {
              var infoId = 'info-' + this.id;
              $("div[id^='info-priority']").not('#' + infoId).slideFadeOut('slow');
              $('#' + infoId).slideFadeIn('slow');
              updateCampaignTypeForm();
         });
    
    $("#pricing_revenue_type").change(function() {
        updateCampaignPricingSection();
        updateCampaignDateAndLimitsAndType();
    });
    
	
	initCampaignBookedInput($impressionsField, $impressionsUnlimitedField, 'openadsRemainingImpressions');
	initCampaignBookedInput($clicksField, $clicksUnlimitedField,  'openadsRemainingClicks');
	initCampaignBookedInput($conversionsField, $conversionsUnlimitedField);
	
    $("#priority-e, #endSet_immediate, #endSet_specific, #impr_unlimited, #click_unlimited, #conv_unlimited").click(function() {
        updateCampaignDateAndLimitsAndType();
        updateCampaignPrioritySection();
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
    formFormat($impressionsField.get(0));
    formFormat($clicksField.get(0));
    formFormat($conversionsField.get(0));

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

	if (campaignType == CAMPAIGN_TYPE_REMNANT || campaignType == CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE) {
	     $("#excl-limit-date-both-set, #low-limit-date-both-set").hide();
	     
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
        //clear all remnant/exclusive warnings
        $unlimitedCheckboxes.attr("disabled", false);
        $("#endSet_specific").attr("disabled", false);
        $("#impr-disabled-note, #click-disabled-note, #conv-disabled-note").hide();
        $("#date-section-limit-date-set").hide();
        
        //check if both date and limit is set and disable exclusive
        if (campaignType == CAMPAIGN_TYPE_CONTRACT_NORMAL && dateSet && limitClicked) {
            $("#excl-limit-date-both-set, #low-limit-date-both-set").show();
            $("#priority-e, #priority-l").attr("disabled", true);
        }
        else {
            $("#excl-limit-date-both-set, #low-limit-date-both-set").hide();
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
	      formFormat(this);
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
    
    updateCampaignDateAndLimitsAndType();    

    if (campaignType == CAMPAIGN_TYPE_CONTRACT_NORMAL || campaignType == CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE) {
        $allSectionsButPriority.show();
        updateCampaignDateSection();
        updateCampaignPricingSection();
        updateCampaignPrioritySection();                     
    }
    else if (campaignType == CAMPAIGN_TYPE_REMNANT) {
        $allSectionsButPriority.show();
        updateCampaignDateSection();
        updateCampaignPricingSection();
        updateCampaignPrioritySection();                     
    } 
    else {
        //hide all form sections
        $allSectionsButPriority.hide();
        $("#sect_priority_low_excl, #sect_priority_high").hide();
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
        updateCampaignPricingSectionNotes(conversionsField, conversionsField);

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
    
    if (campaignType == CAMPAIGN_TYPE_REMNANT) {
        $highPrioritySection.hide();
        $lowExclPrioritySection.show();
    }
    else if (campaignType == CAMPAIGN_TYPE_CONTRACT_NORMAL || campaignType == CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE) {
	   //if exclusive selected - show weight
	   if (campaignType == CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE) {
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

    if (campaignType == CAMPAIGN_TYPE_CONTRACT_NORMAL || campaignType == CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE) {
	    if (campaignType == CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE && !parseInt($("#weight").val())) {  
	        return confirm (strCampaignWarningExclusiveNoWeight);
	    }
	    else if (campaignType == CAMPAIGN_TYPE_CONTRACT_NORMAL 
	       && $("#endSet_immediate").attr("checked") == true 
            && !parseInt($("#target_value").val()) ) {
        return confirm (strCampaignWarningNoTargetMessage);	    
	    }
    }
    else {
        if (!parseInt($("#weight").val())) {  
            return confirm (strCampaignWarningRemnantNoWeight);
        }
    }
    
    return true;
}


function getCampaignType()
{
    //TODO get type from hidden if no checkboxes visible
    if( $("#priority-h, #priority-e, #priority-l").length > 0) { 

	    if ($("#priority-h").attr("checked") == true) {
	        return CAMPAIGN_TYPE_CONTRACT_NORMAL; 
	    }
	    else if ($("#priority-e").attr("checked") == true) {
	        return CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE;
	    }
	    else if ($("#priority-l").attr("checked") == true) {
	        return CAMPAIGN_TYPE_REMNANT;
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


function formFormat(field)
{
        if ((field.value == '') || (field.value == 0)) {
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
            $(this).siblings('.form').show('normal');
            $(this).parent('li').addClass('expanded');    
        }
        
        function expand() 
        {
                $moreContainer.stop().slideFadeIn('slow');
                $hook.addClass('expanded');
        }
        
        function collapse()
        {
                $container.find("li .form").hide('normal');        
                $moreContainer.stop().slideFadeOut('slow');
                $hook.removeClass('expanded');
        }
        
    });
  };
})(jQuery);
