/**
 * Client-side code for rule editors.
 */
(function($) {
  /**
   * A handler for the whole rule editor, including adding, editing and removing
   * of rules.
   */
  $.fn.ruleEditor = function(options) {
    var $editor = $(this);
    
    /**
     * We're creating a new function (new object), so that we can handle multiple
     * instances of rule editors. The "current" instance ($editor) is available
     * via closure.
     */
    (new function() {
      var thisRuleEditor = this;
    
      this.construct = function() {
        makeAddRuleSection();
        makeRuleSections($editor.find("li.ruleLine"));
        
        $editor.bind("ruleEditStarted", function() {
          $editor.addClass("ruleEditing").find("li.ruleLine:not(.ruleEditLine) a").disableLink();
        });
        $editor.bind("ruleEditStopped", function() {
          $editor.removeClass("ruleEditing").find("a").enableLink();
        });
      };
      
      function makeRuleSections($sections) {
        $sections.bind("ruleViewContentChanged", function() {
          var $section = $(this);
          $section.find(".ruleEditLink").disabledClick(editRule);
          $section.click(function() {
            if ($(this).is(".ruleViewLine")) {
              $(this).find(".ruleEditLink").click();
            }
          });
          $section.find(".ruleRemoveLink").disabledClick(removeRule);
        }).trigger("ruleViewContentChanged");
        
        $sections.bind("ruleEditRequested", function() {
          handleRuleChangeRequested($(this), 'Loading...');
          $editor.trigger("ruleEditStarted");
        });
        
        $sections.bind("ruleEditStarted", function() {
          $(this).find("li.ruleCancel").show();
        });
        
        $sections.bind("ruleEditStopped", function() {
          var $this = $(this);
          handleRuleChangeStopped($this);
          $this.find("li.ruleLoading").hide();
        });
        
        $sections.bind("ruleRemoveRequested", function() {
          handleRuleChangeRequested($(this), 'Removing...');
        });
        
        $sections.bind("ruleSaved", function() {
          $(this).addClass("ruleSavedLine");
        });
        
        $sections.bind("ruleChangeError", function() {
          var $this = $(this);
          handleRuleChangeStopped($this);
          $this.find("li.ruleLoading").find("span").indicator('error');
        });
        
        function handleRuleChangeStopped($ruleLine)
        {
          $ruleLine.removeClass("ruleEditLine ruleSavedLine").addClass("ruleViewLine");
          $ruleLine.find("li.ruleEdit, li.ruleRemove").show();
          $ruleLine.find("li.ruleChangesSaved").remove();
          $ruleLine.find("li.divider").remove();
          $editor.trigger("ruleEditStopped");
        }
        
        function handleRuleChangeRequested($ruleLine, $indicatorLabel)
        {
          $ruleLine.addClass("ruleEditLine").removeClass("ruleViewLine ruleSavedLine ruleLoadingLine");
          $ruleLine.find("li.ruleLoading").show().find("span").indicator('loading', $indicatorLabel);
          $ruleLine.find("li.ruleEdit, li.ruleRemove").hide();
        }
      }

      function makeAddRuleSection() {
        var url = options.emptyFormUrl;
        var $select = $editor.find(".addRuleSelect");
        var $loading = $select.formLine().find("li.ruleAddLoading");
        var $addLink = $editor.find(".ruleAddLink");
        
        $select.change(function() {
          var value = $select.val();
          if (value) {
            clearRuleFormElements();
            $loading.show().find("span").indicator("loading", "Loading...");
            $.ajax({
              url: url + value, 
              success: function(data) {
                $loading.hide();
                var $ol = $select.parentFieldset().find("ol");
                clearRuleFormElements();
                $ol.find("li:eq(0)").after($(data).find("fieldset > ol > li").parent());
                $editor.find("li.ruleCancelAdd").show();
                if (!options.allowEmptyMulticheckboxSelections) {
                    addMultiCheckboxHandler($editor, $addLink, "Select some value to add rule");
                }
              },
              error: function(data) {
                $loading.find('span').indicator('error', "Rule loading failed, please try again");
              }
            });
          } else {
            clearRuleFormElements();
            $loading.hide();
          }
        }).trigger("change");
        
        $addLink.disabledClick(addRule);
        
        $editor.bind('ruleAdded', function(event, addedRuleType, $addedRuleLine) {
          clearRuleFormElements();
          $select.val("");
        });
        
        $editor.find(".ruleCancelAddLink").disabledClick(function() {
          clearRuleFormElements();
          $select.val("");
        });
        
        $editor.bind("ruleEditStarted", function() {
          $select.formLine().find(":input").attr("disabled", true);
        });
        $editor.bind("ruleEditStopped", function() {
          $select.formLine().find(":input").attr("disabled", false);
        });

        function clearRuleFormElements() {
          $select.parentFieldset().find("ol li:gt(0)")
            .not("li.ruleAdd, li.divider.compact, li.ruleCancelAdd, li.ruleAddLoading, li.ruleAdding").remove();
          $editor.find("li.ruleCancelAdd").hide();
        }
      }
      
      function removeRule() {
        var $removeLink = $(this);
        $.ajax({
          url: $removeLink.attr("href"), 
          success: function(data) {
            fullRefresh(data);
          },
          error: function(data) {
            $removeLink.formLine().trigger("ruleChangeError")
          }
        });
        $removeLink.formLine().trigger("ruleRemoveRequested");
        return false;
      }
      
      function editRule() {
        var $editLink = $(this);
        $.ajax({
          url: $editLink.attr("href"), 
          success: function(data) {
            var $elements = $(data).find("ol");
            var $saveLink = $elements.find(".ruleSaveLink");
            $saveLink.disabledClick(saveRule);
            $elements.find(".ruleCancelLink").click(cancelRule);
            
            var $lineFieldset = $editLink.parents("fieldset:eq(0)");
            $lineFieldset.find("ol").hide();
            $lineFieldset.append($elements);
            var $line = $editLink.formLine();
            $line.trigger("ruleEditStarted");
            if (!options.allowEmptyMulticheckboxSelections) {
              addMultiCheckboxHandler($line, $saveLink, "Select some value to save changes");
            }
          },
          error: function(data) {
            $editLink.formLine().trigger("ruleChangeError");
          }
        });
        $editLink.formLine().trigger("ruleEditRequested");
        return false;
      }
      
      function saveRule() {
        var $saveLink = $(this);
        $.ajax({
          url: $saveLink.attr("href"), 
          data: $saveLink.parents("fieldset:eq(0)").elementValues(),
          type: 'POST',
          success: function(data) {
            var $formLine = $saveLink.formLine();
            $formLine.trigger("ruleEditStopped").trigger("ruleSaved");
            var $elements = $(data).find("ol");
            $saveLink.parents("fieldset:eq(0)").html($elements);
            $formLine.trigger("ruleViewContentChanged");
          },
          error: function(data) {
            var $line = $saveLink.formLine();
            $line.find("li.ruleCancel").show();
            $line.find("li.ruleSaving").find("span").indicator("error", "Saving changes failed, please try again");
          },
          complete: function() {
            $saveLink.enableLink();
          }
        });
        var $line = $saveLink.formLine();
        $saveLink.disableLink();
        $line.find("li.ruleSaving").show().find("span").indicator("loading", "Saving changes...");
        $line.find("li.ruleCancel").hide();
        return false;
      }
      
      function addRule() {
        var $addLink = $(this);
        var type = $addLink.parentFieldset().find("li:eq(0) select").val();
        if (!type) {
          return false;
        }
        var $addLine = $addLink.formLine();
        $addLine.find("li.ruleAdding").show().find("span").indicator("loading", "Adding...");
        $addLine.find("li.ruleCancelAdd").hide();
        
        $.ajax({
          url: $addLink.attr("href") + type, 
          data: $addLink.parentFieldset().elementValues(),
          type: 'POST',
          success: function(data) {
            fullRefresh(data);
          },
          error: function(data) {
            var $line = $addLink.formLine();
            $line.find("li.ruleCancelAdd").show();
            $line.find("li.ruleAdding").find("span").indicator("error", "Adding rule failed, please try again");
          },
          complete: function() {
            $addLink.enableLink();
          }
        });
        $addLink.disableLink();
        return false;
      }
      
      function cancelRule() {
        var $cancelLink = $(this);
        $cancelLink.formLine().trigger("ruleEditStopped");
        $cancelLink.parentFieldset().find("ol:eq(0)").show();
        $cancelLink.parentFieldset().find("ol:eq(1)").remove();
        return false;
      }
      
      function fullRefresh(data) {
        $editor.children("ol").children(":not(.ruleKeepLine)").remove();
        var $content = $(data).children().eq(0).children("ol").children();
        $editor.children("ol").append($content);
        
        // Call constructor once again to attach all listeners
        thisRuleEditor.construct();
        $editor.trigger("rulesRefreshed");
      }
      
      function addMultiCheckboxHandler($editor, $link, message)
      {
        var $multicheckboxes = $editor.find(".multiCheckbox"); 
        $multicheckboxes.multicheckboxes({
          clickElement: 'table',
          checkboxClicked: updateLink
        });
        if ($multicheckboxes.size() > 0) {
          updateLink();
        } else {
          $link.enableLink();
        }
        
        function updateLink() {
          var anyChecked = false;
          $editor.find(".multiCheckbox").find(":checkbox").each(function() {
            if (this.checked) {
              anyChecked = true;
              return false;
            }
          });
          if (anyChecked) {
            $link.enableLink();
          } else {
            $link.disableLink(message);
          }
        }
      }
    }).construct();
    
    return this;
  };

  $.fn.elementValues = function() {
    var values = {};
    this.find(":input").not(":checkbox:not(:checked)").not(":radio:not(:checked)").each(function () {
      var $this = $(this);
      if (!values[$this.attr("name")]) {
        values[$this.attr("name")] = [];
      }
      values[$this.attr("name")].push($this.val());
    });
    return values;
  };
  
  $.fn.parentFieldset = function() {
    return this.parents("fieldset:eq(0)");
  };
  
  /**
   * Showing/hiding of options in an enum editor with operator, 
   * lazy loading of options, if needed.
   */
  $.fn.ruleOperator = function($url, onSuccess) {
    return this.each(function() {
      $(this).change(selected);
      
      function selected() {
        var $this = $(this);
        var ruleName = this.id.substring(0, this.id.length - 2);
        var $indicator = $("#" + ruleName + "Loading").formElementContainer();
        var $values = $("#" + ruleName);
        
        if ($values.size() == 0 && $this.val() != 'nr') {
          loadOptions();
        }
        else
        {
          showOptions();
        }
        
        function loadOptions()
        {
          $indicator.show().find("span").indicator("loading", "Loading...");
          $.ajax({
            url: $url, 
            success: function(data) {
              // IE is really slow to parse the response into a jQuery object
              // so we need to resort to a nasty substring hack here.
              var start = "<fieldset class=\" noTitle\"><ol>";
              var end = "</ol></fieldset></li></form>";
              var options = data.substring(data.indexOf(start + "<li>") + start.length, 
                                           data.indexOf(end));
              $this.formElementContainer().after(options);
              if (onSuccess) {
                onSuccess.call($this);
              }
              showOptions();
            },
            error: function() {
              var link = "<a id='" + ruleName + "Reload' href='#'>try again</a>";
              $indicator.find('span').indicator('error', "Data loading failed, please " + link);
              $("#" + ruleName + "Reload").click(function() {
                loadOptions();
                return false;
              });
            }
          });
        }
        
        function showOptions() {
          var $values = $("#" + ruleName);
          $indicator.hide();
          if ($this.val() == 'nr') {
              $values.slideFadeOut();
          }
          else {
              $values.slideFadeIn();
          }
        }
      }
    });
  };
})(jQuery);