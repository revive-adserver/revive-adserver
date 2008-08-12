function initBidPreferences()  
{
    $(document).ready(function() {
	    $("#creative-types input[type=checkbox], #creative-attrs input[type=checkbox]").click(function() {
	        if (this.checked) {
	            $(this).parent().addClass('rejected');    
	        }
	        else {
	            $(this).parent().removeClass('rejected');
	        }
	    });
     });
}