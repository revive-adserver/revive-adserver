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
      trigger: triggerLinksSelector,
      onShow: function(hash) {
        var ha = hash;
        $("#" + closeIdPrefix + "terms-contents").load(hash.t.href, {}, function() { 
          this.scrollTop = 0;
        });
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
