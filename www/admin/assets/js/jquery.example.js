/*
 * jQuery Example Plugin 1.3.4
 * Populate form inputs with example text that disappears on focus.
 *
 * e.g.
 *  $('input#name').example('Bob Smith');
 *  $('input[@title]').example(function() {
 *    return $(this).attr('title');
 *  });
 *  $('textarea#message').example('Type your message here', {
 *    class_name: 'example_text',
 *    hide_label: true
 *  });
 *
 * Copyright (c) Paul Mucur (http://mucur.name), 2007-2008.
 * Dual-licensed under the BSD (BSD-LICENSE.txt) and GPL (GPL-LICENSE.txt)
 * licenses.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */
(function($) {
  
  $.fn.example = function(text, args) {
    
    /* Merge the default options with the given arguments and the given
     * text with the example_text option.
     */
    var options = $.extend({},
                           $.fn.example.defaults,
                           args,
                           {example_text: text});
    
    /* Only calculate once whether a callback has been used. */
    var callback = $.isFunction(options.example_text);
    
    /* The following event handlers only need to be bound once
     * per class name. In order to do this, an array of used
     * class names is stored and checked on each use of the plugin.
     * If the class name is in the array then this whole section 
     * is skipped. If not, the events are bound and the class name 
     * added to the array.
     *
     * As of 1.3.2, the class names are stored as keys in the
     * array, rather than as elements. This removes the need for
     * $.inArray().
     */
    if (!$.fn.example.bound_class_names[options.class_name]) {
      
      /* Because Gecko-based browsers "helpfully" cache form values
       * but ignore all other attributes such as class, all example
       * values must be cleared on page unload to prevent them from
       * being saved.
       */
      $(window).unload(function() {
        $('.' + options.class_name).val('');
      });
      
      /* Clear fields that are still examples before any form is submitted
       * otherwise those examples will be sent along as well.
       * 
       * Prior to 1.3, this would only be bound to forms that were
       * parents of example fields but this meant that a page with
       * multiple forms would not work correctly.
       */
      $('form').submit(function() {
        
        /* Clear only the fields inside this particular form. */
        $(this).find('.' + options.class_name).val('');
      });
      
      /* Add the class name to the array. */
      $.fn.example.bound_class_names[options.class_name] = true;
    }
    
    return this.each(function() {
      
      /* Reduce method calls by saving the current jQuery object. */
      var $this = $(this);
      
      /* As of 1.3.4 and thanks to DeLynn Berry, the Metadata plugin can be
       * used in conjunction with this plugin. This means that the example
       * text can be set in the element itself, e.g.
       *
       * <input class="{example_text: 'Some text'}" />
       *
       * CAVEAT: It is not possible to set the class_name option using
       * the Metadata plugin as the class name is used before iterating
       * through each element (which is when the Metadata merging happens).
       */
      var o = $.metadata ? $.extend({}, options, $this.metadata()) : options;
      
      /* Internet Explorer will cache form values even if they are cleared
       * on unload, so this will clear any value that matches the example
       * text and hasn't been specified in the value attribute.
       *
       * The trick is to see whether a value has been set that is
       * different to the defaultValue attribute. As I do not want
       * to recklessly clear form inputs that are not examples on
       * document ready, only those with values that match the example
       * text will be cleared.
       *
       * If a callback is used, it is not possible to predict
       * what the example text is going to be so all non-default values
       * are cleared. This means that caching is effectively disabled for
       * that field.
       *
       * Many thanks to Klaus Hartl for this technique.
       */
      if ($.browser.msie && !$this.attr('defaultValue') &&
          (callback ? $this.val() != '' : $this.val() == o.example_text)) {
        $this.val('');
      }
      
      /* Initially place the example text in the field if it is empty. */
      if ($this.val() == '') {
        $this.addClass(options.class_name);
        
        /* The text argument can now be a function; if this is the case,
         * call it, passing the current element as `this`.
         */
        $this.val(callback ? o.example_text.call(this) : o.example_text);
      }
      
      /* DEPRECATION WARNING: I am considering removing this option.
       *
       * If the option is set, hide the associated label (and its line-break
       * if it has one).
       */
      if (options.hide_label) {
        var label = $('label[@for=' + $this.attr('id') + ']');
        
        /* The label and its line break must be hidden separately as
         * jQuery 1.1 does not support andSelf().
         */
        label.next('br').hide();
        label.hide();
      }
      
      /* Make the example text disappear when someone focuses.
       *
       * To determine whether the value of the field is an example or not,
       * check for the example class name only; comparing the actual value
       * seems wasteful and can stop people from using example values as real 
       * input.
       */
      $this.focus(function() {
        
        /* jQuery 1.1 has no hasClass(), so is() must be used instead. */
        if ($(this).is('.' + options.class_name)) {
          $(this).val('');
          $(this).removeClass(options.class_name);
        }
      });
    
      /* Make the example text reappear if the input is blank on blurring. */
      $this.blur(function() {
        if ($(this).val() == '') {
          $(this).addClass(options.class_name);
          
          /* Re-evaluate the callback function every time the user
           * blurs the field without entering anything. While this
           * is not as efficient as caching the value, it allows for
           * more dynamic applications of the plugin.
           */
          $(this).val(callback ? o.example_text.call(this) : o.example_text);
        }
      });
    });
  };
  
  /* Users can override the defaults for the plugin like so:
   *
   *   $.fn.example.defaults.class_name = 'not_example';
   *   $.fn.example.defaults.hide_label = true;
   */
  $.fn.example.defaults = {
    example_text: '',
    class_name: 'example',
    
    /* DEPRECATION WARNING: I am considering removing this option. */    
    hide_label: false
  };
  
  /* All the class names used are stored as keys in the following array. */
  $.fn.example.bound_class_names = [];
  
})(jQuery);