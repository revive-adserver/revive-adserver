/**
 * A plugin for handling 2-level checkbox hierarchies. The convention
 * that defines parent-child relationships between checkboxes is that all checkboxes whose
 * id starts with "<parent-checkbox-id>_" are treated as the parent's childs.
 *
 * The utitlity comes in two variants:
 *   - multicheckbox() -- suitable for individual checkboxes (O(1)), not suitable
 *     for large numbers of checkboxes (e.g. in tables) -- large event handler 
 *     installation overhead
 *
 *   - multicheckboxes() -- uses event delegation, suitable for large numbers of
 *     checkboxes (e.g. in tables). Also provides additional support for checkboxes
 *     embedded in table rows (selecting checkbox when row is clicked, row styling
 *     dependant on previous/new checkbox state).  
 */
(function($) {
  /**
   * Treats each of the selected checkboxes as master checkboxes and installs
   * the master-slave handler for both the master and its dependants. 
   * - Dependent checkboxes can be selected using built in parent-child id-based
   * selector or using given childSelector.
   * - parent state can affect only particular slaves by usage of condition statement.
   * eg. if parent is selected some of them are selected.
   *
   * Please note that in order to select parent all slaves must be selected.
   * You can also disable changing parent state when all children are selected using
   * childAffectParent attribute 
   *
   * Not suitable for large numbers of checkboxes, use multicheckboxes() instead. 
   */
  $.fn.multicheckboxcondition = function(settings) {
    return this.each(function() {
      var defaults = {
        childSelector: "[@id^='" + this.id + "_']", // by default children share id prefix with parent
        childAffectParent: true, 
        condition: function(checkbox, parentChecked) {
            return true;
        }
      };
      
      var options = $.extend({ }, defaults, settings); 

      var $parent = $(this);

      $(options.childSelector)
         .click(function (event) {
	        if (options.childAffectParent) {
	            // Check if all checkboxes in the group are checked
                var allChecked = true;
	        
		        $(options.childSelector).each(function() {
		          if (!this.checked) {
		            allChecked = false;
		            return false;
		          }
		        });
		        $parent.attr("checked", allChecked);
		    }
	        event.stopPropagation();
	      })
        .bind('stateUpdate', function(event, parentId) {
            if (parentId != $parent.attr('id')) { //ignore changes for my parent
                // Check if all checkboxes in the group are checked
                var allChecked = true;
            
	            if (options.childAffectParent) {
	                $(options.childSelector).each(function() {
	                  if (!this.checked) {
	                    allChecked = false;
	                    return false;
	                  }
	                });
	                $parent.attr("checked", allChecked);
	            }            
            }
        });

      $parent.click(function(event) {
        var parent = this;
        $(options.childSelector).each(function() {
            if (options.condition(this, parent.checked) == true) {
                $(this).attr("checked", parent.checked);
                $(this).trigger('stateUpdate', [parent.id]); //inform other multichexboxes of state change
            }        
        });
        event.stopPropagation();
      });
    });
  };



  /**
   * Treats each of the selected checkboxes as parent checkboxes and installs
   * the parent-child handler for both the parent and its children.
   *
   * Not suitable for large numbers of checkboxes, use multicheckboxes() instead. 
   */
  $.fn.multicheckbox = function() {
    return this.each(function() {
      var $parent = $(this);

      $("[@id^='" + this.id + "_']").click(function (event) {
        // Check if all checkboxes in the group are checked
        var allChecked = true;
        
        $("[@id^='" + $parent.attr("id") + "_']").each(function() {
          if (!this.checked) {
            allChecked = false;
            return false;
          }
        });
        
        $parent.attr("checked", allChecked);
        event.stopPropagation();
      }); 

      $parent.click(function(event) {
        $("[@id^='" + this.id + "_']").attr("checked", this.checked);
        event.stopPropagation();
      });
    });
  };



  /**
   * Installs parent-child handler on an element (e.g. table) that contains
   * all the checkboxes and uses event delegation to handle individual clicks.
   * Optionally, if checkboxes are contained in table rows, clicking anywhere
   * in the row can change the state of the checkbox -- see the options object
   * for more details. 
   * Allows use of custom functions to find parent/child relationships
   */
  $.fn.multicheckboxes = function(settings) {
    return this.each(function() {
      var defaults = {
        id: Math.random(),
        clickElement: null,
        updateElement: null,
        containerClicked: fold,
        checkboxClicked: null,
        updateChildren: synchronizeChildrenWithParent,
        updateParent: synchronizeParentWithChildren,
        selectedClass: "selected",    // style to apply to rows with selected checkboxes
        unselectedClass: "unselected",// style to apply to rows with unselected checkboxes 
        toSelectClass: "to-select",   // style to apply to rows with originally unselected checkboxes, but now selected
        toUselectClass: "to-unselect",// style to apply to rows with originally selected checkboxes, but now unselected
        selectAllSelector: "#select-all", // if provided, all checkboxes within the container will be selected/unselected according to this selector's checkbox
        isMultiCheckbox : function ($checkbox) { 
            return $checkbox.attr("id");
        },
        /**
        * Returns children checkboxes for a parent checkbox. Currently, the
        * formula for parent-child relationship is hardcoded.
        */ 
        getChildCheckboxes: function($parentCheckbox) {
            return $("[@id^='" + $parentCheckbox.attr("id") + "_']");
        },
        
        getParentCheckbox: function($childCheckbox) {
            var checkboxId = $childCheckbox.attr("id");
            return $("#" + checkboxId.substring(0, checkboxId.indexOf("_")));
        }
      };
      
      var options = $.extend({ }, defaults, settings); 

      var $container = $(this);
      $container.updatestate();
      
      $container.find(options.selectAllSelector).click(function() {
        var $checkboxes = $container.find(":checkbox").not(options.selectAllSelector);
        $checkboxes.attr("checked", this.checked);
        updateTableRow($checkboxes, options);
        $container.trigger("multichange");
      });
      
      $container.bind('stateUpdate', function(event, internalId, $checkboxes) {
        if (internalId == options.id) {
            //console.log(options.id + " ignoring change " +  $checkboxes);
        }
        else {
            //console.log(options.id + " observed change " +  $checkboxes);
            $checkboxes.each(function() {
                handleCheckboxStateChange($(this));
            });
        }
      });

      $container.click(function(event) {
        var $target = $(event.target);

        if (options.containerClicked) {
          options.containerClicked.call($target);
        }

        // Check the element to which the event applies
        var ie6 = $.browser.msie && (parseInt($.browser.version) == 6);
        var $checkbox;
        if ($target.is(":checkbox")) {
          $checkbox = $target;
        } 
		else if (options.clickElement && ($target.is(options.clickElement) || (ie6 && $target.is("label")))) {
          $checkbox = $target.parent().find(":checkbox");
          if (!$checkbox.get(0)) {
            return;
          }
          $checkbox.get(0).checked = !$checkbox.get(0).checked; 
        } 
        else {
          return;
        }

        handleCheckboxStateChange($checkbox, $target);
      });
      
      
      function handleCheckboxStateChange($checkbox, $target)
      {
        if ($checkbox.size() != 0 && options.isMultiCheckbox($checkbox)) {
          if (options.checkboxClicked) {
            options.checkboxClicked.call($checkbox);
          }
          $children = options.getChildCheckboxes($checkbox);
          if ($children.size() != 0) {
            // found children, so $parent is probably a parent
            options.updateChildren.call($target, $children, $checkbox.get(0).checked); 
            updateTableRow($children, options);
            updateTableRow($checkbox, options);
          
            //in multidimensional multicheckbox cases - like one checkbox has many parents, we
            //need to inform checkbox of state change so that it could inform it's other parents
            //console.log(options.id + ' triggered parent state update');             
            $container.trigger('stateUpdate', [options.id, $children]);
          }
          else {
            // didn't find children, so a child checkbox has been clicked
            var $parent = options.getParentCheckbox($checkbox);
            if ($parent.size() == 0) {
             return;
            }
            options.updateParent.call($target, $parent, options.getChildCheckboxes($parent));          
            updateTableRow($checkbox, options);
            updateTableRow($parent, options);
          }
          $container.trigger("multichange");
        }      
      }
    });
  };

  
  $.fn.updatestate = function() {
     return this.find(":checkbox").each(function() {
       $(this).data("state", this.checked);
     });
  }; 

  
  /**
   * Updates the style of the table row
   */
  function updateTableRow($checkboxes, options) {
    if (options.updateElement) {
      $checkboxes.each(function () {
        var $checkbox = $(this);
        var $row = $checkbox.parents(options.updateElement).eq(0);
        if ($row.size() == 0) {
          return true;
        }
      
        var originalState = $checkbox.data("state");
        var newState = $checkbox.get(0).checked;
         
        $row.removeClass(options.selectedClass + " " + options.unselectedClass + " " + options.toSelectClass + " " + options.toUselectClass);
        if (originalState && newState && options.selectedClass) {
          $row.addClass(options.selectedClass);
        }
        else if (!originalState && !newState && options.unselectedClass) {
          $row.addClass(options.unselectedClass);
        }      
        else if (originalState && !newState && options.toUselectClass) {
          $row.addClass(options.toUselectClass);
        }      
        else if (!originalState && newState && options.toSelectClass) {
          $row.addClass(options.toSelectClass);
        }
      });
    }
  }

  
  function fold()
  {
    if (this.is("td.handle") || this.is("span")) {
      this.parents("tr:eq(0)").find("table").toggle();
    }
  }

  
  function synchronizeChildrenWithParent($children, parentChecked)
  {
    $children.attr("checked", parentChecked);
  }
  
  function clearChildrenIfParentChecked($children, parentChecked)
  {
    if (parentChecked) {
      $children.attr("checked", false);
    }
  }

  
  /**
   * Updates the state of the parent checkbox after the child checkboxes
   * have been checked/unchecked.
   */
  function synchronizeParentWithChildren($parentCheckbox, $children) {
    var allChecked = true;
    
    $children.each(function() {
      if (!this.checked) {
        allChecked = false;
        return false;
      }
    });
     
    $parentCheckbox.attr("checked", allChecked);
  }

  
  function clearParentIfAnyChildChecked($parentCheckbox, $children) {
    var anyChecked = true;
    
    $children.each(function() {
      if (!this.checked) {
        anyChecked = true;
        return false;
      }
    });
    
    if (anyChecked) {
      $parentCheckbox.attr("checked", false);
    }
  }

  
  $.multicheckbox = {
    synchronizeChildrenWithParent: synchronizeChildrenWithParent,
    synchronizeParentWithChildren: synchronizeParentWithChildren,
    clearChildrenIfParentChecked: clearChildrenIfParentChecked,
    clearParentIfAnyChildChecked: clearParentIfAnyChildChecked
  }
})(jQuery);
