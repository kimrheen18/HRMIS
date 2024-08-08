$(document).ready(function() {
    $('#table-ob,#table-leave').dataTable( {
        "initComplete": function(settings, json) {
            $('.loading-image').hide();
            $('#request_view').show();
        }} );

    /* ellipsis*/
    $('#table-ob').on('click', 'a.showmore', function() {
        $(this).closest('td').find('.fulltext,a.showless').show();
        $(this).prev().prev('.ellipsis').hide();
        $(this).hide();
    });
    $('#table-ob').on('click', 'a.showless', function() {
        $(this).closest('td').find('.ellipsis,a.showmore').show();
        $(this).closest('td').find('.fulltext').hide();
        $(this).hide();
    });
        
});