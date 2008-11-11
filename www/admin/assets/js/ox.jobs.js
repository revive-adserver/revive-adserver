(function($) {
    $.fn.ajaxJobs = function(options) {
        return this.each(function() {
            
            var $this = $(this);
            var $form = $(this);
            var defaults = {
                debug: false,
                responseDataType: 'json',
                requestTimeout: 30000 //30sec
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
                        //intentionally left blank - do not want external code to break the flow
                    }
                }            
            }
            
            
            function startJob(url)
            {
                if (settings.start) {
                    settings.start(currentIndex, url);
                }            
                            
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
                        //intentionally left blank - do not want external code to break the flow
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
                        //intentionally left blank - do not want external code to break the flow
                    }
                }
                currentIndex++;
                nextJob();
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
                        settings.error(currentIndex, currentUrl, errorText, httpStatus, httpStatusText);
                    }
                    catch(e) {
                        //intentionally left blank - do not want external code to break the flow
                    }
                }
            }
        });
    };
})(jQuery);


(function($) {
    $.fn.pluginJobs = function(options) {
        return this.each(function() {
            
            var $this = $(this);
            var $form = $(this);
            var defaults = {
                debug: false,
                startText: 'Installing...',
                responseDataType: 'json',
                requestTimeout: 30000 //30sec
            };
            var settings = $.extend({}, defaults, options);
            
           
            var jobsCount = settings.jobs.length;
            if (jobsCount == 0) {
               $this.append("No plugins to install");
               return; //nothing to do here
            }
            
            init();
            
            
            function init()
            {
                /** setup some generic optional handlers **/
                //$(document).ajaxStart(startLoading);
                //$(document).ajaxStop(stopLoading);
                
                try {
	                buildTable();
	                disableContinue();
	                
		            $(document).ajaxJobs({
		                jobs: settings.jobs,
		                start: onStart,
		                success: onSuccess,
		                error: onError,
		                complete: onComplete,
		                allComplete: onAllComplete,
                        debug: settings.debug,
                        responseDataType: settings.responseDataType,
                        requestTimeout: settings.requestTimeout 
		                });
		        }
		        catch (e) {
		          enableContinue();
		        }
            }
            
            
            function buildTable()
            {
                $this.append("<table class='sysinfotable'><tbody></tbody></table>");
                for( i = 0; i < jobsCount; i++) {
                    $("table", $this).append("<tr><td class='jobName'>" 
                    + settings.jobs[i].name
                    +"</td><td><span class='status' id='job_status_" + i +"'></span></td></tr>");
                }               
            }
            
            
            function enableContinue()
            {
                if (settings.continueButtonId) {
                    $("#" + settings.continueButtonId).attr("disabled", false)
                        .removeClass("disabled-button");
                }
            }
            
            function disableContinue()
            {
                if (settings.continueButtonId) {
                    $("#" + settings.continueButtonId).attr("disabled", true)
                        .addClass("disabled-button");
                }
            }
            
	        function onStart(jobIndex, url)
	        {
	            $("#job_status_" + jobIndex, $this).text(settings.startText)
	               .addClass('status-installing');
	        }
	      
	      
	        function onSuccess(jobIndex, url, resultData)
	        {
	           try {
		           $statusElem = $("#job_status_" + jobIndex, $this);  
	               $statusTD = $statusElem.parent("td");
	               
	               if (typeof resultData != "object" || resultData.status == undefined || resultData.status == '') {
	                    onError(jobIndex, url, "parsererror", 200, "OK")
	                    return;
	               } 
	               
	               $statusElem.removeClass('status-installing').text(resultData.status)
	                 
	               if (resultData.errors && resultData.errors.length && resultData.errors.length > 0) {
	                    $statusElem.after("<ul class='errors'></ul>");
	                    for (var i = 0;i< resultData.errors.length; i++) {
	                       if (resultData.errors[i] != undefined && resultData.errors[i] != "" && resultData.errors[i] != null) { 
	                       $("ul.errors", $statusTD).append("<li>" + resultData.errors[i] + "</li>");    
	                      }
	                    }
	               }
               }
               catch(e) {
                onError(jobIndex, url, "parsererror", 200, "OK")
               }
	        }
	        
	        
	        function onError(jobIndex, url, errorText, HttpStatus, HttpStatusText)
	        {
	           if (errorText == "parsererror") {
	             errorMessage = "(Parse error, server returned invalid response)";   
	           }
	           else if (errorText == "timeout"){
	               errorMessage = "(Request timed out)";
	           }
	           else {
                 errorMessage = "(Server returned: " + HttpStatus +" " + HttpStatusText + ")";	           
	           }
	        
	            $("#job_status_" + jobIndex, $this).text("Failed " + errorMessage)
	               .removeClass('status-installing').addClass('status-failed');
	        }        
	
	        
	        function onComplete(jobIndex, url, textStatus)
	        {
	        }
	
	        
	        function onAllComplete(jobsCount)
	        {
	           enableContinue();
	        }        
        
    
            function startLoading()
            {
                   $("body").append("<div class='loading'>Loading...</div");
            }
            
            
            function stopLoading()
            {
                $("div.loading").remove();
            }
        });
    };
})(jQuery);

