/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/*
 * Resizes sandboxed banner previews of unspecified size to fit their content.
 *
 * The preview frames run on an opaque origin, so their size is reported by
 * banner-preview.php through postMessage. Only frames marked for autosizing
 * are resized, only by the frame that sent the message, and within bounds.
 */
(function () {
    var MAX_WIDTH = 1200;
    var MAX_HEIGHT = 1200;

    function clamp(value, max) {
        value = Math.ceil(Number(value));
        if (!isFinite(value) || value < 1) {
            return null;
        }
        return Math.min(value, max);
    }

    // The banner-htmlpreview.php popup is opened with the default frame size for banners
    // without a specified size: grow the window once the frame has been resized to fit
    function fitPopup() {
        if (!window.opener || !document.body || !document.body.hasAttribute('data-revive-preview-popup')) {
            return;
        }
        // Resizing is asynchronous and frames can report several sizes in a row, so compute
        // an absolute target rather than growing by the current overflow, which would add
        // up to an oversized window. The browser chrome size stays constant while resizing.
        var root = document.documentElement;
        var targetWidth = root.scrollWidth + (window.outerWidth - window.innerWidth);
        var targetHeight = root.scrollHeight + (window.outerHeight - window.innerHeight);
        if (targetWidth > window.outerWidth || targetHeight > window.outerHeight) {
            try {
                window.resizeTo(Math.max(targetWidth, window.outerWidth), Math.max(targetHeight, window.outerHeight));
            } catch (e) {
                // Browsers may refuse to resize, e.g. when the popup was opened as a tab
            }
        }
    }

    window.addEventListener('message', function (event) {
        var data = event.data;
        if (event.origin !== 'null' || !data || data.type !== 'revive-banner-preview-size') {
            return;
        }

        var frames = document.querySelectorAll('iframe[data-revive-preview-autosize]');
        for (var i = 0; i < frames.length; i++) {
            if (frames[i].contentWindow !== event.source) {
                continue;
            }

            var width = clamp(data.width, MAX_WIDTH);
            var height = clamp(data.height, MAX_HEIGHT);
            if (width !== null) {
                frames[i].width = width;
            }
            if (height !== null) {
                frames[i].height = height;
            }
            fitPopup();
            return;
        }
    });
})();
