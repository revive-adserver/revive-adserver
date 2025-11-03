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
        removeMessageString += '<ul id="' + removeMessageId + '_1">';
        removeMessageString += "</ul>";
        removeMessageString += "<br />";
    }
    if (aNotRemovedList.length > 0) {
        aNotRemovedList.sort();
        removeMessageString += "<p><b>Not Removed:</b></p>";
        removeMessageString += '<ul id="' + removeMessageId + '_2">';
        removeMessageString += "</ul>";
    }

    var removeMessage = $('#' + removeMessageId);
    removeMessage.html(removeMessageString);

    $.each(aRemovedList, function(key, value) {
        $('#' + removeMessageId + '_1').append(
            $('<LI>').text(value)
        );
    });

    $.each(aNotRemovedList, function(key, value) {
        $('#' + removeMessageId + '_2').append(
            $('<LI>').text(value)
        );
    });

}