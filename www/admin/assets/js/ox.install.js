(function($) {
     $.fn.welcomeStep = function(options) {
        var defaults = {
        };
        var settings = $.extend({}, defaults, options);
        $this = $(this);
        $form = $("form", $this);

        init();

        function init()
        {
            $(document).preloadImages({
                images : 'assets/images/loading.gif'
            });

            $form.submit(function() {
              $(this).showLoader({
                  'message' : settings.message
              });
              return true;
            });
        }
     };


     $.fn.loginStep = function(options) {
        var defaults = {
        };
        var settings = $.extend({}, defaults, options);
        $this = $(this);
        $form = $("form", $this);

        init();

        function init()
        {
            $(document).preloadImages({
                images : 'assets/images/loading.gif'
            });

            $form.submit(function() {
              if ($(this).valid()) {
                $(this).showLoader({
                    'message' : settings.message
                });
                return true;
              }
              return false;
            });
        }
     };


     $.fn.checkStep = function(options) {
        var defaults = {
        };
        var settings = $.extend({}, defaults, options);
        $syscheck = $("ul.syscheck");
        $fullView = $("#full-view");
        $shortView = $("#short-view");
        $checkForm = $("#checkForm");
        $detailLinks = $(".detail-control  .detailed");
        $compactLinks = $(".detail-control  .compact");

        init();

        function init()
        {
            $(document).preloadImages({
                images : 'assets/images/loading.gif'
            });

            if ($("input[name=retry]", $checkForm).length > 0) {
                $checkForm.submit(function() {
                    $(this).showLoader({
                        'message' : settings.message
                    });
                    return true;
                });
            }

            $detailLinks.click(function() {
                updateCheckTable.call(this, true);
                return false;
            });

            $compactLinks.click(function() {
                updateCheckTable.call(this, false);
                return false;
            });

            $fullView.click(function() {
                updateCheckTable.call(this, true);
                return false;
            });

            $shortView.click(function() {
                updateCheckTable.call(this, false);
                return false;
            });

            updateCheckTable(true);
        }

        function updateCheckTable(fullView)
        {
            if (fullView) {
              $syscheck.find("li.checkSection, li.checkItem, tr.checkItem").show();
              $detailLinks.hide();
              $compactLinks.filter(function() {
                return $(this).parents('.checkSection:visible').length > 0;
              }).filter(":first").show();

              $fullView.hide();
              $shortView.show();
            }
            else {
              $syscheck.find("li.checkSection, li.checkItem, tr.checkItem").hide();
              $syscheck.find("li.hasError,li.hasWarning, tr.hasError, tr.hasWarning").show();

              $detailLinks.filter(function() {
                return $(this).parents('.checkSection:visible').length > 0;
              }).filter(":first").show();

              $compactLinks.hide();

              $fullView.show();
              $shortView.hide();
            }

        }
  };

  $.fn.registerStep = function(options) {
        var defaults = {
        };
        var settings = $.extend({}, defaults, options);
        var $context = $(this);
        var $accountModeRadios =  $("input[name=hasAccount]");
        var $loginFormWrapper = $("#login-form-container");
        var $signupFormWrapper = $("#signup-form-container");
        var $marketInfoLink = $("#show-market-info");
        var $marketInfo  =$("#market-info");

        init();


        function init()
        {
            $(document).preloadImages({
                images : 'assets/images/loading.gif'
            });


          //hack the form table and make empty header smaller
          if ($.browser.msie) {
              $("form table").find("tr:first td").css('height', '8px');
          }

          $accountModeRadios.click(updateForm);

  /*        $("#has-account a").click(function() {
              updateForm('has-account');
              $("#has-account").hide();
              $("#no-account").show();
              return false;
           });
          $("#no-account a").click(function() {
              updateForm('no-account');
              $("#no-account").hide();
              $("#has-account").show();
              return false;
           });*/

          $("#s_username", $context).userNameCheck({
            userNameCheckUrl: settings.usernameCheckUrl,
            userNameParameterName: 'userName',
            checkTimeout: 500,
            availableResultText: 'available',
            unavailableResultText: 'taken',
            indicatorSelector: '#user-check-indicator',
            availableClass: 'available',
            unavailableClass: 'unavailable'
          });

          $("form", $loginFormWrapper).add("form", $signupFormWrapper).submit(function() {
              if ($(this).valid()) {
                $(this).showLoader({
                    'message' : settings.message
                });
                return true;
             }
             return false;
          });

          updateForm();

           $marketInfoLink.click(showMarketInfo);
        }


        function updateForm()
        {
            var selectedId = $accountModeRadios.filter(":checked").attr("id");

            if (selectedId == 'has-account') {
                $signupFormWrapper.hide();
                $loginFormWrapper.show();
                $("#l_username").focus();
            }
            else if (selectedId == 'no-account'){
                $loginFormWrapper.hide();
                $signupFormWrapper.show();
                $("#s_username").focus();
            }
        }


        function showMarketInfo()
        {
            $marketInfo.modal({
                    persist: true,
                    overlayCss: { backgroundColor: "#000" },
                    close: true,
                    closeHTML: '',
                    closeClass: 'close-modal'
                });
        }
  };


    $.fn.dbStep = function(options) {
        var defaults = {
            'formFrozen' : false
        };
        var settings = $.extend({}, defaults, options);

        $dbType = $("#dbType");
        $dbHost = $("#dbHost");
        $dbPort = $("#dbPort");
        $dbSocket = $("#dbSocket");
        $socketField = $("#dbLocal"); //checkbox or hidden (when form freezed)
        $dbTableType = $("#dbTableType");
        $form = $("form", $(this));
        init();

        function init()
        {
            $(document).preloadImages({
                images : 'assets/images/loading.gif'
            });

            if (settings.formFrozen !== true) {
                $socketField.click(toggleSocketInput);
                $dbType.change(switchDbTypes);
                switchDbTypes();
            }

            $("#showMoreFields").showMore({
                moreId : 'moreFields' ,
                hiddenId: 'moreFieldsShown'
            });

            $form.submit(function() {
              if ($(this).valid()) {
                $(this).showLoader({
                    'message' : settings.message
                });
                return true;
              }
              return false;
            });
        }


        function toggleSocketInput()
        {
            //TODO is this required?
            if($socketField.attr('disabled')) {
                return;
            }

            //port cannot be used with socket for mysql
            var portDisabled = $dbType.val() == 'mysql';


            if ($socketField.attr('checked') === true) {
              $dbHost.attr('disabled' , true);
              $dbPort.attr('disabled' , portDisabled);
              $dbSocket.attr('disabled' , false);
            }
            else {
              $dbSocket.attr('disabled' , true);
              $dbHost.attr('disabled' , false);
              $dbPort.attr('disabled' , false);
            }
        }


        function switchDbTypes()
        {
            var dbType = $dbType.val();

            if (dbType == 'mysql') {
                $dbPort.val(3306);
                $dbTableType .attr('disabled', false);
            }
            else if (dbType == 'pgsql') {
                $dbPort.val(5432);
                $dbTableType .attr('disabled', true);
            }
            toggleSocketInput();
        }
    };


    $.fn.configStep = function(options) {
        var defaults = {
        };
        var settings = $.extend({}, defaults, options);
        $this = $(this);
        $form = $("form", $this);

        init();

        function init()
        {
            $(document).preloadImages({
                images : 'assets/images/loading.gif'
            });


            $("#showMoreFields").showMore({
                moreId : 'moreFields' ,
                hiddenId: 'moreFieldsShown'
            });

            $form.submit(function() {
              if ($(this).valid()) {
                $(this).showLoader({
                    'message' : settings.message
                });
                return true;
              }
              return false;
            });
        }

    };


    $.fn.jobsStep = function(options) {
        var defaults = {
            loaderId : 'jobsLoader',
            errorContainerId : 'errors',
            debug : false
        };
        var settings = $.extend({}, defaults, options);

        var $form = $("#jobsForm");

        init();

        function init()
        {
            $(document).preloadImages({
                images : 'assets/images/loading.gif'
            });

             disableForm();

              $(this).showLoader({
                  'id' : settings.loaderId,
                  'message' : settings.message
              });

              $(this).installTasks({
                  jobs: settings.jobs,
                  requestTimeout: 30000, //in milis 30sec
                  delay: 2500, //in milis delay between the requests
                  allComplete: onAllComplete,
                  loaderId : settings.loaderId,
                  errorContainerId : settings.errorContainerId,
                  debug : settings.debug
              });
        }


        function onAllComplete(jobsCount, errors)
        {
            if (settings.debug) {
               $(this).hideLoader({'id' : settings.loaderId});
               $('#' + settings.errorContainerId).show();
               enableForm();
            }
            populateFormErrors(errors);

            if (!settings.debug) {
                $form.submit();
            }
        }


        function populateFormErrors(errors)
        {
            $err = $('.err', $form);
            for (var i = 0; i <errors.length; i++) {
              $form.prepend("<textarea style='display:none;' name='jobError[" + errors[i].id + "]'>"+ errors[i].message + "</textarea>");
            }
        }

        function enableForm()
        {
           $form.show();
           $("#continue" ,$form).attr("disabled", false).removeClass("disabled-button");
        }


        function disableForm()
        {
           $form.hide();
           $("#continue" ,$form).attr("disabled", true).addClass("disabled-button");
        }
    };


    $.fn.installTasks = function(options) {
            var defaults = {
                allComplete: null, //callback required
                loaderId : null, //required
                errorContainerId : null, //required
                debug: false,
                responseDataType: 'json',
                requestTimeout: 30000, //30sec
                delay: null //interval between requests
            };
            var settings = $.extend({}, defaults, options);


            var jobsCount = settings.jobs.length;
            if (jobsCount === 0) {
               settings.allComplete(0, []);
               return; //nothing to do here
            }

            var $loaderMessage = $('#' + settings.loaderId + " .message");
            var $errorContainer = $('#' + settings.errorContainerId + ' .body');

            var errors = [];

            if (settings.debug) {
                var $debug = $("body").append("jobs-debug");
            }
            init();


            function init()
            {
                try {
                    build();

                    $(document).ajaxJobs({
                        jobs: settings.jobs,
                        start: onStart,
                        success: onSuccess,
                        error: onError,
                        exception: onException,
                        allComplete: onAllComplete,
                        debug: settings.debug,
                        responseDataType: settings.responseDataType,
                        requestTimeout: settings.requestTimeout,
                        delay:  settings.delay
                        });
                }
                catch (e) {
                  settings.allComplete(-1, errors);
                }
            }


            function build()
            {
                $errorContainer.append("<ol></ol>");

                if (settings.debug) {
                  $debug.append("<table><tbody></tbody></table>");
                  for( i = 0; i < jobsCount; i++) {
                      $("table", $debug).append("<tr><td class='jobName'>"
                      + settings.jobs[i].name
                      +"</td><td><span class='status' id='job_status_" + i +"'></span></td></tr>");
                  }
                }
            }


            function onStart(jobIndex, url)
            {
                $loaderMessage.html(settings.jobs[jobIndex].name);

                if (settings.debug) {
                    $("#job_status_" + jobIndex, $debug).text('Started');
                }
            }


            function onAllComplete(jobsCount)
            {
               settings.allComplete(jobsCount, errors);
            }


            function onSuccess(jobIndex, url, resultData)
            {
               try {
                   if (typeof resultData != "object" || resultData.status === undefined || resultData.status === '') {
                        onError(jobIndex, url, "parsererror", 200, "OK");
                        return;
                   }

                  $loaderMessage.html(settings.jobs[jobIndex].name + resultData.status);

                   //debugging part
                   if (settings.debug) {
                     $statusElem = $("#job_status_" + jobIndex, $debug);
                     $statusTD = $statusElem.parent("td");
                     $statusElem.text(resultData.status);
                     if (resultData.errors && resultData.errors.length && resultData.errors.length > 0) {
                          $statusElem.after("<ul class='errors'></ul>");
                          for (var i = 0;i< resultData.errors.length; i++) {
                             if (resultData.errors[i] !== undefined && resultData.errors[i] !== "" && resultData.errors[i] !== null) {
                             $("ul.errors", $statusTD).append("<li>" + resultData.errors[i] + "</li>");
                            }
                          }
                     }
                   }
               }
               catch(e) {
                onError(jobIndex, url, "parsererror", 200, "OK");
               }
            }

            /**
            * Handles error from server, eg. response is bad, parse error occurred, memory error
            * occurred, maybe a PHP fatal. If response given just grab it and report
            */
            function onError(jobIndex, url, errorText, HttpStatus, HttpStatusText, serverResponse)
            {
               if (errorText == "parsererror") {
                 if (serverResponse) {
                    errorMessage = serverResponse;
                 }
                 else {
                    errorMessage = "Parse error, server returned invalid response";
                 }
               }
               else if (errorText == "timeout"){
                   errorMessage = "Request timed out";
               }
               else {
                 errorMessage = "Server returned: " + HttpStatus +" " + HttpStatusText;
               }


               errors[errors.length] = {
                  id: settings.jobs[jobIndex].id,
                  message : errorMessage
               };


               $("ol", $errorContainer).append("<li>"
                 + "<h4>Failure of '" + settings.jobs[jobIndex].name  + "' task</h4>"
                 + errorMessage + "</li>");

               if (settings.debug) {
                $("#job_status_" + jobIndex, $debug).text("Failed " + errorMessage);
               }
           }


            function onException(jobIndex, url, e)
            {
                  errorMessage = e;
                  $("ol", $errorContainer).append("<li>"
                     + "<h4>Failure of '" + settings.jobs[jobIndex].name  + "' task</h4>"
                     + errorMessage + "</li>");

                  if (settings.debug) {
                    $("#job_status_" + jobIndex, $debug).text("Failed (" + errorMessage + ")");
                  }
            }
    };


     $.fn.finishStep = function(options) {
        var defaults = {
        };
        var settings = $.extend({}, defaults, options);
        $this = $(this);
        $showErrorsLink = $(".show-errors", $this);
        $detailedErrors = $("#error-details");

        init();

        function init()
        {
            $showErrorsLink.click(function() {
                $detailedErrors.toggle();
                return false;
            });
        }
     };



    $.fn.showMore = function(options) {
        var defaults = {
        };
        var settings = $.extend({}, defaults, options);

        return this.each(function() {
            var $this = $(this);
            var $moreFields = $("#" + settings.moreId);
            var $hidden = null;
            if (settings.hiddenId) {
                $hidden = $("#" + settings.hiddenId);
            }

            init();

            function init()
            {
              $this.click(function() {
                      if ($hidden) {
                          $hidden.val('1');
                      }
                      toggleMoreFields(true);

                      return false;
              });

              toggleMoreFields(false);

            }

            function toggleMoreFields(animate)
            {
                var showMore = true;

                if ($hidden) {
                    showMore = $hidden.val() == '1';
                }

                if (showMore) {
                    $this.parents('tr').hide();
                    $moreFields.showElement(animate);
                }
                else {
                    $moreFields.hide();
                    $this.parents('tr').showElement();
                }
            }

        });
    };

    $.fn.preloadImages = function(options) {
        var defaults = {
        };
        var settings = $.extend({}, defaults, options);

        return this.each(function() {

            init();

            function init()
            {
                $(window).bind('load', function() {
                    preload(settings.images);
                });
            }

            function preload()
            {
              for (var i = 0; i<arguments.length; i++) {
                $("<img>").attr("src", arguments[i]);
              }
            }
        });
    };




    $.fn.showLoader = function(options) {
        var defaults = {
            id: 'loader',
            message: 'Processing...'
        };
        var settings = $.extend({}, defaults, options);

        return this.each(function() {
            var $this = $(this);

            init();

            function init()
            {
                buildLoader();
                showLoader();
            }


            function buildLoader()
            {
                $("body").append("<div id='" + settings.id + "' class='loaderContent' ><div class='message'>" + settings.message + "</div></div>");
            }


            function showLoader() {
                var $pageLoader = $("#" + settings.id);
                $pageLoader.modal({
                    persist: true,
                    overlayCss: { backgroundColor: "#000" },
                    close: false
                });
            }
        });
    };

    $.fn.hideLoader = function(options) {
        var defaults = {
            id: 'loader'
        };
        var settings = $.extend({}, defaults, options);

        return this.each(function() {

            init();

            function init()
            {
                hideLoader();
            }


            function hideLoader() {
                var $pageLoader = $("#" + settings.id);
                $.modal.close();
                $pageLoader.remove();
            }
        });
    };

})(jQuery);