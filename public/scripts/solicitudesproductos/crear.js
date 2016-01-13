$(document).ready(function (){
	cargar();	
	function cargar(){	
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
			{ name: 'cant_solicitud',type:'number'},
			{ name: 'tiempo',type:'string'},
			{ name: 'foto'},
			],
			url: '/productos/list',
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);

		var toThemeProperty = function(className) {
			return className + " " + className + "-" + theme;
		}
		var groupsrenderer = function(text, group, expanded, data) {
			if (data.subItems.length > 0) {
				var aggregate = this.getcolumnaggregateddata('id', ['sum'], true, data.subItems);
				var total = this.getcolumnaggregateddata('suma', ['sum'], true, data.subItems);
			}
			else {
				var rows = new Array();
				var getRows = function(group, rows) {
					if (group.subGroups.length > 0) {
						for (var i = 0; i < group.subGroups.length; i++) {
							getRows(group.subGroups[i], rows);
						}
					}
					else {
						for (var i = 0; i < group.subItems.length; i++) {
							rows.push(group.subItems[i]);
						}
					}
				}
				getRows(data, rows);
				var aggregate = this.getcolumnaggregateddata('id', ['sum'], true, rows);
				var total = this.getcolumnaggregateddata('suma', ['sum'], true, rows);
			}
			return '<div class="' + toThemeProperty('jqx-grid-groups-row') + '" style="position: absolute "><span style="margin: 5px 0 0 0;">' + text + ' (' + total.sum + ') , </span>' + '<span class="' + toThemeProperty('jqx-grid-groups-row-details') + '">' + "Cantidad Valores:<b>" + 1 + "</b>, Monto Bs: " + '<b>' + 1 + '</b>' + '</span></div>';
		}
		var barra = function(statusbar) {
		};
		var cellclass = function (row, columnfield, value) {
			if (value > '0') {
				return 'green';
			}else{
				return 'red';
			}
		}

		$("#jqxgrid").jqxGrid({

			width: '100%',
			source: dataAdapter,
			sortable: true,
			altRows: true,
			showstatusbar: true,
			statusbarheight: 25,
			pagerMode: 'advanced',
			theme: 'custom',
			showfilterrow: true,
			filterable: true,
			scrollmode: 'deferred',
			renderstatusbar: barra,
			scrollfeedback: function (row)
			{
				return '<table style="height: 150px;"><tr><td><img src="' + row.foto + '"  height="90"/></td></tr><tr><td>' + row.producto + '</td></tr></table>';
			},
			rowsheight: 90,
			columns: [
			{text: 'Image', datafield: 'foto', width: 100, cellsrenderer: function (row, column, value) {
                            return '<img src="' + value + '" height="90"/>';
                        }
            },
			{ text: 'linea', datafield: 'linea', filtertype: 'checkedlist',width: '9%' },
			{ text: 'Estación', datafield: 'estacion', filtertype: 'checkedlist',width: '10%' },
			{ text: 'Grupo', datafield: 'grupo', filtertype: 'checkedlist',width: '10%' },
			{ text: 'Codigo', datafield: 'codigo', filtertype: 'input',width: '5%' },
			{ text: 'Producto', datafield: 'producto', filtertype: 'input',width: '20%' },
			{ text: 'Descripción', datafield: 'descripcion', filtertype: 'input',width: '20%' },
			{ text: 'Precio Unitario', datafield: 'precio_unitario', filtertype: 'input',width: '5%' },
			{ text: 'Cantidad', datafield: 'cantidad',filtertype: 'input', width: '5%', cellclassname: cellclass },
			{ text: 'Tiempo', datafield: 'tiempo',filtertype: 'input', width: '5%' },
			{ text: 'Cant. Solicitada', datafield: 'cant_solicitud',filtertype: 'input', width: '5%', cellsalign: 'center'},
			]
		});

		$("#jqxgrid").bind("filter", function(event) {
        var visibleRows = $('#jqxgrid').jqxGrid('getrows');
        var count = visibleRows.length;        
        $('#statusbarjqxgrid').html('Total: <b>' + count + '</b>');
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
        $('#fecha').addClass('animated');
        $('#fecha').addClass('fadeIn');
    });

}

/*
Segundo Grid
 */

cargar2();	
	function cargar2(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'linea',type: 'string'},
			{ name: 'estacion',type: 'string'},
			{ name: 'grupo',type: 'string'},
			{ name: 'codigo',type: 'string'},
			{ name: 'producto',type: 'string'},
			{ name: 'producto_id',type: 'number'},
			{ name: 'precio_tiempo',type: 'string'},
			{ name: 'precio_unitario',type:'number'},
			{ name: 'tiempo',type:'string'},
			{ name: 'cantidad',type:'number'},
			],
			url: '/solicitudesproductos/list/'+$("#solicitud_id").val(),
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);

		$("#jqxgrid_sp").jqxGrid({

			width: '100%',
			height:'200px',
            source: dataAdapter,                
            sortable: true,
            altrows: true,
            columnsresize: true,
            theme: 'custom',
            showstatusbar: true,
            showfilterrow: true,
            filterable: true,
            // autorowheight: true,
            // pageable: true,
            pagerMode: 'advanced',
            
            statusbarheight: 25,
            showaggregates: true,

			columns: [
			{
				text: '#', sortable: false, filterable: false, editable: false,
				groupable: false, draggable: false, resizable: false,
				datafield: '', columntype: 'number', width: '3%',
				cellsrenderer: function (row, column, value) {
					return "<div style='margin:4px;'>" + (value + 1) + "</div>";
				}
			},
			{ text: 'Grupo', datafield: 'grupo', filtertype: 'checkedlist',width: '10%' },
			{ text: 'Linea', datafield: 'linea', filtertype: 'checkedlist',width: '10%' },
			{ text: 'Estación', datafield: 'estacion', filtertype: 'checkedlist',width: '22%' },
			{ text: 'Codigo', datafield: 'codigo', filtertype: 'input',width: '5%' },
			{ text: 'Producto', datafield: 'producto', filtertype: 'input',width: '25%' },
			{ text: 'Precio Bs. / Tiempo', datafield: 'precio_tiempo', filtertype: 'input',width: '15%' },
			{ text: 'Cantidad', datafield: 'cantidad', filtertype: 'number',width: '10%' },
			]
		});
}

/*
Añadir a Contrato
 */

$("#add_solicitud").click(function() {
 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		// alert(dataRecord.id);
 		var v = $.ajax({
 			url: '/solicitudesproductos/clientesolicitud/',
 			type: 'POST',
 			datatype: 'json',
 			data: {producto_id: dataRecord.id},
 			success: function(data) {
 						$("#table_solicitudes").html(data); 
                        }, //mostramos el error
                        error: function() {
                        	alert('Se ha producido un error Inesperado');
                        }
        });
 		// if (dataRecord.cantidad>0) {
 			$("#producto_id").val(dataRecord.id);
 			$("#titulo").text("Añadir Producto a la Solicitud");
 			// $("#imagen_producto").text(dataRecord.foto);
 			$("#imagen").text("");
 			$("#imagen").append("<img id='theImg' height='100' src='"+dataRecord.foto+"'/>");
 			$("#estacion").val(dataRecord.estacion);
 			$("#grupo").val(dataRecord.grupo);
 			$("#producto").val(dataRecord.codigo+" "+dataRecord.producto);
 			$("#cantidad").val(1);
 			$("#tiempo").val(dataRecord.tiempo);
 			$("#precio_unitario").val(dataRecord.precio_unitario);
 			$("#tiempo_text").text('('+dataRecord.tiempo+')');
 			$('#myModal').modal('show');
 		// }else{
 		// 	bootbox.alert("<strong>¡Mensaje!</strong> El producto ya fue alquilado.");		
 		// }
 		
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un producto para agregar.");
 	}

 });

// $("#edit_cp").click(function(){
// 	var rowindex = $('#jqxgrid_cp').jqxGrid('getselectedrowindex');
//  	if (rowindex > -1)
//  	{
//  		var dataRecord = $("#jqxgrid_cp").jqxGrid('getrowdata', rowindex);
//  			$("#cp_id").val(dataRecord.id);
//  			$("#titulo_pp").text("Editar Producto del Contrato");
//  			// alert(dataRecord.tiempo);
//  			$("#estacion").val(dataRecord.estacion);
//  			$("#grupo").val(dataRecord.grupo);
//  			$("#producto").val(dataRecord.producto);
//  			$("#cantidad").val(dataRecord.cantidad);
//  			$("#tiempo").val(dataRecord.tiempo);
//  			$("#precio_unitario").val(dataRecord.precio_unitario);
//  			$("#tiempo_text").text('('+dataRecord.tiempo+')');
//  			$("#total").val(dataRecord.total);
//  			var fe = $.jqx.dataFormat.formatdate(dataRecord.fecha_inicio, 'dd-MM-yyyy');
//             var fa = $.jqx.dataFormat.formatdate(dataRecord.fecha_fin, 'dd-MM-yyyy');
//             $("#fecha_inicio").val(fe);
//             $("#fecha_fin").val(fa);

//             var fe = $.jqx.dataFormat.formatdate(dataRecord.fecha_inicio, 'HH:mm');
//             var fa = $.jqx.dataFormat.formatdate(dataRecord.fecha_fin, 'HH:mm');
//             $("#hora_inicio").val(fe);
//             $("#hora_fin").val(fa);

//  			$('#myModal').modal('show');
 		
//  	}
//  	else
//  	{
//  		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un producto para agregar.");
//  	}
// });

// $("#cantidad").blur(function(){
// 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
// 	var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
// 	if ($(this).val()>dataRecord.cantidad){
// 		bootbox.alert("<strong>¡Mensaje!</strong> "+dataRecord.producto+ " disponibles solo "+dataRecord.cantidad);
// 		$("#cantidad").val('').focus();
// 	}
// });

/*
Eliminar Contratos productos
 */
$("#quitar").click(function() {
 	var rowindex = $('#jqxgrid_sp').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid_sp").jqxGrid('getrowdata', rowindex);
 		bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de quitar el producto.", function(result) {
                if (result == true) {
                    var v = $.ajax({
                        url: '/solicitudesproductos/quitar/',
                        type: 'POST',
                        datatype: 'json',
                        data: {id: dataRecord.id},
                        success: function(data) {
                            cargar2();
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
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un producto para quitar.");
 	}
});


$("#testForm").submit(function(){
	var v=$.ajax({
		url:'/solicitudesproductos/save/',
		type:'POST',
		datatype: 'json',
		data:{id:$("#id").val(),solicitud_id:$("#solicitud_id").val(),producto_id:$("#producto_id").val(),precio_unitario:$("#precio_unitario").val(),tiempo:$("#tiempo").val(),cantidad:$("#cantidad").val()},
		success: function(data) { 
			cargar2(); 
			cargar();
			$("#divMsjeExito").show();
			$("#divMsjeExito").addClass('alert alert-info alert-dismissable');
			$("#aMsjeExito").html(data); 
		},
		error: function() { alert('Se ha producido un error Inesperado'); }
	});
	$('#myModal').modal('hide');
	return false;
});



	// $("#fecha_inicio, #fecha_fin, #fecha_programado").datepicker({
	// 					autoclose:true,
	// });

})