// Call the dataTables jQuery plugin
$(document).ready(function () {
	$('.dataTable').DataTable({
		scrollX:        true,
		"fixedColumns": {
         leftColumns: 1
    },
    "paging": false,
		"bDeferRender": true,
   	"bLengthChange": false,
		"order": [],
		"bSort" : false,
    "bInfo": false,
		"oLanguage": {
			"sZeroRecords": "No hay registros con ese filtro.",
			"sEmptyTable": "No hay registros disponibles",
			"sInfo": "Hay _TOTAL_ registros. Mostrando de (_START_ a _END_)",
			"sLoadingRecords": "Por favor espera - Cargando...",
			"sSearch": "Buscar:",
			"sLengthMenu": "Mostrar _MENU_",
			"oPaginate": {
				"sLast": "Última página",
				"sFirst": "Primera",
				"sNext": "Siguiente",
				"sPrevious": "Anterior"
			}
		}
	});
});

