function deliveryRules_Site_UpdateList(mainListName, removeListName, removeMessageId) {

    var mainList = $('textarea[name="'+mainListName+'"]');
    var removeList = $('textarea[name="'+removeListName+'"]');

    var aMainList = mainList.val().split("\n");
    var aRemoveList = removeList.val().split("\n");

    var aRemovedList = [];
    var aNotRemovedList = [];

    $.each(aRemoveList, function(key, value) {
        if (value.length > 0) {
            var index = aMainList.indexOf(value);
            if (index !== -1) {
                aMainList.splice(index, 1);
                aRemovedList.push(value);
            } else {
                aNotRemovedList.push(value);
            }
        }
    });

    mainList.val(aMainList.join("\n"));

    var removeMessageString = "";
    if (aRemovedList.length > 0) {
        aRemovedList.sort();
        removeMessageString += "<p><b>Removed:</b></p>";
        removeMessageString += "<ul>";
        $.each(aRemovedList, function(key, value) {
            removeMessageString += "<li>"+value+"</li>";
        });
        removeMessageString += "</ul>";
        removeMessageString += "<br />";
    }
    if (aNotRemovedList.length > 0) {
        aNotRemovedList.sort();
        removeMessageString += "<p><b>Not Removed:</b></p>";
        removeMessageString += "<ul>";
        $.each(aNotRemovedList, function(key, value) {
            removeMessageString += "<li>"+value+"</li>";
        });
        removeMessageString += "</ul>";
    }

    var removeMessage = $('#' + removeMessageId);
    removeMessage.html(removeMessageString);

}