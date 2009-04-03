(function($) {
    $.extend({
        activateTable: new function() {

            this.construct = function(settings) {
                return this.each(function() {
                    var $this = $(this);

                    var $parentCheckbox = $this.find('.toggleAll input');
                    var $childCheckboxes = $this.find('.toggleSelection input');
                    var $checkboxSelectionDependants = $this.find('.activeIfSelected');
                                        
                    $this.multicheckboxes({
                      selectedClass: "selected", 
                      unselectedClass: "", 
                      toSelectClass: "selected", 
                      toUselectClass: "",
                      selectAllSelector: ".toggleAll input",
                      updateElement: "tr",
                      useState: false,
                      isMultiCheckbox : function ($checkbox) { 
                          return $checkbox.parent(".toggleAll").size() == 1 
                            || $checkbox.parent(".toggleSelection").size() == 1; 
                      },
                      getChildCheckboxes: function($checkbox) {
                          return $checkbox.parent(".toggleAll").size() == 1 ? $childCheckboxes : $([]);
                      },
                      getParentCheckbox: function($checkbox) {
                        return $checkbox.parent(".toggleSelection").size() == 1 ? $parentCheckbox : $([]);
                      }
                    });
                    
                    
                    $this.bind("multichange", function() {
                        if ($childCheckboxes.filter(":checked").size() > 0) { 
                            //if there are any checkboxes selected enable
                            $checkboxSelectionDependants.removeClass('inactive');
                        }
                        else {
                            $checkboxSelectionDependants.addClass('inactive');
                        }
                    });

                    //preselect checkboxes
                   $childCheckboxes.filter(":checked").each(function() {
                      $(this).parents('tr').addClass('selected'); 
                    });
                    
                    $this.delegate( 'mouseover mouseout', 'tbody tr', function( event ){ 
                        $( this ).toggleClass('hilite'); 
                    });
                });
            };
        }
    });

    // extend plugin scope
    $.fn.extend({
        activateTable: $.activateTable.construct
    });


    // extend all forms
    $(document).ready(function() {
       $('.tableWrapper').activateTable();
    });

})(jQuery);
                
