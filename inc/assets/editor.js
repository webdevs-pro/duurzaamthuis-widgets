(function($) {

   // show popup
   $(document).on('click', '.dh-table-popup-open', function() {
      generateTable();
   });

   // close popup on wrapper click
   $(document).on('click', '.dh-table-popup-close, .dh-table-popup-wrapper', function() {
      saveData();
   });

   // fix close popup on click outside
   $(document).on('click', '.dh-table-popup', function(e) {
      e.stopPropagation();
   });


   // generate table
   function generateTable(rows) {
      var popup = $('.dh-table-popup-wrapper');
      var table = popup.find('table');
      var table_id = table.attr('data-table-id');
      if(!rows) {
         rows = JSON.parse($('#elementor-control-default-'+table_id).val());
         // console.log('rows', rows);
      }
      
      // generate table html
      var table_html = '';
      $.each(rows, function(row_index, row) {
         table_html += '<tr>';
         $.each(row, function(col_index, cell) {
            var control_html = '';
            if(row_index == 0) {
               control_html += '<div class="dh-col-control" data-col-index="'+col_index+'"><i class="fas fa-times"></i></div>';
            }
            if(col_index == row.length-1 ) {
               control_html += '<div class="dh-row-control" data-row-index="'+row_index+'"><i class="fas fa-times"></i></div>';
            }
            table_html += '<td><span contenteditable="true">'+cell+'</span>'+control_html+'</td>';
            
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
         start: function( event, ui ) {
            $('.dh-col-control').each(function(){
               $(this).removeClass('active');
            });
            $('.dh-row-control').each(function(){
               $(this).removeClass('active');
            });
         },
         stop: function( event, ui ) {
            var trs = tableToArray(table_id);
            generateTable(trs);
         }
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


   // save data
   function saveData() {
      var popup = $('.dh-table-popup-wrapper');
      var table_id = popup.find('table').attr('data-table-id');
      popup.removeClass('active');
      var trs = tableToArray(table_id);
      var json = JSON.stringify(trs);
      var rows = $('#elementor-control-default-'+table_id).val();
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
      var new_row = [];
      var column_count = trs[0].length;
      for(var i = 0; i < column_count; i++) {
         new_row.push('');
      }
      trs.push(new_row);
      generateTable(trs);
   });


   // add column
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


   // hover
   $(document).on('mouseenter', 'table td', function() {
      var cellIndex = this.cellIndex;
      var rowIndex = this.parentNode.rowIndex;
      $('.dh-col-control').each(function(){
         $(this).removeClass('active');
      });
      $('.dh-row-control').each(function(){
         $(this).removeClass('active');
      });
      $('.dh-col-control[data-col-index="'+cellIndex+'"]').addClass('active');
      $('.dh-row-control[data-row-index="'+rowIndex+'"]').addClass('active');
   });
   // $(document).on('mouseleave', 'table td', function() {
   //    var cellIndex = this.cellIndex;
   //    var rowIndex = this.parentNode.rowIndex;
   //    $('.dh-col-control[data-col-index="'+cellIndex+'"]').removeClass('active');
   //    $('.dh-row-control[data-row-index="'+rowIndex+'"]').removeClass('active');
   // });


   // delete column
   $(document).on('click', '.dh-col-control i', function(){
      var table_id = $('.dh-table-popup-wrapper').find('table').attr('data-table-id');
      var col_index = $(this).parent().data('col-index');
      var trs = tableToArray(table_id);
      if(trs[0].length == 1) return;
      $.each(trs, function(index, row) {
         row.splice(col_index,1);
      });
      generateTable(trs);
   });


   // delete row
   $(document).on('click', '.dh-row-control i', function(){
      var table_id = $('.dh-table-popup-wrapper').find('table').attr('data-table-id');
      var row_index = $(this).parent().data('row-index');
      var trs = tableToArray(table_id);
      if(trs.length == 1) return;
      trs.splice(row_index,1);
      generateTable(trs);
   });



})(jQuery);
