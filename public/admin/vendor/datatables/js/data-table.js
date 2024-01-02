jQuery(document).ready(function($) {
    'use strict';

    if ($("table.category").length) {

        $(document).ready(function() {
            var table = $('table.category').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf'],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json',
                }
               
              
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        });
    }


   

});