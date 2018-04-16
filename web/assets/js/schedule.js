// Panel toolbox
$(document).ready(function() {


    var table = $('table.schedule-table').dataTable().api();

// Add event listener for opening and closing details
    $('.schedule-table tbody').on('click', 'td.details-control', function () {

        var tr = $(this).closest('tr').next('tr');

        var row = table.row( tr );
        tr.show();
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            $(this).find('i').removeClass('fa-minus-circle').addClass('fa-plus-circle');
            tr.removeClass('shown');

        }
        else {
            // Open this row
            row.child.show();
            $(this).find('i').removeClass('fa-plus-circle').addClass('fa-minus-circle');
            tr.addClass('shown');
        }
    } );
});

