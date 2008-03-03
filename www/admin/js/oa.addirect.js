/**
 * Utility methods. To be refactored to a separate JS file once we
 * have JS merging/minification done.
 */

// Turns an input into an autosubmit one
jQuery.fn.submitOnChange = function() {
  return this.each(function ()
  {
    $(this).bind("change", function()
    {
      if (this.form) {
        this.form.submit();
      }
    });
  });
};

// All inputs marked with "submit-on-change" class will be
// automatically turned into autosubmit inputs
$(document).ready(function() {
  $("select.submit-on-change").submitOnChange();
});

// Additional jQuery effect
jQuery.fn.slideFadeOut = function(speed, callback)
{
  return this.animate({height: 'hide', opacity: 'hide', marginTop: 'hide', marginBottom: 'hide'}, speed, callback);
}

// Additional jQuery effect
jQuery.fn.slideFadeIn = function(speed, callback)
{
  return this.animate({height: 'show', opacity: 'show', marginTop: 'show', marginBottom: 'show'}, speed, callback);
}

// Automatically installs validation on forms with the "validate" class
// Also adds some custom validation rules
$(document).ready(function () {
  // The validation plugin does not apply the validate() function to
  // all jQuery elements (kind of weird...), so we must use an explicit each()
  $("form.validate").each(function() {
    $(this).validate();
  });
});

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


/** 
 * A function for making dialog-confirmed links. Note that
 * configuration-dialog.html must be included which contains
 * the actual confirmation dialog code.
 */
jQuery.fn.confirmedLink = function(triggerLinkClass, closeIdPrefix)
{
  $("#" + closeIdPrefix + "confirmation-dialog").jqm({
      modal: true,
      overlay: 40,
      trigger: "." + triggerLinkClass,
      onShow: function(hash) {
        $("#" + closeIdPrefix + "cd-submit").one("click", function() {
          location.href = hash.t.href;
        });
        hash.w.fadeIn("fast");
      }
  }).jqmAddClose("#" + closeIdPrefix + "cd-cancel");
}

/**
 * Converts the provided links (pointing at legal documents) into
 * a modal popup displaying the same contents.
 */
jQuery.terms = function(triggerLinksSelector, closeIdPrefix) {
  $("#" + closeIdPrefix + "terms-dialog").jqm({
      modal: true,
      overlay: 40,
      trigger: "." + triggerLinksSelector,
      onShow: function(hash) {
        var ha = hash;
        $("#" + closeIdPrefix + "terms-contents").load(hash.t.href);
        $("#" + closeIdPrefix + "terms-title").html("&nbsp;&nbsp;" + hash.t.title);
        $("#" + hash.t.id + "c").attr("checked", false);
        $("#" + closeIdPrefix + "terms-submit").one("click", function() {
          $("#" + hash.t.id + "c").attr("checked", true);
          $("#" + closeIdPrefix + "terms-dialog").jqmHide();
        });
        hash.w.fadeIn("fast");
      }
  }).jqmAddClose("#" + closeIdPrefix + "terms-cancel");
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
    return true;
  });
  
  $(document).keydown(function(event) {
    if ($(".expanded").length > 0 && event.keyCode == 27) {
      $switcher.removeClass("expanded");
      $(".accountSwitcherOverlay").hide();
    }
    return true;
  });
}



