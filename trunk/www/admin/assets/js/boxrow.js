// Javascript

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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
