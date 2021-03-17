$( document ).ready(function() {
    $('#codpatrimonio').tokenfield({
        autocomplete: {
          source: function (request, response) {
              jQuery.get("ajax/spat.php", {
                  query: request.term
              }, function (data) {
                  data = $.parseJSON(JSON.stringify(data));
                  console.log(data);
                  response(data);
              });
          },
          delay: 100
        },
        showAutocompleteOnFocus: true
      });

    });

    

    /* ------------------------------------------------------------------------------
*
*  # Basic datatables
*
*  Specific JS code additions for datatable_basic.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{
            orderable: false,
            width: '100px',
            targets: [ 2 ]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filtrar:</span> _INPUT_',
            lengthMenu: '<span>Mostrar:</span> _MENU_',
            paginate: { 'first': 'Primeira', 'last': 'Ãšltima', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });


    // Basic datatable
    $('.datatable-basic').DataTable();


    // Alternative pagination
    $('.datatable-pagination').DataTable({
        pagingType: "simple",
        language: {
            paginate: {'next': 'PrÃ³xima &rarr;', 'previous': '&larr; Anterior'}
        }
    });


    // Datatable with saving state
    $('.datatable-save-state').DataTable({
        stateSave: true
    });


    // Scrollable datatable
    $('.datatable-scroll-y').DataTable({
        autoWidth: true,
        scrollY: 300
    });



    // External table additions
    // ------------------------------

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');

});
$(document).ready(function(){
    $('.tokenfield').tokenfield();

    $('#buscaequip').on('change keyup', function(){

        var codigoequip = $("#buscaequip").val();
        var dataString = 'codigoequip='+codigoequip;

        console.log(codigoequip);

        if($.trim(codigoequip).length>0)
        {
            setTimeout(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax/searchequip.php",
                    data: dataString,
                    cache: false,
                    beforeSend: function(){ $("#resposta").html('<i class="icon-spinner2 spinner"></i>');},
                    success: function(data){
                        if(data){
                            $("#resposta").html(data);
                        }   
                    }
                });
            }, 1500);

        }
        return false;
        });

        });
   