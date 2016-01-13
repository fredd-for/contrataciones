$(document).ready(function (){
	cargar();	
	function cargar(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'parametro',type: 'string'},
			{ name: 'abreviado',type: 'string'},
			{ name: 'tipo_empresa',type: 'number'},
			{ name: 'tipo_empresa_text',type: 'string'},
			{ name: 'obligatorio',type: 'number'},
			{ name: 'obligatorio_text',type: 'string'},
			{ name: 'escaner',type: 'number'},
			{ name: 'escaner_text',type: 'string'},
			{ name: 'clase',type: 'string'},
			],
			url: '/parametroschecklists/list',
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
			//showstatusbar: true,
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
			{ text: 'Tipo Empresa', datafield: 'tipo_empresa_text', filtertype: 'input',width: '30%' },
			{ text: 'Parametro', datafield: 'parametro', filtertype: 'input',width: '30%' },
			{ text: 'Campo Obligatorio', datafield: 'obligatorio_text', filtertype: 'input',width: '18%' },
			{ text: 'Escanear', datafield: 'escaner_text', filtertype: 'input',width: '19%' },
			]
		});
}

/*
adicionar 
*/
$("#add").click(function(){
	$("#titulo").text("Adicionar Parametro Check List");
	$("#id").val("");
	$("#tipo_empresa").val("");
	$("#parametro").val("");
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
 		$("#titulo").text("Editar Parametro Check List");
 		$("#tipo_empresa").val(dataRecord.tipo_empresa);
 		$("#parametro").val(dataRecord.parametro);
 		$("#obligatorio").val(dataRecord.obligatorio);
 		$("#escaner").val(dataRecord.escaner);
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
                        url: '/parametroschecklists/delete/',
                        type: 'POST',
                        datatype: 'json',
                        data: {id: dataRecord.id},
                        success: function(data) {
                            cargar(); //alert('Guardado Correctamente'); 
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
            	url:'/parametroschecklists/save/',
            	type:'POST',
            	datatype: 'json',
            	data:{id:$("#id").val(),tipo_empresa:$("#tipo_empresa").val(),parametro:$("#parametro").val(),obligatorio:$("#obligatorio").val(),escaner:$("#escaner").val()},
				success: function(data) { cargar(); 
					$("#divMsjeExito").show();
                    $("#divMsjeExito").addClass('alert alert-info alert-dismissable');
                    $("#aMsjeExito").html(data); 
				}, //mostramos el error
			error: function() { alert('Se ha producido un error Inesperado'); }
			});
            $('#myModal').modal('hide');
            return false; // ajax used, block the normal submit
});

})