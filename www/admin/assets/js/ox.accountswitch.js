(function($) {
    $.fn.accountswitch = function(options) {
        var defaults = {
          action: 'init',
          searchUrl: 'account-switch-search.php',
          searchInputSelector: '#accountSearch',
          progressIndicatorSelector: '#accountLoading',
          searchPrompt: 'account name',
          searchDelay: 400
        };
        var settings = $.extend({}, defaults, options);
    
        var $switcher = this;
        var $accountsArea = this.find(".result");
        var $search = this.find(settings.searchInputSelector);
        
        if (settings.action == 'show') {
            if ($search.size() != 0) {
              if ($search.val() != $accountsArea.find("ul li:first").text()) {
                  $search.val("");
              }
              $search.focus().get(0).select();
            } else {
              $accountsArea.find("a:first").focus();
            }
            return;
        }
        
        $search.example(settings.searchPrompt);
        $search.keydown(function(event) {
          if (event.keyCode == 13 && $search.val().length > 0) {
            var $link = $accountsArea.find("a:first");
            if ($link.size() > 0) {
                document.location.href = $link.attr('href');
            }
          }
          return true;
        });
        
        $search.typeWatch({
            wait: settings.searchDelay,
            captureLength: 1,
            callback: updateAccounts,
            submitOnEnter: false
        });
        
        return this;

    
        function updateAccounts() 
        {
            $(settings.progressIndicatorSelector).show();
            $.ajax({
                url: settings.searchUrl,
                data: { q: $search.val()},
                type: "GET",
                complete: function () {
                    $(settings.progressIndicatorSelector).hide();
                },
                error: function(request, status) {
                    $accountsArea.html("<div id='accountLoadingError'>Failed to load accounts: " + status + "</div>");
                },
                success: function(data) {
                    if (checkReload(data)) {
                        return;
                    }
                
                    var $accounts = $(data).find("#accounts");
                    if ($accounts.size() > 0) {
                        $accountsArea.html($accounts);
                    } else {
                      $accountsArea.html("<div id='accountLoadingError'>Account data not found in: " + data + "</div>");
                    }
                    $switcher.find("li > a").parent().hover(function() {
                        $this = $(this);
                        if (!$this.is(".opt")) {
                          $this.addClass("hover");
                        }
                      }, function() {
                        $(this).removeClass("hover");
                    });
                }
            });
        }

        function checkReload(data) {
            if (data.indexOf("<!-- install -->") >= 0 || data.indexOf("<!-- login -->") >= 0) {
                document.location.reload();
                return true;
            }
            return false;
        }
    };
})(jQuery);