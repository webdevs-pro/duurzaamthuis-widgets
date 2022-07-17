(function($) {

   var popup;
   var table;
   var table_id;
   var data;

   // show popup
   $(document).on('click', '.dh-control-popup-open', function() {
 
      data = $(this).data('settings');
      console.log(data);
      var singleTemplate = wp.template( 'dh-popup-control-template' );
      $('body').append( singleTemplate( data ) );

      popup = $('.dh-control-popup-wrapper');
      table = popup.find('table');
      table_id = $(table).attr('data-table-id');

      showPopup();

   });

   // close popup on wrapper click
   $(document).on('click', '.dh-control-popup-close, .dh-control-popup-wrapper', function() {
      saveData();
   });

   // fix close popup on click outside
   $(document).on('click', '.dh-control-popup', function(e) {
      e.stopPropagation();
   });


   // generate table
   function showPopup() {

      generateTable();
      
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
         containment: $(popup).find('.dh-control-popup'),
         start: function( event, ui ) {
            $(popup).find('.dh-col-control').each(function(){
               $(this).removeClass('active');
            });
            $(popup).find('.dh-row-control').each(function(){
               $(this).removeClass('active');
            });
         },
         stop: function( event, ui ) {
            var trs = tableToArray(table_id);
            generateTable(trs);
         }
      });

      // $.each($._data($(popup).closest('.elementor-control')[0], "events"), function(i, event) {
      //    $.each(event, function(j, h) {
      //       if(h.selector == '[contenteditable=\"true\"]') {
      //          handler = h.handler;
      //       }
      //    });
      // });
      // $(popup).closest('.elementor-control').unbind('input', handler); // fix contenteditable update control



   }

   // generate table html
   function generateTable(rows) {
      if(!rows) {
         var control_value = $('#elementor-control-default-'+table_id).val();
         if(IsJsonString(control_value)) {
            rows = JSON.parse(control_value);
         } else {
            rows = [];
         }
      }
      var table_html = '';
      $.each(rows, function(row_index, row) {
         table_html += '<tr>';
         $.each(row, function(col_index, cell) {
            var control_html = '';
            if(row_index == 0) {
               control_html += '<div class="dh-col-control" data-col-index="'+col_index+'"><i class="eicon-plus"></i></div>';
            }
            if(col_index == row.length-1 ) {
               control_html += '<div class="dh-row-control" data-row-index="'+row_index+'"><i class="eicon-plus"></i></div>';
            }
            table_html += '<td><span contenteditable="true">'+cell+'</span>'+control_html+'</td>';
            
         });
         table_html += '</tr>';
      });
      table.html(table_html);
   }

   // is JSON string
   function IsJsonString(str) {
      try {
          JSON.parse(str);
      } catch (e) {
          return false;
      }
      return true;
  }


   // save data
   function saveData() {
      popup.removeClass('active');
      var trs = tableToArray(table_id);
      var json = JSON.stringify(trs);
      var rows = $('#elementor-control-default-'+table_id).val();
      if(rows != json) {
         $('#elementor-control-default-'+table_id).val(json).trigger('change');
         $('#elementor-control-default-'+table_id).trigger('input');
      }
      // remove popup
      $('.dh-control-popup-wrapper').remove();
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
      var rows = $(table).find('tr');
      if(rows.length >= data.max) return false;
      var trs = tableToArray(table_id);
      var new_row = [];
      if (trs[0]) {
         var column_count = trs[0].length;
         for(var i = 0; i < column_count; i++) {
            new_row.push('');
         }
      } else {
         new_row.push('');
      }
      trs.push(new_row);
      generateTable(trs);
   });


   // add column
   $(document).on('click', '.dh-add-column', function() {
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
      console.log('boom');
      var cellIndex = this.cellIndex;
      var rowIndex = this.parentNode.rowIndex;
      $('.dh-col-control[data-col-index="'+cellIndex+'"]').addClass('active');
      $('.dh-row-control[data-row-index="'+rowIndex+'"]').addClass('active');
   });
   $(document).on('mouseleave', 'table td', function() {
      var cellIndex = this.cellIndex;
      var rowIndex = this.parentNode.rowIndex;
      $('.dh-col-control[data-col-index="'+cellIndex+'"]').removeClass('active');
      $('.dh-row-control[data-row-index="'+rowIndex+'"]').removeClass('active');
   });


   // delete column
   $(document).on('click', '.dh-col-control i', function(){
      var table_id = $(popup).find('table').attr('data-table-id');
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
      var row_index = $(this).parent().data('row-index');
      var trs = tableToArray(table_id);
      // if(trs.length == 1) return;
      trs.splice(row_index,1);
      generateTable(trs);
   });









   $( 'body' ).on( 'click', '.dh-edit-template', function() {
      // $( '#elementor-controls' ).find( '.elementor-control-post_id select' ).trigger( 'change' );
      var post_id = $( '#elementor-controls' ).find( '.elementor-control-dh_template_post_id select option:selected' ).val();
      var url = window.location.href;
      var url_arr = url.split("/");
      var host_url = url_arr[0] + "//" + url_arr[2];
      $( 'body' ).append( '<div class="dh-edit-template-popup"><iframe src="' + host_url + '/wp-admin/post.php?post=' + post_id + '&action=elementor&dh-template=true"></iframe><div class="dh-close-template-popup">Close</div></div>')
   } );

   $( 'body' ).on( 'click', '.dh-close-template-popup', function() {
      $( '.dh-edit-template-popup' ).remove();
      $( '#elementor-controls' ).find( '.elementor-control-dh_template_post_id select' ).trigger( 'change' );
   } );














})(jQuery);

