(function($) {
    $.fn.ajaxJobs = function(options) {
        return this.each(function() {
            var $this = $(this);
            var $form = $(this);
            var defaults = {
                debug: false,
                responseDataType: 'json',
                requestTimeout: 30000, //30sec
                delay: null //delay between the requests
            };
            var settings = $.extend({}, defaults, options);


            var jobsCount = settings.jobs.length;
            if (jobsCount == 0) {
               return; //nothing to do here
            }

            var currentUrl = '';
            var currentIndex = 0;
            var urls = settings.jobs.slice(0);
	        init();


            function init()
            {
			    //start first Job
				nextJob();
            }


            function nextJob()
            {
                try {
                    job = urls.shift();

	                if (job) {
	                    currentUrl = job.url;
	                    startJob(currentUrl);
	                }
	                else {
	                    jobsCompleted();
	                }
	            }
	            catch(e) {
	               jobsCompleted(); //just in case call the external code so that it can cleanup any UI
	            }
            }


            function jobsCompleted()
            {
                if (settings.debug && window.console && window.console.debug ) {
                    console.debug(currentIndex +" jobs completed");
                }

                if (settings.allComplete) {
                    try {
                        settings.allComplete(currentIndex);
                    }
                    catch(e) {
                        handleJSException(e);
                    }
                }
            }


            function startJob(url)
            {
                if (settings.start) {
                    settings.start(currentIndex, url);
                }
                try {
                  $.ajax({
                      type: 'GET',
                      url: url,
                      cache: false,
                      timeout: settings.requestTimeout,
                      dataType: settings.responseDataType,
                      success: handleSuccess,
                      error: handleError,
                      complete: handleRequestCompleted
                  });
                }
                catch(e) {
                  handleRequestException(url, e);
                }
            }


            /*
             * A function to be called if the request succeeds. The function gets
             * passed two arguments: The data returned from the server,
             * formatted according to the 'dataType' parameter, and a string
             * describing the status
             */
            function handleSuccess(resultData, successText)
            {
                if (settings.debug && window.console && window.console.debug) {
                    console.debug("request success, data: " + resultData);
                }

                if (settings.success) {
                    try {
                        settings.success(currentIndex, currentUrl, resultData);
                    }
                    catch(e) {
                        handleJSException(e);
                    }
                }
            }


            /*
             * A function to be called when the request finishes (after success
             * and error callbacks are executed).
             * The function gets passed two arguments:
             * The XMLHttpRequest object and a string describing the type of success of the request.
             */
            function handleRequestCompleted(XMLHttpRequest, textStatus)
            {
                if (settings.debug && window.console && window.console.debug ) {
                    console.debug("request complete, status: " + textStatus);
                }

                if (settings.complete) {
                    try {
                        settings.complete(currentIndex, currentUrl, textStatus);
                    }
                    catch(e) {
                        handleJSException(e);
                    }
                }

                var runNext = function() {
                  currentIndex++;
                  nextJob();
                };

                if (settings.delay) {
                    setTimeout(runNext, settings.delay);
                }
                else {
                    runNext();
                }
            }


            /**
             *  A function to handle exceptions thrown by .ajax call, usually security exceptions
             * It will call external handler if any, and start next job after that
             */
            function handleRequestException(url, e)
            {
               if (settings.exception) {
                    try {
                        settings.exception(currentIndex, url, e);
                    }
                    catch(e) {
                        handleJSException(e);
                    }
               }

                var runNext = function() {
                  currentIndex++;
                  nextJob();
                };

                if (settings.delay) {
                    setTimeout(runNext, settings.delay);
                }
                else {
                    runNext();
                }
            }



            /* A function to be called if the request fails. The function gets passed
             * three arguments: The XMLHttpRequest object, a string describing
             * the type of error that occurred and an optional exception object,
             * if one occurred
             */
            function handleError(XMLHttpRequest, errorText)
            {
                if (settings.debug && window.console && window.console.debug ) {
                    console.debug("request failed, status: " + errorText + " HTTP " + XMLHttpRequest.status);
                }

                if (settings.error) {
                    try {
                        httpStatusText = '';
                        httpStatus = '';
                        if (XMLHttpRequest.readyState == 4) {
	                        httpStatusText = XMLHttpRequest.statusText;
	                        httpStatus = XMLHttpRequest.status;
                        }
                        settings.error(currentIndex, currentUrl, errorText, httpStatus, httpStatusText, XMLHttpRequest.responseText);
                    }
                    catch(e) {
                        handleJSException(e);
                    }
                }
            }


            function handleJSException(e)
            {
                //just try to log to console if debug, otherwise, eat that exc,
                //we do not want the external listener code to break the flow
                if (settings.debug && window.console && window.console.error ) {
                    console.error(e);
                }
            }

        });
    };
})(jQuery);