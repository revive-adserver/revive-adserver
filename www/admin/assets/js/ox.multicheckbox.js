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
      var cache = new Object();

      var $container = $(this);
      
      //console.log("Registered mulitcheckbox for " + $container.attr("id") + ":" + options.id);
      
      $container.bind('stateUpdate', function(event, internalId, $checkboxes) {
        if (internalId == options.id) {
            //console.log($container.attr("id") + ":" + options.id + " ignoring change from  " + internalId + "  for " +  $checkboxes);
        }
        else {
            //console.log($container.attr("id") + ":" + options.id + " observed change  " + internalId + "  for " +  $checkboxes)
            var parentCache = new Array();            
            $checkboxes.each(function() {
                var $checkbox = $(this);
                if ($checkbox.size() != 0 && cacheableIsMultiCheckbox($checkbox)) {
                    //filter out multiple updates for the same parent
                    var $parent = cacheableGetParentCheckbox($checkbox);
                    if ($parent && $parent.size() > 0) {
                      var cacheId = getCacheId($parent);
                      if (!parentCache[cacheId]) {
                          handleCheckboxStateChange($checkbox, $checkbox, false);
                          parentCache[cacheId] = true;
                      }
                    } 
                    else { //probably has children - call state update
                        handleCheckboxStateChange($checkbox, $checkbox, false); 
                    }
                }
            });
            $container.trigger("multichange");
        }
      });
      
      $container.bind('dataUpdate', clearCache); //table rows count might have changed, clear cache

      $container.click(function(event) {
        var $target = $(event.target);

        //console.log($(this).attr("id") + ":" + options.id + " got click");

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
        
        if ($checkbox.is(options.selectAllSelector)) {
            handleSelectAllChange($checkbox);
        }
        else {
            handleCheckboxStateChange($checkbox, $target, true);
        }
      });
      
      
      function handleCheckboxStateChange($checkbox, $target, triggerMultichange)
      {
        if ($checkbox.size() != 0 && cacheableIsMultiCheckbox($checkbox)) {
          if (options.checkboxClicked) {
            options.checkboxClicked.call($checkbox);
          }
          var $parent = cacheableGetParentCheckbox($checkbox);
          if ($parent && $parent.size() != 0) { //check if has parent
            // has parent -  a child checkbox has been clicked
            options.updateParent.call($target, $parent, cacheableGetChildCheckboxes($parent));
            updateTableRow($checkbox, options);
            updateTableRow($parent, options);
          }
          else {
            var $children = cacheableGetChildCheckboxes($checkbox);
            if ($children && $children.size() != 0) {
              // found children, so $parent is probably a parent
              options.updateChildren.call($target, $children, $checkbox.get(0).checked); 
              updateTableRow($children, options);
              updateTableRow($checkbox, options);
            
              //in multidimensional multicheckbox cases - like one checkbox has many parents, we
              //need to inform checkbox of state change so that it could inform it's other parents
              //console.log(options.id + ' triggered parent state update');             
              $container.trigger('stateUpdate', [options.id, $children]);
            }
          }
          
          if (options.selectAllSelector && !$checkbox.is(":checked")) {
            $(options.selectAllSelector).attr("checked", false);
          }
          if (triggerMultichange) {
            $container.trigger("multichange");
          }
        }
        else {
            //console.log($container.attr("id") + ":" + options.id + " ignored click on " + $checkbox.attr('id'));
        }      
      }
      
      
      function handleSelectAllChange($checkbox)
      {
        var $checkboxes = $container.find(":checkbox").not(options.selectAllSelector);
        var allChecked = $checkbox.is(":checked");
        $checkboxes.attr("checked", allChecked);
        
        // Ideally, we should call updateTableRow($checkboxes, options) here, but
        // it's much faster to perform the update directly on all elements
        if (options.updateElement) {
          var $elements = $container.find(options.updateElement);
          if (allChecked) {
            $elements.addClass(options.toSelectClass);
          } else {
            $elements.removeClass(options.toSelectClass);
          }
        }
        
        $container.trigger("multichange");
      }
      
      
      function clearCache()
      {
        cache = new Object();
      }
      
      
      function cacheableIsMultiCheckbox($checkbox)
      {
          var uniqueId = getCacheId($checkbox);
          var result = callWithCache('IsMultiCheckbox' + uniqueId, $container, options.isMultiCheckbox, [$checkbox]);
        
          return result;        
      }
      
      
      function cacheableGetChildCheckboxes($checkbox)
      {
          var uniqueId = getCacheId($checkbox);
          var result = callWithCache('GetChildCheckboxes' + uniqueId, $container, options.getChildCheckboxes, [$checkbox]);
          
          return result;
      }
      
      
      function cacheableGetParentCheckbox($checkbox)
      {
          var uniqueId = getCacheId($checkbox);
          var result = callWithCache('GetParentCheckbox' + uniqueId, $container, options.getParentCheckbox, [$checkbox]);
          
          return result;        
      }
      

      function callWithCache(key, object, callback, args)
      {
        if (cache[key]) {
            return cache[key];
        }
        var result =  callback.apply(object, args);
        cache[key] = result;
        
        return result;   
      }
      
      /** Stores unique cache id for this element in jquery store **/ 
      function getCacheId($element) 
      {
        var cacheId = $.data($element.get(0), 'mc_cache_id'); 
        
        if (!cacheId) {
            cacheId = 'cid' + $.data($element);
            $.data($element.get(0), 'mc_cache_id', cacheId);
        }
        
        return cacheId;
      }
      

      /**
       * Updates the style of the table row
       */
      function updateTableRow($checkboxes, options) {
        if (options.updateElement) {
          $checkboxes.each(function () {
            var $checkbox = $(this);
            var $row = cacheableGetElementParent($checkbox, options.updateElement);
            
            if ($row.size() == 0) {
              return true;
            }
          
            var newState = $checkbox.get(0).checked;
            if (newState) {
                $row.addClass(options.toSelectClass);
            }
            else {
                $row.removeClass(options.toSelectClass);
            }
          });
        }
      }
      
      
      function cacheableGetElementParent($element, parentType)
      {
          var uniqueId = getCacheId($element);
          var result = callWithCache('GetElementParent' + parentType + uniqueId, 
              $container, 
              function($element, parentType) {
                  return $element.parents(parentType).eq(0);    
              }, 
              [$element, parentType]);
          
          return result;
      }
      
    });
  };

  
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
  function synchronizeParentWithChildren($parentCheckbox, $children) 
  {
    var allChecked = true;
    
    $children.each(function() {
      if (!this.checked) {
        allChecked = false;
        return false;
      }
     });    
    
    $parentCheckbox.attr("checked", allChecked);
  }

  
  function clearParentIfAnyChildChecked($parentCheckbox, $children) 
  {
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
