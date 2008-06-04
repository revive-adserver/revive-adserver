
(function($) {
	$.extend({
		queueMessage: new function() {
			var active = null;
			var button = null;
			var queue = [];
			var defaults = {
				id:			null,
				text:		'',
				type:		'normal',
				timeout:	5000,
				animate:	!(jQuery.browser.msie && parseInt(jQuery.browser.version) < 7)
			};
			
			function show() {
				active = queue.shift();
				active.element = jQuery("<div class='message'><p" + (active.settings.type != 'normal' ? " class='" + active.settings.type + "'" : "") + ">" + active.settings.text + "</p></div>");
				
				if (active.settings.timeout <= 0) {
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
					
					$(active.element).children().append(button);
				}
				
				if (active.settings.local && active.container.find('.messagePlaceholder')) {
					active.container = active.container.find('.messagePlaceholder');
				}

				if (active.settings.animate) {
					active.element.hide();
					active.container.prepend(active.element);
					active.element.slideDown();
				} else {
					active.container.prepend(active.element);
				}

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