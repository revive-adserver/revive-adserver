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

            this.construct = function(settings) {
                return this.each(function() {
                    var count = 0;
                    
                    $(this).find('.toggleSelection input').each(function() {
                        if (this.checked) {
                            $(this).parents('tr').addClass('selected'); 
                            count++;
                        }
                    });
                    
                    if (count) {
                        $(this).find('.activeIfSelected').removeClass('inactive');
                    }
                    
                    $(this).find('.toggleAll input').bind('click', onToggleAll);
                    $(this).find('.toggleSelection input').bind('click', onToggleSelection);

                    $(this).find('tbody tr').hover(function () {
                        $(this).addClass("hilite");
                    }, function () {
                        $(this).removeClass("hilite");
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
                