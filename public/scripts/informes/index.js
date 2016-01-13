$(document).ready(function (){
	cargar();	
	function cargar(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'razon_social',type: 'string'},
			{ name: 'nro_solicitud',type: 'string'},
			{ name: 'solicitud_id',type: 'number'},
			{ name: 'nur',type: 'string'},
			{ name: 'accion',type: 'string'},
			],
			url: '/informes/list',
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);

		$("#jqxgrid").jqxGrid({

			width: '100%',
			source: dataAdapter,
			sortable: true,
			altRows: true,
			columnsresize: true,
			pageable: true,
			pagerMode: 'advanced',
			theme: 'custom',
			//scrollmode: 'deferred',
			// showstatusbar: true,
			showfilterrow: true,
			filterable: true,
			autorowheight: true,
			keyboardnavigation: false,
			columns: [
			{
				text: '#', sortable: false, filterable: false, editable: false,
				groupable: false, draggable: false, resizable: false,
				datafield: '', columntype: 'number', width: '3%',
				cellsrenderer: function (row, column, value) {
					return "<div style='margin:4px;'>" + (value + 1) + "</div>";
				}
			},
			{ text: 'Cliente / Razón Social', datafield: 'razon_social', filtertype: 'input',width: '30%' },
			{ text: 'Solicitud', datafield: 'nro_solicitud', filtertype: 'input',width: '30%' },
			{ text: 'Hoja de Ruta', datafield: 'nur', filtertype: 'input',width: '20%' },
			{ text: 'Acción', datafield: 'accion', filtertype: 'input',width: '17%' },
			]
		});
}

selectSolicitudes();
/*
adicionar 
*/
$("#add").click(function(){
	$("#titulo").text("Adicionar Hoja de Ruta (Sistema de Gestión de Correspondencia)");
	$("#id").val("");
	$("#cite").val("");
	$("#nur").val("");
	$('#myModal').modal('show');
});

/*
Editar
 */
$("#edit").click(function() {
 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		$("#id").val(dataRecord.id);
 		$("#titulo").text("Editar Hoja de Ruta (Sistema de Gestión de Correspondencia)");
 		$("#nur").val(dataRecord.nur);
 		$('#myModal').modal('show');
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
 	}

 });

/*
Eliminar
 */
$("#delete").click(function() {
 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el registro.", function(result) {
                if (result == true) {
                    var v = $.ajax({
                        url: '/informes/delete/',
                        type: 'POST',
                        datatype: 'json',
                        data: {id: dataRecord.id},
                        success: function(data) {
                            cargar(); //alert('Guardado Correctamente'); 
                            selectSolicitudes();
                            $("#divMsjeExito").show();
                    		$("#divMsjeExito").addClass('alert alert-warning alert-dismissable');
                    		$("#aMsjeExito").html(data); 
                        }, //mostramos el error
                        error: function() {
                            alert('Se ha producido un error Inesperado');
                        }
                    });
                }
            });
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para eliminar.");
 	}

 });

/*
guardar 
 */
$("#testForm").submit(function() {
	var v=$.ajax({
            	url:'/informes/save/',
            	type:'POST',
            	datatype: 'json',
            	data:{id:$("#id").val(),solicitud_id:$("#solicitud_id").val(),nur:$("#nur").val()},
				success: function(data) { cargar(); 
					selectSolicitudes();
					$("#divMsjeExito").show();
                    $("#divMsjeExito").addClass('alert alert-info alert-dismissable');
                    $("#aMsjeExito").html(data); 
				}, //mostramos el error
			error: function() { alert('Se ha producido un error Inesperado'); }
			});
            $('#myModal').modal('hide');
            return false; // ajax used, block the normal submit
});

function selectSolicitudes() {
	var v=$.ajax({
            	url:'/informes/selectsolicitudes/',
            	type:'POST',
            	datatype: 'json',
            	// data:{id:$("#id").val()},
				success: function(data) {

                    $("#selectsolicitudes").html(data); 
				}, //mostramos el error
			error: function() { alert('Se ha producido un error Inesperado'); }
			});	
}


/*
auto complete
 */    
    $.fn.delayPasteKeyUp = function(fn, ms)
    {
        var timer = 0;
        $(this).on("keyup paste", function()
        {
            clearTimeout(timer);
            timer = setTimeout(fn, ms);
        });
    };
 
    $("input[name=nur]").delayPasteKeyUp(function()
    {
        $.ajax({
        	type: "POST",
            // url: "http://localhost/autocompletado/app/instancias/autocomplete.php",
            url: "/solicitudes/documentos",
            data: "autocomplete="+$("input[name=nur]").val(),
            success: function(data)
            {
            	$("#busqueda").html(data);
            }
        });
    }, 500);




})

var info = function (id, nur) {
	$("#nur").val(nur);
	$('.list-group').hide();
	// alert("ID: " + id + " Nombre: " + nur);	
};

// var seguimiento = function (row) {
// 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
// 	if (rowindex > -1) {
// 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
// 		// $("#id").val(dataRecord.id);
// 		window.location.href = '/informes/seguimiento/'+dataRecord.nur;
// 	}else{
// 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
// 	}
// };