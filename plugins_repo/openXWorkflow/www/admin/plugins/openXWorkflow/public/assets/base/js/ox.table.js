(function($) {
    $.extend({
        activateTable: new function() {

            function onToggleSelection(event) {
                var checked = this.checked;
                
                if (checked) {
                    $(this).parents('tr').addClass('selected'); 
                } else {
                    $(this).parents('tr').removeClass('selected');  
                }
                
                $(this).parents('table').find('.toggleAll input').each(function() {
                    if (this.checked != checked) {
                        this.checked = false;   
                    }
                });
                
                updateButtons(this);
            }
            

            function onToggleAll() {
                var checked = this.checked;
                
                $(this).parents('table').find('.toggleSelection input').each(function() {
                    if (checked) {
                        this.checked = true;
                        $(this).parents('tr').addClass('selected'); 
                    } else {
                        this.checked = false;
                        $(this).parents('tr').removeClass('selected');  
                    }
                });
                
                updateButtons(this);
            }
            
            function updateButtons(parent) {
                var count = $(parent).parents('table').find('.toggleSelection input:checked').length;
                
                if (count) {
                    $(parent).parents('.tableWrapper').find('.activeIfSelected').removeClass('inactive');
                } else {
                    $(parent).parents('.tableWrapper').find('.activeIfSelected').addClass('inactive');
                }
            }
            
            
            function onTableClick(clickedCell)
            {
                $clickedCell = $(clickedCell);
                
                $link = findClickableLink($clickedCell);
                
                if ($link != null) {
                    //"click" that link
                    window.location = $link.attr('href');
                }
            }
            
            
            function copyTextToTitle($td)
            {
                var $this = $td;
                if ($.trim($(this).attr("title")).length == 0) {
                    var title = $.trim($this.text().replace(/\s\s+/, " "));
                    if (title.length > 1) {
                        $this.attr("title", title);
                    }
                }
            }
            
            
            function findClickableLink($tableCell)
            {
                if ($tableCell.is('.no-click')) {
                    return null; //ignore such cells
                }
                
                $cellLinks = $tableCell.find('a');
                if ($cellLinks.length > 1) {
                    return null; //if this TD has more than one link, ignore
                }
                else if ($cellLinks.length == 1) {
                   return $cellLinks;
                }
                else if ($cellLinks.length == 0) { //look up, maybe there's a link in any cell, looking from left?
                    //TODO this is not locale aware LTR vs RTL
                    $otherCells = $tableCell
                        .siblings('td:not(.no-click)') //filter out no-click td
                        .filter(function() {         //filter - we want only single link cells if any
                            return $(this).find('a').length == 1;
                        });
                      
                    if ($otherCells.length == 0) {
                        return null; 
                    }
                   
                    $link =  $otherCells.eq(0).find('a');
                    return $link;
                }
                
                return null;
            }
            

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
                          return $checkbox.parents(".toggleAll").size() == 1 
                            || $checkbox.parents(".toggleSelection").size() == 1; 
                      },
                      getChildCheckboxes: function($checkbox) {
                          return $checkbox.parents(".toggleAll").size() == 1 ? $childCheckboxes : $([]);
                      },
                      getParentCheckbox: function($checkbox) {
                        return $checkbox.parents(".toggleSelection").size() == 1 ? $parentCheckbox : $([]);
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


                    //bind click listener
					$("table", $this).delegate("click", {
					  'td': function(e) { onTableClick(e.target); }
					});
					
                    $this.find('tbody td:not(.no-click)').each(function() {
                        $this = $(this);
                        $link = findClickableLink($this);
                        copyTextToTitle($this);
                        
                        if ($link != null) {
                            $(this).addClass("cursor-pointer");
                        }
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
