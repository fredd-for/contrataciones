
$(document).ready(function (){
cargar();	
	function cargar(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'razon_social',type: 'string'},
			{ name: 'nit',type: 'string'},
			{ name: 'grupo',type: 'string'},
			{ name: 'linea',type: 'string'},
			{ name: 'estacion',type: 'string'},
			{ name: 'producto',type: 'string'},
			{ name: 'contrato',type: 'string'},
			{ name: 'fecha_programado',type:'date'},
			{ name: 'monto_reprogramado',type: 'number'},
			{ name: 'diferencia_dias',type:'number'}
			],
			url: '/facturas/list/',
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
		var tooltiprenderer = function (element) {
                $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
        };
		$("#jqxgrid").jqxGrid({

			width: '100%',
            source: dataAdapter,                
            sortable: true,
            altRows: true,
            columnsresize: true,
            theme: 'custom',
            showstatusbar: true,
            showfilterrow: true,
            filterable: true,
            autorowheight: true,
            pageable: true,
            pagerMode: 'advanced',
            groupable: true,
			columns: [
			{
				text: '#', sortable: false, filterable: false, editable: false,
				groupable: false, draggable: false, resizable: false,
				datafield: '', columntype: 'number', width: '3%',
				cellsrenderer: function (row, column, value) {
					return "<div style='margin:4px;'>" + (value + 1) + "</div>";
				}
			},
			{ text: 'Grupo', datafield: 'grupo', filtertype: 'checkedlist',width: '8%', rendered: tooltiprenderer },
			{ text: 'Linea', datafield: 'linea', filtertype: 'checkedlist',width: '8%' },
			{ text: 'Estación', datafield: 'estacion', filtertype: 'checkedlist',width: '15%' },
			{ text: 'Cliente / Razón Social', datafield: 'razon_social', filtertype: 'input',width: '20%' },
			{ text: 'Contrato', datafield: 'contrato', filtertype: 'input',width: '10%' },
			{ text: 'Producto', datafield: 'producto', filtertype: 'input',width: '15%' },
			{ text: 'Fecha Programado', datafield: 'fecha_programado', filtertype: 'range', width: '7%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Monto Programado Bs.', datafield: 'monto_reprogramado', filtertype: 'number', width: '7%',cellsformat: "c2", cellsalign: 'right'},
	        { text: 'Dias Atraso', datafield: 'diferencia_dias', filtertype: 'number', width: '7%',cellsalign: 'right'},
			],
			//groups: ['razon_social','contrato']
		});

 		//$("#jqxgrid").jqxGrid('expandgroup',4);
}


cargar2();	
	function cargar2(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'planpagofactura_id',type: 'number'},
			{ name: 'razon_social',type: 'string'},
			{ name: 'nit',type: 'string'},
			{ name: 'grupo',type: 'string'},
			{ name: 'linea',type: 'string'},
			{ name: 'estacion',type: 'string'},
			{ name: 'producto',type: 'string'},
			{ name: 'contrato',type: 'string'},
			{ name: 'fecha_programado',type:'date'},
			{ name: 'monto_reprogramado',type: 'number'},
			{ name: 'fecha_factura',type:'date'},
			{ name: 'fecha_recepcion_cliente',type:'date'},
			{ name: 'monto_factura',type: 'number'},
			{ name: 'nro_factura',type: 'string'},
			{ name: 'diferencia_dias',type:'number'}
			],
			url: '/facturas/listfacturas/',
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
		var tooltiprenderer = function (element) {
                $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
        };
		$("#jqxgrid_facturas").jqxGrid({

			width: '100%',
            source: dataAdapter,                
            sortable: true,
            altRows: true,
            columnsresize: true,
            theme: 'custom',
            showstatusbar: true,
            showfilterrow: true,
            filterable: true,
            autorowheight: true,
            pageable: true,
            pagerMode: 'advanced',
            groupable: true,
			columns: [
			{
				text: '#', sortable: false, filterable: false, editable: false,
				groupable: false, draggable: false, resizable: false,
				datafield: '', columntype: 'number', width: '3%',
				cellsrenderer: function (row, column, value) {
					return "<div style='margin:4px;'>" + (value + 1) + "</div>";
				}
			},
			// { text: 'Grupo', datafield: 'grupo', filtertype: 'checkedlist',width: '8%', rendered: tooltiprenderer },
			{ text: 'Linea', datafield: 'linea', filtertype: 'checkedlist',width: '8%' },
			{ text: 'Estación', datafield: 'estacion', filtertype: 'checkedlist',width: '15%' },
			{ text: 'Cliente / Razón Social', datafield: 'razon_social', filtertype: 'input',width: '16%' },
			{ text: 'Contrato', datafield: 'contrato', filtertype: 'input',width: '10%' },
			{ text: 'Producto', datafield: 'producto', filtertype: 'input',width: '15%' },
			{ text: 'Fecha Programado', datafield: 'fecha_programado', filtertype: 'range', width: '7%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Monto Programado Bs.', datafield: 'monto_reprogramado', filtertype: 'number', width: '7%',cellsformat: "c2", cellsalign: 'right'},
			{ text: 'Nro Factura', datafield: 'nro_factura', filtertype: 'input',width: '5%' },
			{ text: 'Fecha Factura', datafield: 'fecha_factura', filtertype: 'range', width: '7%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Monto Facturado Bs.', datafield: 'monto_factura', filtertype: 'number', width: '7%',cellsformat: "c2", cellsalign: 'right'},
	        // { text: 'Diferencia Dias', datafield: 'diferencia_dias', filtertype: 'number', width: '7%',cellsalign: 'right'},
			],
			//groups: ['razon_social','contrato']
		});

 		//$("#jqxgrid").jqxGrid('expandgroup',4);
}

/*
Facturar
 */
$("#facturar").click(function() {
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
	if (rowindex > -1)
	{
		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
		$("#planpago_id").val(dataRecord.id);
		$("#titulo").text("Facturar");

		$("#linea").text(dataRecord.linea);
		$("#estacion").text(dataRecord.estacion);
		$("#razon_social").text(dataRecord.razon_social);
		$("#contrato").text(dataRecord.contrato);
		$("#producto").text(dataRecord.producto);
		var fp = $.jqx.dataFormat.formatdate(dataRecord.fecha_programado, 'dd-MM-yyyy');
		$("#fecha_programado").text(fp);
		$("#monto_reprogramado").text(dataRecord.monto_reprogramado);

		$("#nro_factura").val('');
		$("#fecha_factura").val(fp);
		$("#monto_factura").val(dataRecord.monto_reprogramado);
		
		$('#myModal').modal('show');
	}
	else
	{
		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para Facturar.");
	}

});

/*
Facturar
 */
$("#edit").click(function() {
	var rowindex = $('#jqxgrid_facturas').jqxGrid('getselectedrowindex');
	if (rowindex > -1)
	{
		var dataRecord = $("#jqxgrid_facturas").jqxGrid('getrowdata', rowindex);
		$("#id").val(dataRecord.planpagofactura_id);
		$("#titulo").text("Editar Facturación");

		$("#linea").text(dataRecord.linea);
		$("#estacion").text(dataRecord.estacion);
		$("#razon_social").text(dataRecord.razon_social);
		$("#contrato").text(dataRecord.contrato);
		$("#producto").text(dataRecord.producto);
		var fp = $.jqx.dataFormat.formatdate(dataRecord.fecha_programado, 'dd-MM-yyyy');
		$("#fecha_programado").text(fp);
		$("#monto_reprogramado").text(dataRecord.monto_reprogramado);
		$("#nro_factura").val(dataRecord.nro_factura);
		var ff = $.jqx.dataFormat.formatdate(dataRecord.fecha_factura, 'dd-MM-yyyy');
		$("#fecha_factura").val(ff);
		var frc = $.jqx.dataFormat.formatdate(dataRecord.fecha_recepcion_cliente, 'dd-MM-yyyy');
		$("#fecha_recepcion_cliente").val(frc);
		$("#monto_factura").val(dataRecord.monto_factura);
		
		$('#myModal').modal('show');
	}
	else
	{
		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para Facturar.");
	}

});


/*
Eliminar
*/
$("#delete").click(function() {
	var rowindex = $('#jqxgrid_facturas').jqxGrid('getselectedrowindex');
	if (rowindex > -1)
	{
		var dataRecord = $("#jqxgrid_facturas").jqxGrid('getrowdata', rowindex);
 		bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar la factura.", function(result) {
 			if (result == true) {
 				var v = $.ajax({
 					url: '/facturas/delete/',
 					type: 'POST',
 					datatype: 'json',
 					data: {id: dataRecord.planpagofactura_id},
 					success: function(data) {
                            cargar(); cargar2();
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

$("#testForm").submit(function() {
	var v=$.ajax({
		url:'/facturas/save/',
		type:'POST',
		datatype: 'json',
		data:{id:$("#id").val(),planpago_id:$("#planpago_id").val(),nro_factura:$("#nro_factura").val(),fecha_factura:$("#fecha_factura").val(),fecha_recepcion_cliente:$("#fecha_recepcion_cliente").val(),monto_factura:$("#monto_factura").val()},
		success: function(data) { cargar(); cargar2(); 
			$("#divMsjeExito").show();
			$("#divMsjeExito").addClass('alert alert-success alert-dismissable');
			$("#aMsjeExito").html(data); 
				}, //mostramos el error
				error: function() { alert('Se ha producido un error Inesperado'); }
			});
	$('#myModal').modal('hide');
            return false; // ajax used, block the normal submit
});

$("#fecha_factura, #fecha_recepcion_cliente").datepicker({
	autoclose:true,
});

})