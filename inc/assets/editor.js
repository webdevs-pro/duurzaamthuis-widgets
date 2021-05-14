(function($) {


   $(document).on('click', '.dh-table-popup-open', function() {

      var popup = $(this).closest('.elementor-control-input-wrapper').find('.dh-table-popup-wrapper');
      var table = popup.find('table');
      var table_id = table.attr('data-table-id');
      var rows = JSON.parse($('#elementor-control-default-'+table_id).val());
      
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
         placeholder: "sortable-placeholder"
      });



   });







   $(document).on('click', '.dh-table-popup-close', function() {

      var popup = $(this).closest('.dh-table-popup-wrapper');
      var table_id = popup.find('table').attr('data-table-id');

      popup.removeClass('active');
      var trs = $('table.dh-table-'+table_id+' tr').get().map(function(row) {
         return $(row).find('td > span').get().map(function(cell) {
            return $(cell).html();
         });
      });

      var json = JSON.stringify(trs);
      var rows = $('#elementor-control-default-'+table_id).val();
      console.log(json);
      console.log(rows);

      if(rows != json) {
         $('#elementor-control-default-'+table_id).val(json).trigger('change');
         $('#elementor-control-default-'+table_id).trigger('input');
      }

   });



   


})(jQuery);
