$(document).ready(function() {
    /** setup some generic optional handlers **/
    $(document).ajaxStart(startLoading);
    $(document).ajaxStop(stopLoading);

    /** event handlers **/
    $("#click-html").click(function() {
        $("#json-content, #content").html('');
        $("#content").load('ajaxHandler.php?type=html');
    });
    
    $("#click-json").click(function() {
        $("#json-content, #content").html('');
        $.getJSON('ajaxHandler.php?type=json', function(result) {
            $("#content").html(result.message);
            $("#json-content").html(result.jsonMessage);
        });
    });    

    
    function startLoading()
    {
           $("body").append("<div class='loading'>Loading...</div");
    }
    
    function stopLoading()
    {
        $("div.loading").remove();
    }
    
});