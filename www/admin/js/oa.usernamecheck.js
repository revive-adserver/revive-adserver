/**
 * A plugin for checking the availability of user names.
 * Depends on the TypeWatch plugin (jquery.typewatch.js).
 */
(function($) {
  /**
   * Default values of options
   */
  var defaults = {
    userNameCheckUrl: 'usernamecheck.php',
    userNameParameterName: 'username',
    checkTimeout: 500,
    availableResultText: 'available',
    indicatorSelector: '#user-check-indicator',
    availableClass: 'available',
    unavailableClass: 'unavailable',
    checkingClass: 'checking',
    errorClass: 'error',
    callback: function (textElement, userAvailable) { }
  };

  /**
   * Plugin function for installing the user availability checking
   * functionality.
   */
	jQuery.fn.userNameCheck = function(options) {
    // If no required plugin, do nothing
    if (!jQuery.fn.typeWatch) {
      return this;
    }

    // Options from the caller
    var o = $.extend({}, defaults, options);

    var checkUserNameAvailability = function(userNameToCheck, element) {
      // Option for the XHR
      var ajaxData = { };
      ajaxData[o.userNameParameterName] = userNameToCheck;

      // Element to show the results
      var $indicator = $(o.indicatorSelector);

      // Check if anything provided
      if ($.trim(userNameToCheck).length == 0) {
        $indicator.hide();
        o.callback.apply(element, [false]);
        return;
      }

      // Do the XHR
      $indicator.addClass(o.checkingClass).removeClass(o.unavailableClass).removeClass(o.availableClass);
      $indicator.show();
      $.ajax({
        url: o.userNameCheckUrl, 
        data: ajaxData, 
        success: function(data) {
          $indicator.removeClass(o.checkingClass).removeClass(o.errorClass);
          if (data == o.availableResultText) {
            $indicator.addClass(o.availableClass).removeClass(o.unavailableClass);
            o.callback.apply(element, [element, true]);
          } else {
            $indicator.removeClass(o.availableClass).addClass(o.unavailableClass);
            o.callback.apply(element, [element, false]);
          }
        },
        error: function() {
          $indicator.removeClass(o.checkingClass).addClass(o.errorClass);
        }
      });
    };

    return this.filter(":text").each(function() {
      $this = $(this);
      
      // Install type watch
      $this.typeWatch({
        callback: checkUserNameAvailability,
        wait: o.checkTimeout, 
        highlight: true,
        enterkey: true
      });

      // Call check at startup too
      checkUserNameAvailability($this.val(), $this.get(0));
    }).end();
  };
})(jQuery);
