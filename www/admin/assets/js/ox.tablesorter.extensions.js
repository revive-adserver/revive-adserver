//Custom column parsers

(function($) {
	// add parser for diff in dollars 
	$.tablesorter.addParser({ 
	    // set a unique id 
	    id: 'currencyDiff', 
	    is: function(s) { 
	        // return false so this parser is not auto detected 
	        return /^[+-][£$€?.]/.test(s); 
	    }, 
	    format: function(s) { 
	        // format your data for normalization 
	        return $.tablesorter.formatFloat(s.replace(new RegExp(/[^-+0-9.]/g),"")); 
	    }, 
	    // set type, either numeric or text 
	    type: 'numeric' 
	}); 
})(jQuery);	