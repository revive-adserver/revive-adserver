
(function($) {
    $.extend({
        queueMessage: new function() {
            var active = null;
            var button = null;
            var queue = [];
            var defaults = {
                id:			null,
                text:		'',
                location:   'global',
                type:		'normal',
                timeout:	5000,
                animate:	!(jQuery.browser.msie && parseInt(jQuery.browser.version) < 7)
            };

            function show() {
                active = queue.shift();
                active.element = jQuery("<div class='message'><div class='panel " + active.settings.type + "'><div class='icon'></div><p>" + active.settings.text + "</p><div class='topleft'></div><div class='topright'></div><div class='bottomleft'></div><div class='bottomright'></div></div></div>");

                /* Show a close button if there is no automatic time out */
                if (active.settings.location != 'form' && active.settings.timeout <= 0) {
                    button = jQuery("<div class='close'>x</div>");
                    $(button).click(function() {
                        if (active.settings.animate) {
                            active.element.slideUp(function() {
                                active.element.remove();
                                active = null;
                                ping();
                            });
                        } else {
                            active.element.remove();
                            active = null;
                            ping();
                        }
                     });

                    $(active.element).children('div.panel').append(button);
                }

                /* Try to find the proper container for local messages */
                if (active.settings.location != 'global' && active.container.find('#messagePlaceholder').length > 0) {
                    active.container = active.container.find('#messagePlaceholder');
                    active.element.addClass(active.settings.location + 'Message');
                } else {
                    active.settings.location = 'global';
                    active.element.addClass('globalMessage');
                }

                /* Do not use animation for showing the message if it is a local
                   message or specifically disabled */
                if (active.settings.animate && active.settings.location == 'global') {
                    active.element.hide();
                    active.container.prepend(active.element);
                    active.element.slideDown();
                } else {
                    active.container.prepend(active.element);
                }

                /* Make the message disappear after a preset delay */
                if (active.settings.timeout > 0) {
                    window.setTimeout(function() {
                        if (active.settings.animate) {
                            active.element.slideUp(function() {
                                active.element.remove();
                                active = null;
                                ping();
                            });
                        } else {
                            active.element.remove();
                            active = null;
                            ping();
                        }
                    }, active.settings.timeout);
                }

                /* Do not collapse the container for local messages to prevent the
                   actual content from shifting up on the page */
                /*
                if (active.element.hasClass('localMessage')) {
                    active.container.height(active.element.height());
                }
                */
            }

            function ping() {
                if (!active && queue.length) {
                    show();
                }
            }

            this.construct = function(settings) {
                return this.each(function() {
                    var message = {
                        settings:	$.extend(null, defaults, settings),
                        element:	null,
                        container: 	$(this)
                    };

                    if (message.settings.id && message.settings.id <= parseInt(window.name)) {
                        return;
                    }

                    queue.push(message);

                    if (message.settings.id) {
                        window.name = message.settings.id;
                    }

                    ping();
                });
            };
        }
    });

    // extend plugin scope
    $.fn.extend({
        queueMessage: $.queueMessage.construct
    });
})(jQuery);