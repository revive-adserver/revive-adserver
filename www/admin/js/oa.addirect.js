/**
 * Important: this code depends on jQuery.
 */

// Reimplement using jQuery validation plugin!
function validatePublisher(form, suffix, fieldSuffix, errorSuffix, customAction)
{
  // For now, we only need to check URL, which is optional so we can return true
  return true;
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
  var maxId = $("#max-id").get(0);
  maxId.value = parseInt(maxId.value) + 1;

  var clone = $("#site-proto").clone(true);
  clone.get(0).id = "site-cont" + maxId.value;
  $("#sites").append(clone).removeClass("one-site");

  $("#url-empty", clone).get(0).id += maxId.value;
  $(":input", clone).each(function () {
    if ($.trim(this.id).length > 0)
    {
      this.id = this.id + maxId.value;
    }

  });
  $("label", clone).each(function () {
    if ($.trim(this.htmlFor).length > 0)
    {
      this.htmlFor += maxId.value;
    }
  });

  checkAddSiteEnabled();
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

  $(":checkbox[id^=selfsignup]", form).each(function() {
    if (this.id != 'selfsignup' && this.checked) {
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
  $(".selfsignup-help").add(".popup-help-link").click(showHelp);
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
  if (form.selfsignup) {
    formSettings["selfsignup"] =  form.selfsignup.checked;
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
  result = form.selfsignup && !formSettings["selfsignup"] && form.selfsignup.checked;
    
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


/** Affiliate delete dialog */
function initAffiliateDeleteDialog()
{
  $("#affiliate-delete-dialog").jqm({
      modal: true,
      overlay: 40,
      trigger: ".ad-delete-show",
      onShow: function(hash) {
        var pubId = $(".affId", hash.t).text();
        var pubForm = $("#pub_form_" + pubId).get(0);
        $(".deleted-affiliate", hash.w).text(pubForm.websiteUrl.value);
        var delForm = $("#affiliate_delete_form").get(0);
        delForm.affiliateid.value = pubId;
        delForm.deleteall.checked = false;
        hash.w.fadeIn("fast");
      } 
  }).jqmAddClose("#ad-cancel");
}


function copyValidationConstraints(fromObj, toObj)
{
  toObj.validateCheck = fromObj.validateCheck;
  toObj.validateReq = fromObj.validateReq;
  toObj.validateDescr = fromObj.validateDescr;
}
