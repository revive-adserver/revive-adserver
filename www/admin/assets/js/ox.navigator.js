(function($) {
  
    function listColumn(parent, options, data) {

      this.keydown = function(event) {
          var elem = event.data.list.find('.selected');
          
          switch(event.keyCode) {
              case 37:  event.preventDefault();
                        if (event.data.onprev) {
                            event.data.onprev(false);
                        }
                        break;
                        
              case 38:  event.preventDefault();
                        var prev = elem.prev();
                        if (prev.length) {
                          prev.addClass('selected');
                          elem.removeClass('selected');
                          event.data.change(prev);
                        }
                        break;
                        
              case 39:  event.preventDefault();
                        if (event.data.onnext) {
                            event.data.onnext(false);
                        }
                        break;
                        
              case 40:  event.preventDefault();
                        var next = elem.next();
                        if (next.length) {
                          next.addClass('selected');
                          elem.removeClass('selected');
                          event.data.change(next);
                        }
                        break;
                        
              case 32:
              case 13:  event.preventDefault();
                        event.data.select(elem);
                        break;
                        
              case 9:   event.preventDefault();
                        if (event.shiftKey) {
                            if (event.data.onnext) {
                                event.data.onnext(true);
                            }
                        } else {
                            if (event.data.onprev) {
                                event.data.onprev(true);
                            }
                        }
                        break;
          }
      }
      
      this.click = function(event) {
          event.stopPropagation();
          event.preventDefault();
        
          event.data.activate();
        
          var target = jQuery(event.target).parents('li');
          event.data.list.find('li.selected').removeClass('selected');
          target.addClass('selected');
        
          event.data.change(target);
          event.data.select(target);
      }
      
      this.select = function(elem) {
          var id = elem[0].id.replace(this.options.name + '_', '');
          if (this.onselect) {
              this.onselect(id);
          }
      }
      
      this.change = function(elem) {
          this.focus();

          var id = elem[0].id.replace(this.options.name + '_', '');
          if (this.onchange) {
              this.onchange(id);
          }     
      }

      this.focus = function() {
          if (this.list.find('.selected').length) {
          } else {
              this.list.find('li:first').addClass('selected');
          }

          this.list.find('.selected a').focus();
      }

      this.activate = function() {
          this.focus();
          
          if (this.onactivate) {
              this.onactivate();
          }
          this.list.addClass('active');
      }

      this.deactivate = function() {
          this.list.removeClass('active');
      }

      this.load = function(data) {
        this.empty();
        this.list.removeClass('loading');

        for (k in data) {
            var d = this.options.name;
            var d = this.options.className;
            var d = data[k].name;
          
            var item = jQuery("<li id='" + this.options.name + "_" + k + "'><a href='#' class='inlineIcon " + this.options.className + "' title='" + data[k].name + "'>" + data[k].name + "</a></li>");
            
            if (this.options.id == k) {
              item.addClass('selected');
            }
            
            item.bind('click', this, this.click);
            item.bind('keydown', this, this.keydown);
            this.list.append(item);
        }
      }
      
      this.empty = function() {
        this.list.html('');
        this.list.addClass('loading');
      }
      
      this.options = options;
      parent.append(jQuery("<strong>" + this.options.label + "</strong>"));
      this.list = jQuery("<ul></ul>");
      parent.append(this.list);
      this.load(data);
    };
  
  
    $.extend({
        activateNavigator: new function() {

            var container = null;
            var entities = null;
            var data = null;
            var loading = null;
            

            function buildColumn(i, entity, data) {
                var column = jQuery("<div class='column'></div>");
                container.append(column);
                if (i == 0) {
                    column.addClass('first');
                }

                entities[i].column = new listColumn(column, entities[i], data);
                entities[i].column.onnext = function(cycle) {
                    if (i < entities.length - 1) {
                        entities[i + 1].column.activate();
                    } else {
                        if (cycle) {
                            entities[0].column.activate();
                        }
                    }
                };
                entities[i].column.onprev = function(cycle) {
                    if (i > 0) {
                        entities[i - 1].column.activate();
                    } else {
                        if (cycle) {
                            entities[entities.length - 1].column.activate();
                        }
                    }
                };
                entities[i].column.onactivate = function() {
                    for (var j = 0; j < entities.length; j++) {
                        entities[j].column.deactivate();
                    }
                };
                entities[i].column.onselect = function(id) {
                  if (i == entities.length - 1) {
                    selectItem(id);
                  }
                };
                entities[i].column.onchange = function(id) {
                  if (i < entities.length - 1) {
                    for (var j = i + 1; j < entities.length; j++) {
                      entities[j].column.empty();
                    }
                    
                    var columnData = data;
                    for (var j = 0; j < i; j++) {
                        if (j + 1 < entities.length) {
                            columnData = columnData[entities[j].id]['items'];
                        }
                    }

                    if (columnData[id]) {
                      entities[i].id = id;
                      
                      if (columnData[id]['items']) {
                        entities[i + 1].column.load(columnData[id]['items']);
                      } else {
                        var parameters = '';
                        for (var j = 0; j < i; j++) {
                            parameters += entities[j].name + '=' + entities[j].id + '&';
                        }
                        parameters += entities[i].name + '=' + id;
                        loading = entities[i].name + '=' + id;
                        
                        $.getJSON("inventory-retrieve.php?" + parameters,
                          function(d){
                            columnData[id]['items'] = d;
                            if (loading == entities[i].name + '=' + entities[i].id) {
                              entities[i + 1].column.load(columnData[id]['items']);
                            }
                        });
                      }
                    } 
                  }
                };
            }
            
            function selectItem(id) {
                var parameters = '';
                for (var i = 0; i < entities.length - 1; i++) {
                    parameters += entities[i].name + '=' + entities[i].id + '&';
                }
                parameters += entities[entities.length - 1].name + '=' + id;
                window.location = '?' + parameters;
            }
            
            function focus(event, target) {
                if (target.tagName == 'LI' && $(target).hasClass('ent')) {
                    var className = target.className.match(/icon[a-z]+/i)
                    for (var i = 0; i < entities.length; i++) {
                        if (entities[i].className == className) {
                            entities[i].column.activate();
                        }
                    }
                }
            }

            this.construct = function(e, d) {
                return this.each(function() {
                    $(this).bind('dropdownOpen', focus);

                    container = $(this).find('.panel div');
                    entities = e;
                    data = d;
              
                    var columnData = data;
                  
                    for (var i = 0; i < entities.length; i++) {
                        buildColumn(i, entities[i], columnData);
                        
                        if (i + 1 < entities.length) {
                            columnData = columnData[entities[i].id]['items'];
                        }
                    }
                });
            };
        }
    });

    // extend plugin scope
    $.fn.extend({
        activateNavigator: $.activateNavigator.construct
    });
})(jQuery);
                
