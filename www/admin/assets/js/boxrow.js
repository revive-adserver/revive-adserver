/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * Client-side (browser) script for displaying fake selects with checkboxes.
 */
function boxrow_init()
{
    var obj = document.body.getElementsByTagName("DIV");

    for (var i=0; i < obj.length; i++) {
        if (obj[i].className == 'boxrow') {
            obj[i].onmouseover = boxrow_over;
            obj[i].onmouseout = boxrow_leave;
            obj[i].onclick = boxrow_click;

            // Check for 1st generation childs -- input tags
            j = 0;

            while (j < obj[i].childNodes.length) {
                if (obj[i].childNodes[j].tagName == 'INPUT')
                obj[i].childNodes[j].onclick = boxrow_nonbubble;

                j++;
            }
        }
    }
}

function boxrow_over(e)
{
    if (!e && window.event) {
        e = window.event;
    }

    if (e.srcElement) {
        o = e.srcElement;
    } else {
        o = e.target;
    }

    // Find the DIV
    while (o.tagName != "DIV") {
        o = o.parentNode;
    }

    o.style.backgroundColor='#F6F6F6';
}

function boxrow_leave(e)
{
    if (!e && window.event)
        e = window.event;

    if (e.srcElement) {
        o = e.srcElement;
    } else {
        o = e.target;
    }

    // Find the DIV
    while (o.tagName != "DIV") {
        o = o.parentNode;
    }

    o.style.backgroundColor='#FFFFFF';
}

function boxrow_click(e)
{
    if (!e && window.event)
        e = window.event;

    if (e.srcElement) {
        o = e.srcElement;
    } else {
        o = e.target;
    }
    if (o.tagName == 'IMG') {
        return;
    }

    // Find the DIV
    while (o.tagName != "DIV") {
        o = o.parentNode;
    }

    // Find the checkbox
    i = 0;

    while (i < o.childNodes.length) {
        if (o.childNodes[i].tagName == 'INPUT') {
            o.childNodes[i].checked = !o.childNodes[i].checked;
            return true;
        }

        i++;
    }
}

function boxrow_nonbubble(e)
{
    if (!e && window.event) {
        e = window.event;
    }

    if (e.stopPropagation) {
        e.stopPropagation();
    } else {
        e.cancelBubble = true;
    }
}
