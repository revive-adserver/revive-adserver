
(function($) {
    $.extend({
        extendForm: new function() {
            var active = null;
            var nextBlur = null;
            var nextBlurItem = null;

            function onBlur() {
                var fieldset = $($(this).parents('fieldset')[0]);

                var nextBlurItem = fieldset;
                var nextBlur = function() {
                    if (active && nextBlurItem) {
                        if (active[0] == nextBlurItem[0]) {
                            nextBlurItem.removeClass('active');
                            getMessageOnFocus(nextBlurItem).hide();
                            active = null;
                        }
                    }

                    nextBlurItem = null;
                    nextBlur = null;
                }

                window.setTimeout(nextBlur, 250);
            }

            function onFocus() {
                if (nextBlur) {
                    nextBlur();
                }

                var fieldset = $($(this).parents('fieldset')[0]);
                var message = getMessageOnFocus(fieldset);

                if (active) {
                    active.removeClass('active');
                    getMessageOnFocus(active).hide();
                }

                if (!$(this).is(".nohighlight")) {
                    fieldset.addClass('active');
                }
				message.show();
                active = fieldset;
            }
            
            function getMessageOnFocus($fieldset)
            {
                return $fieldset.siblings("div.message").filter(".messageOnFocus");
            }

            function onToggle() {
                $(this).parents('fieldset').each(function() {
                    if ($(this).hasClass('minimized')) {
                        $(this).removeClass('minimized')
                    } else {
                        $(this).addClass('minimized')
                    }
                });
            }

            function onDateSelected(arg1, arg2) {
                $(this).trigger('uiDatepickerOnSelect', arg1);
            }
            
            this.construct = function(settings) {
                return this.each(function() {
                    $(this).find('fieldset fieldset *').bind('blur', onBlur);
                    $(this).find('fieldset fieldset *').bind('focus', onFocus);

                    $(this).find('fieldset .header').each(function() {
                        var toggle = $("<span class='toggle'></span>");
                        $(this).append(toggle);
                        $(this).css('cursor', 'pointer');
                        $(this).bind('click', onToggle);
                    });

                    $(this).find('.balloon').bind('click', function() {
                        $(this).find('.panel').showWithOverlay(3);
                    });

                    if ($.fn.datepicker) {
                        $(this).find('.typeDate').each( function() {
                            $(this).datepicker({ 
                                showOn: "both",     
                                duration: 0,
                                readOnly: $(this).hasClass('readOnly'),
                                dateFormat: $.datepickerFormat, 
                                buttonImageOnly: true,
                                buttonImageElement: 'span',
                                keyModifier: '',
                                onSelect : onDateSelected,
                                changeMonth: true,
                                changeYear: true
                            });
                            if ($(this).hasClass('readOnly')) $(this).attr('readonly', 'readonly');
                        });
                    }
                    
                    var ie6 = $.browser.msie && (parseInt($.browser.version) == 6);
                    if (ie6) { //hack the buttons submit (IE6 submits all button values if multiple)
                        $buttons = $(this).find('fieldset.buttons button'); 
                        $buttons.click(function() {
                            $buttons.not($(this)).attr('disabled', 'disabled');    
                        });    
                    }
                    
                });
            };
            
            this.focusFirst = function() {
                return this.each(function () {
                  var $this = $(this);
                  if ($this.is(".nofocus")) {
                    return;
                  }
                  
                  if ($this.find(".error").size() > 0) {
                      $this.find("li.error:first :input:not(:hidden):not(.nofocus):first").focus();
                  }
                  else {
                      $this.find(':input:not(:hidden):not(.nofocus):first').focus();
                  }
                });
            };
            
            /**
             * Sets current selection to the <li> element representing the form line
             * to which the first selected form element belongs. 
             */
            this.formLine = function() {
            	var $first = this.eq(0);
            	if ($first.is("li")) {
            		return $first;
            	} else {
            		return this.eq(0).parents("fieldset").eq(0).parent();
            	}
            };
            
            /**
             * Selects all form line level error messages from the current selection. 
             */
            this.formLineErrors = function() {
                return this.find("ul.error");
            };
            
            /**
             * Sets current selection to the immediate parent <li> element in which the
             * form element is contained.
             */
            this.formElementContainer = function() { 
                return this.parent('li');
            };
            
            /**
             * Sets the current selection to the container of balloon help for the
             * selected form element. If the selected element does not have a balloon
             * help, empty selection is returned.
             */
            this.formElementBalloonContainer = function() {
                return this.formElementContainer().next('li:has(div.balloon)');
            };
            
            /**
             * Sets the current selection to the <li> elements corresponding to the 
             * errors applicable to the selected element, if any.
             */
            this.formElementErrors = function() {
                return this.formLine().formLineErrors().find("li > label[for=" + this.attr("id") + "]").parent();
            };


            this.formElementLabels = function() {
                return this.formElementContainer().find("label[for=" + this.attr("id") + "]");
            };
            
            
            /**
             * Shows or hides the selected individual form elements, along with their 
             * balloon help and error messages, if any.
             */
            this.setFormElementVisible = function(visible, animate, callback) 
            {
                if (visible) {
                    this.showFormElement(animate, callback);
                } else {
                    this.hideFormElement(animate, callback);
                }
                return this;
            };
            
            
            /**
             * Controls visibility of form elements in terms of CSS visibility property.
             */
            this.setFormElementVisibility = function(visible) 
            {
                var $elements = this.add(
                                this.formElementLabels()).add(
                                this.formElementContainer()).add(
                                this.formElementBalloonContainer()).add(
                                this.formElementErrors());
                $elements.css("visibility", (visible ? "visible" : "hidden"));
                return this;
            };

            /**
             * Hides the selected individual form elements, along with their balloon help and
             * error messages, if any.
             */
            this.hideFormElement = function(animate, callback) 
            {
                return this.each(function() {
                  var $this = $(this);
                  $this.hideElement(animate, callback);
                  $this.formElementLabels().hideElement(animate, callback);
                  $this.formElementContainer().hideElement(animate, callback);
                  $this.formElementBalloonContainer().hideElement(animate);
                  $this.formElementErrors().hideElement(animate);
                  updateLineErrors($this.formLine().formLineErrors());
                });
            };

            
            /**
             * Shows the selected individual form elements, along with their balloon help and
             * error messages, if any.
             */
            this.showFormElement = function(animate, callback)
            {
                return this.each(function() {
                  var $this = $(this);
                  $this.showElement(animate, callback);
                  $this.formElementLabels().showElement(animate, callback);
                  $this.formElementContainer().showElement(animate, callback);
                  $this.formElementBalloonContainer().showElement(animate);
                  $this.formElementErrors().showElement(animate);
                  updateLineErrors($this.formLine().formLineErrors());
                });
            };
            
            /**
             * Sets up handers for radio/checkbox-controlled alternative form fragments.
             */
            $.formAlternativeDriver = function(alternatives) 
            {
              // Determine all driver elements and register listeners. Each listener
              // will have access to the full alternatives spec and will act based on it.
              var driverNames = {};
              $.each(alternatives, function(key, driverSpec) {
                $.each(driverSpec, function(driverName) {
                  driverNames[driverName] = true;
                });
              });

              $.each(driverNames, function(driverName) {
                var $driver = getDriver(driverName); 
                $driver.change(handle).click(handle);
              });
          
              return this;
              
              function handle() {
                $.each(alternatives, function(controlledSelector, driverSpec) {
                  var enabled = true;
                  $.each(driverSpec, function(driverSelector, requiredValues) {
                	$driverElement = getDriver(driverSelector);
                	if ($driverElement.is(":visible")) {
	                  var driverValue = getDriverValue($driverElement);
	                  enabled &= requiredValues[driverValue];
                	}
                  });
                  $(controlledSelector).setFormElementVisible(enabled);
                });
              }
              
              function getDriverValue($driver) {
                if ($driver.size() > 1) {
                  // Probably radio buttons
                  return $driver.filter(":checked").val();
                } else if ($driver.is(":checkbox")) {
                  return $driver.is(":checked") ? "1" : "0";
                } else {
                  return $driver.val();
                }
              }
              
              function getDriver(driverName) {
                return $(":input[name=" + driverName + "][type!=hidden]");
              }
            };

            /**
             * Handles a multientry from editor.
             */
            this.formMultientries = function (options) 
            {
              var $container = this.eq(0); 
              var defaults = {
                id: $container.attr("id"), // assume container's id by default
                numberOfEntriesToAdd: 1
              };
              var settings = $.extend({}, defaults, options);
              
              // Some commonly used elements
              var $entryTemplate = findBySuffix("template");
              var $noEntriesLine = findBySuffix("noEntriesLine");
              
              // Register remove entry handler
              $container.find("a[id$=removeLink]").click(function() {
                $(this).formLine().remove();
                if (getNewEntryIndex() == 0) {
                  $noEntriesLine.show();
                }
              });
              
              // Handler for adding more entries
              var $moreEntriesLink = findBySuffix("moreEntries");
              $moreEntriesLink.click(function() {
                for (var i = 0; i < settings.numberOfEntriesToAdd; i++) {
                  addNewEntry(i == 0);
                }
                $noEntriesLine.hide();
              });
              
              return this;
              
              
              function addNewEntry(focus)
              {
                // Determine the maxiumum entry index
                var maxIndex = getNewEntryIndex();

                // Clone and update ids in the entry
                var $newEntries = $entryTemplate.clone(true);
                $newEntries.find("*[id*=_template_], *[name*=_template_], label").each(function() {
                  updateAttributes($(this), maxIndex, ['name', 'id', 'for']);
                });
                $newEntries.attr("id", $newEntries.attr("id").replace(/_template/, "_" + maxIndex)); 
                
                $newEntries.insertBefore($moreEntriesLink.formLine());
                $newEntries.show();
                
                if (focus) {
                  $newEntries.find(":input:first").focus();
                }
              }
              
              function updateAttributes($element, replacement, attributeNames)
              {
                $.each(attributeNames, function(i, val) {
                  var attr = $element.attr(val);
                  if (attr && attr.length > 0) {
                    $element.attr(val, attr.replace(/_template_/g, "_" + replacement + "_")); 
                  }
                });
              }
              
              function getNewEntryIndex()
              {
                var maxIndex = -1;
                $entryTemplate.nextAll(":not(:last)").each(function() {
                  var split = this.id.split('_');
                  maxIndex = Math.max(maxIndex, split[split.length - 1]);
                });
                return ++maxIndex;
              }  
              
              function findBySuffix(suffix) 
              {
                return $container.find("#" + settings.id + "_" + suffix)
              }
            };

            /**
             * Handles copy textarea element created by OX_UI_Form_Fragment_CopyTextarea.
             */
            this.formCopyTextarea = function() 
            {
                var $textarea = this.find("textarea");
                this.find("textarea").selectText();
                if (window.clipboardData)
                { 
                  var linkId = $textarea.attr("id") + "Copy";
                  this.find(".copyTextareaLinks").prepend("<a href='#' title='Copy to clipboard' " +
                    "id='" + linkId + "' class='inlineIcon iconCut'>Copy to clipboard</a>");
                  $("#" + linkId).click(function() {
                    $textarea.select();
                    window.clipboardData.setData('Text', $textarea.val());
                    return false;
                  });
                }
                return this;
            }
            
            function updateLineErrors($lineErrorsUl)
            {
                if ($lineErrorsUl.find("li:visible").size() <= 1) {
                    $lineErrorsUl.removeClass('multiple');
                }
                else {
                    $lineErrorsUl.addClass('multiple');
                }
            }
        }
    });
    

    $.fn.formFieldsUpdateCheckbox = function(fieldsSelector) {
      var $this = this;
      this.change(updateFormFields).click(updateFormFields);
      
      function updateFormFields() {
        $(fieldsSelector).setFormElementVisible($this.is(":checked"), false).focus();
        $(fieldsSelector).formLine().formLineErrors().toggle($this.is(":checked"));
      }
    }; 
   
    
    $.fn.captcha = function(options) {
        var defaults = {
            reloadElemSelector : '',
            baseUrl: '',
            randomKeyName: 'reload',
            randomHiddenSelector: ''
        };
        var settings = $.extend({}, defaults, options);
        $image = $(this);
        
        var captchaUrl = settings.baseUrl != '' ? settings.baseUrl : $image.attr("src");
        var separator  = captchaUrl.indexOf("?") == -1 ? "?" : "&";

        if (settings.reloadElemSelector) {
            $(settings.reloadElemSelector).click(reloadCaptcha);
        }
        
        function reloadCaptcha()
        {
                var random = new Date().getTime();
                var reloadUrl = captchaUrl 
                    + separator
                    + settings.randomKeyName +"=" + random; 
                
                $image.attr("src", reloadUrl);
                
                if (settings.randomHiddenSelector != '') {
                    $(settings.randomHiddenSelector).val(random);
                }
                
                return false;
        }
    }
    

    // extend plugin scope
    $.fn.extend({
        extendForm: $.extendForm.construct,
        focusFirst: $.extendForm.focusFirst,
        
        showFormElement: $.extendForm.showFormElement,
        hideFormElement: $.extendForm.hideFormElement,
        setFormElementVisible: $.extendForm.setFormElementVisible,
        setFormElementVisibility: $.extendForm.setFormElementVisibility,
        
        formLine: $.extendForm.formLine,
        formLineErrors: $.extendForm.formLineErrors,
        
        formElementContainer: $.extendForm.formElementContainer,
        formElementLabels: $.extendForm.formElementLabels,
        formElementErrors: $.extendForm.formElementErrors,
        formElementBalloonContainer: $.extendForm.formElementBalloonContainer,
        
        formMultientries: $.extendForm.formMultientries,
        formCopyTextarea: $.extendForm.formCopyTextarea
    });

    // extend all forms
    $(document).ready(function() {
        $('form').extendForm().focusFirst();
    });
})(jQuery);
