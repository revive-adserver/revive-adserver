/**
 *
 */
jQuery.fn.daterangepicker = function(rangeSelector, doneSelector, urlTemplate, startDate, endDate) {
  return this.each(function ()
  {
    var $this = $(this);
    var $range = $(rangeSelector);
    var format = "yy-mm-dd";
    
    var startDateParsed = $.datepicker.parseDate(format, startDate);
    var endDateParsed = $.datepicker.parseDate(format, endDate);
    
    $range.prepend($this.find("span").clone());
    $range.find("#date-range-picker-start-date > div, #date-range-picker-end-date > div").datepicker({
      duration: 0,
      dateFormat: format, 
      buttonImage: "assets/images/icon-calendar.gif", 
      buttonImageOnly: true,
      keyModifier: '',
      prevText: '',
      nextText: '',
      highlightCurrentDay: false
    });
    var $startPicker = $range.find("#date-range-picker-start-date > div");
    var $endPicker = $range.find("#date-range-picker-end-date > div");
    $startPicker.datepicker("change", { 
            onSelect: function() {
                var selectedStartDate = $startPicker.datepicker("getDate");
                var selectedEndDate = $endPicker.datepicker("getDate");
                $endPicker.datepicker("change", { minDate: selectedStartDate });
                $endPicker.datepicker("setDate", selectedEndDate);
            },
            maxDate: endDateParsed
        }).datepicker("setDate", startDateParsed);
        
    $endPicker.datepicker("change", { 
            onSelect: function() {
                var selectedStartDate = $startPicker.datepicker("getDate");
                var selectedEndDate = $endPicker.datepicker("getDate");
                $startPicker.datepicker("change", { maxDate: selectedEndDate });
                $startPicker.datepicker("setDate", selectedStartDate);
            },
            minDate: startDateParsed
        }).datepicker("setDate", endDateParsed);

    var $datepickers = $range.find("#date-range-picker-start-date, #date-range-picker-end-date");
    var $offscreen = $("<div></div>");
    $this.click(function() {
      $datepickers.hide();
      $datepickers.appendTo($offscreen);
      $(rangeSelector).css("min-width", $this.width());
      $range.showWithOverlay($.browser.msie ? 4 : 2);
    });
    
    $range.find("a.range").click(function() {
      $("#date-range-picker-controls").prepend($offscreen.children());
      $datepickers.sweepFadeIn(300);
      return false;
    });
    
    $(doneSelector).click(function() {
      var url = urlTemplate;
      url = url.replace(/_start_/gi, getFormattedDate("#date-range-picker-start-date > div"))
      url = url.replace(/_end_/gi, getFormattedDate("#date-range-picker-end-date > div"))
      window.location.href = url;
    });
  });
  
  function getFormattedDate(selector)
  {
    return $.datepicker.formatDate('yy-mm-dd', $(selector).datepicker("getDate"));
  }
};
