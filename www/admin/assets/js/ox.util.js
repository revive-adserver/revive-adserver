/**
 * Turns an input into an autosubmit one
 */
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

/**
 * All inputs marked with "submit-on-change" class will be
 * automatically turned into autosubmit inputs.
 */
$(document).ready(function() {
  $("select.submit-on-change").submitOnChange();
});

/**
 * Turns the selected ordinary links into popup-dialog-confirmed links. If the 
 * dialog is confirmed, the links href will be loaded. Otherwise, nothing will happen.
 */
jQuery.fn.confirmed = function(dialogSelector, mainButtonLabel, mainButtonClass) {
  return this.each(function() {
    $(this).click(function() {
      var $link = $(this);
      
      var buttons = { };
      buttons[mainButtonLabel] = function() {
        location.href = $link.attr("href");
        $(this).dialog("close");
      };
      buttons['Cancel'] = function() {
        $(this).dialog("close");
      };
      
      $(dialogSelector).find("#title-placeholder").html($link.attr("title") + " ");
      $(dialogSelector).dialog({
        modal: true, 
        overlay: { 
            opacity: 0.5, 
            background: "black" 
        },
        buttons: buttons,
        close: function() {
          $(this).dialog("destroy");
        },
        width: 600,
        height: 140
      });
      
      // Modify the layout a bit
      $(".ui-dialog-titlebar-close > span").html("&nbsp;");
      if (mainButtonClass) {
        $(".ui-dialog-buttonpane > button:eq(0)").addClass(mainButtonClass);
      }
      
      $(dialogSelector).show();
      
      return false;
    });
  });
};

jQuery.fn.showWithOverlay = function(zIndex) {
    var $this = this;
    var $overlay = $("#bg-ovlay");
    if ($overlay.size() == 0) {
      $overlay = $("<div id='bg-ovlay' style='position: absolute; top: 0; bottom: 0; left: 0; right: 0; z-index: " + zIndex + " '></div>");
      $overlay.prependTo("body").click(function() {
        $this.hide();
        $overlay.remove();
      });
    }
    
    return this.show();
};

jQuery.removeOverlay = function() {
   $("#bg-ovlay").remove();
} 

/**
 * Animated show with vertical-only sizing.
 */
jQuery.fn.slideFadeOut = function(speed, callback)
{
  return this.animate({height: 'hide', opacity: 'hide', marginTop: 'hide', marginBottom: 'hide'}, speed, callback);
};

/**
 * Animated hide with vertical-only sizing.
 */
jQuery.fn.slideFadeIn = function(speed, callback)
{
  return this.animate({height: 'show', opacity: 'show', marginTop: 'show', marginBottom: 'show'}, speed, callback);
};

/**
 * Animated hide with horizontal-only sizing.
 */
jQuery.fn.sweepFadeIn = function(speed, callback)
{
  return this.animate({width: 'show', opacity: 'show', marginLeft: 'show', marginLeft: 'show'}, speed, callback);
};

/**
 * Select text in textarea or select on mouse events
 */
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


/**
 * Select text in html elements eg. div, pre  on mouse events. Keeps only one
 * selection active at the time
 */
(function($) {
  $.fn.selectElement = function() {
    return this.each(function() {
    
        $(this).bind('mousedown', selectElementText)
                .bind('click', selectElementText)
                .bind('mousemove', selectElementText);
        
        function selectElementText() {
            if (window.getSelection) {
                var r = document.createRange();
                r.selectNodeContents($(this)[0]);
                var s = window.getSelection();
                if (s.rangeCount) {
                    s.collapseToStart();
                    s.removeAllRanges();
                }
                s.addRange(r);
            } 
            else if (document.body.createTextRange) {
                var r = document.body.createTextRange();
                r.moveToElementText($(this)[0]);
                r.select();
            }
        }
    });
  };
})(jQuery);


/**
 * Custom hide function, which will animate element using slideUp method when 
 * animate is set. Animate is ignored in IE browsers due to the crappy
 * IE implemenation
 */
$.fn.hideElement = function(animate, callback) 
{
    if (!jQuery.browser.msie && animate) {
        this.stop().slideUp(300, callback);
    }
    else {
        this.hide();
    }
    return this;
}


/**
 * Custom show function, which will animate element using slideUp method when 
 * animate is set. Animate is ignored in IE browsers due to the crappy
 * IE implemenation
 */
$.fn.showElement = function(animate, callback)
{
    if (!jQuery.browser.msie && animate) {
        this.stop().slideDown(300, callback);
    }
    else {
        this.show();
    }
    return this;
}

/**
 * Dispatches calls to hideElement() or showElement() based on the 'visible' parameter.
 */
$.fn.setElementVisible = function(visible, animate, callback) 
{
    if (visible) {
        return this.showElement(animate, callback);
    } else {
        return this.hideElement(animate, callback);
    }
}

/**
 * Controls element's visibility using the CSS visibility property (visible / hidden).
 */
$.fn.setElementVisibility = function(visible)
{ 
  return this.css("visibility", (visible ? "visible" : "hidden"));
}


/**
 *
 */
$.fn.indicator = function (action, text, message) {
  return this.each(function() {
    var $this = $(this);
    var currentText = '';
    var currentMessage = '';
    
    if (action == 'saved') {
      currentText = 'Changes saved';
      $this.removeClass('iconLoading iconWarning').addClass('iconConfirm').show();
      window.setTimeout(function() { $this.fadeOut(200); }, 4000);
    } else if (action == 'error') {
      currentText = 'Error';
      currentMessage = 'An error has occurred, please try again';
      $this.addClass('iconWarning').removeClass('iconConfirm iconLoading').show();
    } else {
      currentText = 'Loading...';
      $this.addClass('iconLoading').removeClass('iconConfirm iconWarning').show();
    }
    
    if (typeof text != 'undefined') {
      $this.html(text);
    } else {
      $this.html(currentText);
    }
        
    if (typeof message != 'undefined') {
      $this.attr('title', message);
    } else {
      $this.attr('title', currentMessage);
    }
  });
} 


$.fn.disableLink = function(message) {
  return this.each(function() {
    var $this = $(this);
    $this.attr("hrefbak", $this.attr("href"));
    $this.attr("disabled", true);
    $this.removeAttr("href");
    $this.addClass("disabled");
    if (typeof message != 'undefined') {
      $this.attr("titlebak", $this.attr("title"));
      $this.attr("title", message);
    }
  });
};

$.fn.enableLink = function() {
  return this.each(function() {
    var $this = $(this);
    $this.attr("href", $this.attr("hrefbak"))
    $this.removeAttr("hrefbak").removeAttr("disabled");
    $this.removeClass("disabled");
    $this.attr("title", $this.attr("titlebak"));
  });
};

$.fn.disabledClick = function(callback) {
  return this.each(function() {
    var $this = $(this);
    $this.click(function() {
      if (!$this.attr("disabled")) {
        return callback.call($this.get(0));
      } else {
        return false;
      }
    });
  });
};

$.fn.synchronizedCheckboxes = function() {
  var $checkboxes = this;
  this.change(function() {
    var $this = $(this);
    $checkboxes.not($this).attr('checked', $this.is(":checked"));
  });
  return this;
};



// Shows or hides an element depending on the parameter
jQuery.fn.visible = function(visible)
{
  return this.each(function() {
    if (visible) {
      $(this).show();
    }
    else {
      $(this).hide();
    }
  });
};

// Shows or hides an element depending on the parameter
jQuery.fn.selectedText = function(visible)
{
  if (this.size() == 0) {
    return;
  }
  var select = this[0];
  return select.options[select.selectedIndex].text; 
};

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
};

/**
 * Converts the provided links (pointing at legal documents) into
 * a modal popup displaying the same contents.
 */
jQuery.terms = function(triggerLinksSelector, closeIdPrefix) {
  if($.browser.msie && (parseInt($.browser.version) == 6)) {
    // Fall back to opening in a new window on IE6.
    return this;
  }
 
  $("#" + closeIdPrefix + "terms-dialog").jqm({
      modal: true,
      overlay: 40,
      trigger: triggerLinksSelector,
      onShow: function(hash) {
        var windowHeight = $(window).height();
        var topOffset = 0.15;
        var extraHeader = 70;
        var $termsContents = $("#" + closeIdPrefix + "terms-contents");
        $termsContents.height(windowHeight * (1 - 2 * topOffset) - extraHeader);
        
        $termsContents.html("<a href='" + hash.t.href + "' target='_blank'>" + hash.t.title + "</a>");
        $termsContents.load(hash.t.href, null, function() { 
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
};

/**
 * To the first selected checkbox attaches an event handler that shows/hides the
 * provided content depending on whether the checkbox is checked or not.
 */
jQuery.fn.toggleContent = function(checkedContentSelector, uncheckedContentSelector) {
  return this.eq(0).click(function() {
    if (this.checked) {
      $(checkedContentSelector).show();
      $(uncheckedContentSelector).hide();
    } else {
      $(checkedContentSelector).hide();
      $(uncheckedContentSelector).show();
    }
  }).end();
};

/**
 * Make the height of the content box at least as high as the inner height of the window
 */
$(document).ready(function () {
							
  function resizeContentBox() {
	  $("#thirdLevelContent").each(function() {
		  var offset = document.documentElement.clientHeight;
		  offset -= $(this).offset().top;
		  offset -= parseInt($(this).css('paddingTop'));
		  offset -= parseInt($(this).css('paddingBottom'));
	  	$(this).css(jQuery.browser.msie && jQuery.browser.version < 7 ? 'height' : 'minHeight', offset + 'px');
  
        if ($.browser.msie) {
//          $(this).css('zoom', 0);
            $(this).css('zoom', 1);
        }      
   	});
  }
  
  resizeContentBox();
  window.setInterval(resizeContentBox, 300);
});
	
