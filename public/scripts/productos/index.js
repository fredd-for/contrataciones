$(document).ready(function (){
	// cargar();	
	// function cargar(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'grupo_id',type: 'number'},
			{ name: 'grupo',type: 'string'},
			{ name: 'estacion_id',type: 'number'},
			{ name: 'estacion',type: 'string'},
			{ name: 'linea_id',type: 'number'},
			{ name: 'linea',type: 'string'},
			{ name: 'producto',type:'string'},
			{ name: 'codigo',type:'string'},
			{ name: 'descripcion',type:'string'},
			{ name: 'precio_unitario',type:'number'},
			{ name: 'cantidad',type:'number'},
			{ name: 'cantidad_alquilada',type:'number'},
			{ name: 'cantidad_disponible',type:'number'},
			{ name: 'tiempo',type:'string'},
			{ name: 'foto'},
			],
			url: '/productos/list',
			cache: true
		};
		// var dataAdapter = new $.jqx.dataAdapter(source);

		
		var cellclass = function (row, columnfield, value) {
			if (value < 0) {
				return 'red';
			}
			else if (value >0) {
				return 'green';
			}
			else return 'yellow';
		}

		var dataAdapter = new $.jqx.dataAdapter(source, {
                // downloadComplete: function (data, status, xhr) { },
                loadComplete: function (data) { 
                	if ($("#opcion").val()==0) {
                		$("#jqxgrid").jqxGrid('sortby', 'cantidad_disponible', 'desc');	
                	}
                	if ($("#opcion").val()==1) {
                		$("#jqxgrid").jqxGrid('sortby', 'cantidad_alquilada', 'desc');	
                	}

                	
            	},
                // loadError: function (xhr, status, error) { }
            });

		$("#jqxgrid").jqxGrid({
			width: '100%',
			height: 600,
			source: dataAdapter,
			sortable: true,
			altrows: true,
			columnsresize: true,
			pageable: true,
			pagerMode: 'advanced',
			theme: 'custom',
			scrollmode: 'deferred',
			showstatusbar: true,
			statusbarheight: 25,
			showfilterrow: true,
			filterable: true,
			autorowheight: true,
			// autoheight: true,
			// keyboardnavigation: false,
			rowsheight: 80,


			scrollfeedback: function (row)
			{
				return '<table style="height: 80px;"><tr><td><img src="' + row.foto + '"  height="90"/></td></tr><tr><td>' + row.producto + '</td></tr></table>';
			},
			columns: [
			{text: 'Image', datafield: 'foto', width: 100, cellsrenderer: function (row, column, value) {
				return '<img style="margin-left: 5px;" height="80" width="100%" src="' + value + '" />';
			}
			},
					// { text: 'ID', datafield: 'id', filtertype: 'input',width: '5%' },
					{ text: 'linea', datafield: 'linea', filtertype: 'input',width: '8%' },
					{ text: 'Estación', datafield: 'estacion', filtertype: 'input',width: '10%' },
					{ text: 'Grupo', datafield: 'grupo', filtertype: 'input',width: '10%'},
					{ text: 'Producto', datafield: 'producto', filtertype: 'input',width: '15%' },
					{ text: 'Codigo', datafield: 'codigo', filtertype: 'input',width: '5%' },
					{ text: 'Descripción', datafield: 'descripcion', filtertype: 'input',width: '19%' },
					{ text: 'Precio Unitario', datafield: 'precio_unitario', filtertype: 'number', width: '7%',cellsformat: "c2", cellsalign: 'right'},
					{ text: 'Cant. Total', datafield: 'cantidad',filtertype: 'number', width: '5%'},
					{ text: 'Cant. Alquilada', datafield: 'cantidad_alquilada',filtertype: 'number', width: '5%'},
					{ text: 'Cant. Disponible', datafield: 'cantidad_disponible',filtertype: 'number', width: '5%',cellclassname: cellclass},
					{ text: 'Tiempo', datafield: 'tiempo',filtertype: 'input', width: '5%'},
					]
				});

$("#jqxgrid").bind("bindingcomplete", function(event) {
	var visibleRows = $('#jqxgrid').jqxGrid('getrows');
	var count = visibleRows.length;
	var total_venta = 0;
	var total = 0;
	$.each(visibleRows, function(i, e) {
		total += e.suma;

	});
	$('#statusbarjqxgrid').html('Total: <b>' + count + '</b>');
});

if ($("#opcion").val()>0) {
	ordenar('cantidad_disponible','desc');
}
function ordenar (campo,orden) {
	$("#jqxgrid").jqxGrid('sortby', campo, orden);	
}


// }


 
/*
adicionar 
*/
$("#add").click(function(){
	$("#titulo").text("Adicionar Producto");
	$("#id").val("");
	$('#myModal').modal('show');
});

/*
Galeria de Imagenes
*/
$("#galeria").click(function() {
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
	if (rowindex > -1)
	{
		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
		$("#id").val(dataRecord.id);
		$(location).attr('href','/productos/galeria/'+dataRecord.id);
	}
	else
	{
		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
	}

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
		$("#titulo").text("Editar Producto");

		$("#grupo_id").val(dataRecord.grupo_id);
		$("#linea_id").val(dataRecord.linea_id);
		$("#producto").val(dataRecord.producto);
		$("#codigo").val(dataRecord.codigo);
		$("#descripcion").val(dataRecord.descripcion);
		$("#precio_unitario").val(dataRecord.precio_unitario);
		$("#cantidad").val(dataRecord.cantidad);
		$("#tiempo").val(dataRecord.tiempo);
		select_estacion(dataRecord.linea_id,dataRecord.estacion_id);
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
 		//$("#id").val(dataRecord.id);
 		bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el registro.", function(result) {
 			if (result == true) {
 				var v = $.ajax({
 					url: '/productos/delete/',
 					type: 'POST',
 					datatype: 'json',
 					data: {id: dataRecord.id},
 					success: function(data) {
                            // cargar(); //alert('Guardado Correctamente'); 
                            $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
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
Select dependiente
*/

$("#linea_id").change(function(){
	select_estacion($(this).val());
});

$("#tiempo").change(function(){
	$("#tiempo_text").text('('+$(this).val()+')');
});

function select_estacion(linea_id,estacion_id){
	$.post("/productos/select_estaciones/", { linea_id: linea_id }, function(data){
		$("#estacion_id").html(data);
		$("#estacion_id").val(estacion_id);
	}); 
}


$("#testForm").submit(function() {
	var v=$.ajax({
		url:'/productos/save/',
		type:'POST',
		datatype: 'json',
		data:{id:$("#id").val(),grupo_id:$("#grupo_id").val(),estacion_id:$("#estacion_id").val(),producto:$("#producto").val(),codigo:$("#codigo").val(),descripcion:$("#descripcion").val(),precio_unitario:$("#precio_unitario").val(),cantidad:$("#cantidad").val(),tiempo:$("#tiempo").val(),estacion_id:$("#estacion_id").val()},
		success: function(data) { 
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells'); //cargar(); 
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