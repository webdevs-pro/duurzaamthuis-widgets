(function($) {


   $(document).on('click', '.dh-table-popup-open', function() {
      generateTable();
   });


   $(document).on('click', '.dh-table-popup-close, .dh-table-popup-wrapper', function() {
      saveData();
   });


   $(document).on('click', '.dh-table-popup', function(e) {
      e.stopPropagation();
   });

   function generateTable(rows) {
      var popup = $('.dh-table-popup-wrapper');
      var table = popup.find('table');
      var table_id = table.attr('data-table-id');
      if(!rows) {
         rows = JSON.parse($('#elementor-control-default-'+table_id).val());
         console.log('rows', rows);
      }
      
      // generate table html
      var table_html = '';
      $.each(rows, function(index, row) {
         table_html += '<tr>';
         $.each(row, function(index, cell) {
            table_html += '<td><span contenteditable="true">'+cell+'</span></td>';
         });
         table_html += '</tr>';
      });
      table.html(table_html);
      
      // show popup
      popup.addClass('active');

      // Return a helper with preserved width of cells  
      var fixHelper = function(e, ui) {  
         ui.children().each(function() {  
            $(this).width($(this).width());  
         });  
         return ui;  
      };
      // sortable rows

      $(table).sortable({  
         helper: fixHelper,
         cursor: "move",
         cancel: '[contenteditable]',
         placeholder: "sortable-placeholder",
         containment: '.dh-table-popup',
      });


      $.each($._data($(popup).closest('.elementor-control')[0], "events"), function(i, event) {
         $.each(event, function(j, h) {
            if(h.selector == '[contenteditable=\"true\"]') {
               handler = h.handler;
            }
         });
      });
      $(popup).closest('.elementor-control').unbind('input', handler); // fix contenteditable update control
   }


   function saveData() {
      var popup = $('.dh-table-popup-wrapper');
      var table_id = popup.find('table').attr('data-table-id');

      popup.removeClass('active');

      var trs = tableToArray(table_id);

      var json = JSON.stringify(trs);
      var rows = $('#elementor-control-default-'+table_id).val();
      // console.log(json);
      // console.log(rows);

      if(rows != json) {
         $('#elementor-control-default-'+table_id).val(json).trigger('change');
         $('#elementor-control-default-'+table_id).trigger('input');
      }
   }


   // copy fix for contenteditable
   $(document).on('copy', 'span[contenteditable]', function (e) {
      e = e.originalEvent;
      var selectedText = window.getSelection();
      var range = selectedText.getRangeAt(0);
      var selectedTextReplacement = range.toString();
      e.clipboardData.setData('text/plain', selectedTextReplacement);
      e.preventDefault(); // default behaviour is to copy any selected text
   });
   

   // paste fix for contenteditable
   $(document).on('paste', 'span[contenteditable]', function (e) {
      e.preventDefault();
      if (window.clipboardData) {
         content = window.clipboardData.getData('Text');        
         if (window.getSelection) {
            var selObj = window.getSelection();
            var selRange = selObj.getRangeAt(0);
            selRange.deleteContents();                
            selRange.insertNode(document.createTextNode(content));
         }
      } else if (e.originalEvent.clipboardData) {
         content = (e.originalEvent || e).clipboardData.getData('text/plain');
         document.execCommand('insertText', false, content);
      }        
   });


   // table to array
   function tableToArray(table_id) {
      var trs = $('table.dh-table-'+table_id+' tr').get().map(function(row) {
         return $(row).find('td > span').get().map(function(cell) {
            return $(cell).html();
         });
      });
      return trs;
   }

   
   // add row
   $(document).on('click', '.dh-add-row', function() {
      var table_id = $('.dh-table-popup-wrapper').find('table').attr('data-table-id');
      var trs = tableToArray(table_id);
      var last_row = trs[trs.length - 1];
      trs.push(last_row);
      generateTable(trs);
   });

   
   // add row
   $(document).on('click', '.dh-add-column', function() {
      var table_id = $('.dh-table-popup-wrapper').find('table').attr('data-table-id');
      var trs = tableToArray(table_id);
      var new_trs = [];
      $.each(trs, function(index, row) {
         row.push('');
         new_trs.push(row);
      });
      generateTable(new_trs);
   });


})(jQuery);
