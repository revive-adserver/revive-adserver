/** 
 * Javascript required for Ad Networks screens
 *
 * Important: this code depends on jQuery.
 */

function initInlineEdit()
{
  $("span.start-edit").click(startInlineEdit);
  $("span.save-edit").click(saveInlineEdit);
  $("span.cancel-edit").click(cancelInlineEdit);
//  $("input.adn-cb").change(startInlineEdit);
}

function startInlineEdit()
{
  if (!$(this).is(".start-edit"))
  {
    return;
  }
  $("span.start-edit").not(this).removeClass("start-edit link").addClass("start-edit-disabled");
  $(this).parents("tr.inline-edit").removeClass("view").addClass("edit");
}

function cancelInlineEdit()
{
  $("span.start-edit-disabled").removeClass("start-edit-disabled").addClass("start-edit link");
  $(this).parents("tr.inline-edit").removeClass("edit").addClass("view");

  // Clear validation
  $("#url-empty").hide();
  $("#required-missing").hide();
}

function saveInlineEdit()
{
  var form = $(this).parents("tr.inline-edit").children().get(0);
  if (validatePublisher(form, "")) 
  {
    $("span.start-edit-disabled").removeClass("start-edit-disabled").addClass("start-edit link");
  
    $("#adnetworks-signup-dialog_" + $(form).attr("id")).jqmShow();
  }
}

// Reimplement using jQuery validation plugin!
function validatePublisher(form, suffix)
{
  $("#url-empty" + suffix).hide();
  $("#required-missing" + suffix).hide();

  if (form.url && form.url.value.length == 0) 
  {
    $(form.url).addClass("error");
    $("#url-empty" + suffix).show();
  }

  if (form.adnetworks.checked) 
  {
    if (form.category.selectedIndex == 0) 
    {
      $(form.category).addClass("error");
      $("#required-missing" + suffix).show();
    }

    if (form.language.selectedIndex == 0) 
    {
      $(form.language).addClass("error");
      $("#required-missing" + suffix).show();
    }

    if (form.country.selectedIndex == 0) 
    {
      $(form.country).addClass("error");
      $("#required-missing" + suffix).show();
    }
  }

  return (form.url.value.length > 0) && 
         (!form.adnetworks.checked || (
         form.category.selectedIndex > 0 &&
         form.language.selectedIndex > 0 &&
         form.country.selectedIndex));
}



function initPublisherAdd()
{
  $("#add-publisher").click(validateNewPublisher);
}


function validateNewPublisher()
{
  if (validatePublisher(this.form, "-form")) 
  {
    /*this.form.submit();*/

    $("#adnetworks-signup-dialog_" + $(this.form).attr("id")).jqmShow();
  }
}


function initAdNetworksSignup(formId)
{
  var form = $(formId);

  var signupDialog = $("#adnetworks-signup-dialog_" + formId);
    signupDialog
    .jqm({modal: true})
    .jqmAddTrigger("#adnetworks-submit")
    .jqmAddClose("#cancel", signupDialog);

  if (badCaptcha(formId)) {
    $("#wrong-captcha", signupDialog).show();
    signupDialog.jqmShow();
  }
  else {
    $("#wrong-captcha", signupDialog).hide();
    signupDialog.hide();
  }

  //Note to dev: remove the code below, when the captcha is in error 
  //provide hidden 'captcha' field in the form in the rendered response
  //We will look for that hidden in the form instead of the URL 
  $("#submit", signupDialog).click(function() {
    var value = this.form['captcha-value'].value;
      if ("following" != value) { 
        var separator = "?";
        if (document.url.indexOf("?") != -1) {
          separator = "&";
        }

        var action = document.URL + separator + 'captcha=0' + $(form).attr("id");
        $(this.form).attr("action", action);
      }
      else {
        var action = document.URL;
        action = action.substring(0, action.indexOf("captcha=0"));
        $(this.form).attr("action", action);
      }
      return true;
  });
}

//This function search for an JS variable "captchaInError" indicating
//that the provided captcha was wrong.
//For the sake of the prototype it also checks the URL, which should be removed in
//the production code
function badCaptcha(myFormId) 
{
  return (window.captchaFormId && window.captchaFormId == myformId 
    && window.captchaInError == true)
    || document.URL.indexOf("captcha=0") != -1; 
}


function initFindOtherNetworks()
{
  $("#findnetworksform select").change(function() {
    var country = $("select#country").attr("value");
    var language = $("select#language").attr("value");
    $.get("./ajax-response-find-other-networks.html",
      { country: country, language: language }, 
      function(html) {
        $("#other-networks-table").empty().append(html);
      }
    );
  });
}

function initInstallerSites()
{
  $("#add-new-site").click(installerAddNewSite);
  $("input.remove-site").click(installerRemoveSite);
  $(".site-url").keyup(checkAddSiteEnabled);
}

function installerAddNewSite()
{
  var maxId = $("#max-id").get(0);
  maxId.value = parseInt(maxId.value) + 1;

  var clone = $("#site-proto").clone(true);
  $(":input", clone).each(function () {
    if ($.trim(this.name).length > 0) 
    {
      this.name = this.name + maxId.value;
    }
  });
  $("#sites").append(clone).removeClass("one-site");
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
    if ($.trim(this.value).length == 0)
    {
      enabled = false;
    }
  });

  var b = $("#add-new-site").get(0).disabled = !enabled;
  if (enabled)
  {
    $("#add-new-site-info").fadeOut("fast");
  }
  else
  {
    $("#add-new-site-info").fadeIn("fast");
  }
}
