$(document).ready(function (){
	cargar();	
	function cargar(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'fecha_programado',type: 'date'},
			{ name: 'monto_programado',type: 'number'},
			{ name: 'monto_reprogramado',type: 'number'},
			{ name: 'monto_reprogramado_div',type: 'string'},
			{ name: 'dias_atraso',type: 'number'},
			{ name: 'mora',type: 'number'},
			{ name: 'diferencia',type: 'number'},
			{ name: 'factura_total',type: 'number'},
			{ name: 'deposito_total',type: 'number'},
			{ name: 'mora_total',type: 'number'},
			{ name: 'nro_deposito',type: 'string'},
			{ name: 'fecha_deposito',type: 'string'},
			{ name: 'monto_deposito',type: 'string'},
			{ name: 'nro_deposito_mora',type: 'string'},
			{ name: 'fecha_deposito_mora',type: 'string'},
			{ name: 'monto_deposito_mora',type: 'string'},
			{ name: 'nro_factura',type: 'string'},
			{ name: 'fecha_factura',type: 'string'},
			{ name: 'fecha_recepcion_cliente',type: 'string'},
			{ name: 'monto_factura',type: 'string'},
			{ name: 'fecha_actual',type: 'date'},
			{ name: 'fecha_10',type: 'date'},
			{ name: 'fecha_tolerancia',type: 'date'},
			],
			url: '/planpagos/listcontrolpago/'+$("#contratoproducto_id").val(),
			cache: false,
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
		var cellclass = function (row, columnfield, value,data) {
			if(data.fecha_actual>=data.fecha_programado && data.factura_total<data.monto_reprogramado){
				return 'red';
			}else if(data.fecha_10>=data.fecha_programado && data.factura_total<data.monto_reprogramado){
				return 'yellow';
			}else if (data.factura_total>=data.monto_reprogramado){
				return 'green';
			}else{
				return '';
			}
        };

        var cellclassdeposito = function (row, columnfield, value,data) {
			if(data.fecha_actual>=data.fecha_programado && data.deposito_total<data.monto_reprogramado){
				return 'red';
			}else if(data.fecha_10>=data.fecha_programado && data.deposito_total<data.monto_reprogramado){
				return 'yellow';
			}else if (data.deposito_total>=data.monto_reprogramado){
				return 'green';
			}else{
				return '';
			}
			
        };

        var cellclassmora = function (row, columnfield, value,data) {
			if(data.fecha_tolerancia<data.fecha_actual){
				if (data.mora>0) {
					if (data.mora>data.monto_deposito_mora) {
						return 'red';
					}else{
						return 'green';
					}
				}else{
					if(data.deposito_total<data.monto_reprogramado){
						return 'red';
					}else{
						return 'green';
					}
				}
			}else{
				return '';
			}	
        };
        var barra = function(statusbar) {
		};

		$("#jqxgrid").jqxGrid({
            width: '100%',
            source: dataAdapter,
            pageable: false,
            autorowheight: true,
            autoheight: true,
            altrows: true,
            theme: 'custom',
            columnsresize: true,
            showstatusbar: true,
            statusbarheight: 25,
            showaggregates: true,
            renderstatusbar: barra,
            ready: function () {
                    // callback function which is called by jqxGrid when the widget is initialized and the binding is completed.
            },
			columns: [
			{ text: 'Fecha Programado', datafield: 'fecha_programado', filtertype: 'range', width: '10%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Monto Programado', datafield: 'monto_reprogramado_div', filtertype: 'input',width: '12%' ,cellsformat: 'c2',cellsalign: 'right',align:'center',aggregates: [{ '<b>Total Bs.</b>': 
                            function (aggregatedValue, currentValue, column, record) {
                                var total = aggregatedValue + record['monto_programado'];
                                return total;
                            }
                      }]                  
            },
			{ text: 'Fecha Factura', datafield: 'fecha_factura', filtertype: 'input',width: '10%', cellsalign: 'center',align:'center',cellclassname: cellclass },
			{ text: 'Fecha Recep.Cliente', datafield: 'fecha_recepcion_cliente', filtertype: 'input',width: '10%', cellsalign: 'center',align:'center',cellclassname: cellclass ,hidden: true},
			{ text: 'Monto Factura', datafield: 'monto_factura', filtertype: 'input',width: '10%', cellsformat: 'c2',cellsalign: 'right',align:'center',cellclassname: cellclass,aggregates: [{ '<b>Bs.</b>': 
                            function (aggregatedValue, currentValue, column, record) {
                                var total = aggregatedValue + record['factura_total'];
                                return total;
                            }
                      }]
                  },
			{ text: 'Nro Deposito', datafield: 'nro_deposito', filtertype: 'input',width: '8%',cellclassname:cellclassdeposito,hidden: true },
			{ text: 'Fecha Deposito', datafield: 'fecha_deposito', filtertype: 'input',width: '10%', cellsalign: 'center',align:'center',cellclassname:cellclassdeposito },
			{ text: 'Monto Deposito', datafield: 'monto_deposito', filtertype: 'input',width: '12%', cellsformat: 'c2',cellsalign: 'right',align:'center',cellclassname:cellclassdeposito,
				aggregates: [{ '<b>Bs.</b>': 
				function (aggregatedValue, currentValue, column, record) {
					var total = aggregatedValue + record['deposito_total'];
					return total;
				}
				}]
			},
			{ text: 'Dias Atraso', datafield: 'dias_atraso', filtertype: 'input',width: '8%',align:'center',cellclassname:cellclassmora },
			{ text: 'Mora', datafield: 'mora', filtertype: 'input',width: '8%' ,cellsalign:'right',cellsformat: 'c2',cellclassname:cellclassmora,
				aggregates: [{ '<b>Bs.</b>': 
				function (aggregatedValue, currentValue, column, record) {
					var total = aggregatedValue + record['mora'];
					return total;
				}
				}]
			},
			{ text: 'Nro Dep. Mora', datafield: 'nro_deposito_mora', filtertype: 'input',width: '8%',cellclassname:cellclassmora,hidden: true },
			{ text: 'Fecha Dep. Mora', datafield: 'fecha_deposito_mora', filtertype: 'input',width: '10%', cellsalign: 'center',align:'center',cellclassname:cellclassmora},
			{ text: 'Monto Dep. Mora', datafield: 'monto_deposito_mora', filtertype: 'input',width: '10%',cellsformat: 'c2', cellsalign: 'right',align:'center',cellclassname:cellclassmora,
				aggregates: [{ '<b>Bs.</b>': 
				function (aggregatedValue, currentValue, column, record) {
					var total = aggregatedValue + record['mora_total'];
					return total;
				}
				}]
			},
			]
		});

	
}

var listSource =[	{ label: 'Fecha Programado', value: 'fecha_programado', checked: true }, 
					{ label: 'Monto Programado', value: 'monto_reprogramado_div', checked: true },
					{ label: 'Fecha Factura', value: 'fecha_factura', checked: true },
					{ label: 'Fecha Recep.Cliente', value: 'fecha_recepcion_cliente', checked: false },
					{ label: 'Monto Factura', value: 'monto_factura', checked: true },
					{ label: 'Nro Deposito', value: 'nro_deposito', checked: false },
					{ label: 'Fecha Deposito', value: 'fecha_deposito', checked: true },
					{ label: 'Monto Deposito', value: 'monto_deposito', checked: true },
					{ label: 'Dias Atraso', value: 'dias_atraso', checked: true },
					{ label: 'Mora', value: 'mora', checked: true },
					{ label: 'Nro Dep. Mora', value: 'nro_deposito_mora', checked: false },
					{ label: 'Fecha Dep. Mora', value: 'fecha_deposito_mora', checked: true },
					{ label: 'Monto Dep. Mora', value: 'monto_deposito_mora', checked: true }

				];
$("#jqxlistbox").jqxListBox({ source: listSource, width: '100%', height: 340, theme: 'custom', checkboxes: true });
$("#jqxlistbox").on('checkChange', function (event) {
	$("#jqxgrid").jqxGrid('beginupdate');
	if (event.args.checked) {
		$("#jqxgrid").jqxGrid('showcolumn', event.args.value);
	}
	else {
		$("#jqxgrid").jqxGrid('hidecolumn', event.args.value);
	}
	$("#jqxgrid").jqxGrid('endupdate');
});


// grid garantia
garantia()

function garantia(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'tipo',type: 'number'},
			{ name: 'tipo_text',type: 'string'},
			{ name: 'fecha_deposito',type: 'date'},
			{ name: 'nro_deposito',type: 'string'},
			{ name: 'monto_deposito',type: 'number'},
			{ name: 'accion',type: 'string'},
			],
			url: '/planpagos/listgarantia/'+$("#contratoproducto_id").val(),
			cache: false,
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
			
		$("#jqxgrid_garantia").jqxGrid({
            width: '100%',
            source: dataAdapter,
            pageable: false,
            autorowheight: true,
            autoheight: true,
            altrows: true,
            theme: 'custom',
            columnsresize: true,
            
            columns: [
            { text: 'Deposito', datafield: 'tipo_text', filtertype: 'input',width: '20%'},
            { text: 'Nro Deposito', datafield: 'nro_deposito', filtertype: 'input',width: '20%' },
            { text: 'Fecha Deposito', datafield: 'fecha_deposito', filtertype: 'range', width: '20%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
            { text: 'Monto Depositado', datafield: 'monto_deposito', filtertype: 'input',width: '30%', cellsformat: 'c2',cellsalign: 'right',align:'center'},
            { text: '', datafield: 'accion', filtertype: 'input',width: '10%',cellsalign: 'center',align:'center'},
			]
		});
}


$("#dep_garantia, #dep_derechollave, #dev_garantia").click(function() {
	// alert($(this).attr('tipo'));
	$('#tipo').val($(this).attr('tipo'));
	$('#garantia_id').val('');
	$('#titulo_derechollave').text('Adicionar Garantia');
	$('#myModal_derechollave').modal('show');
});

$("#testForm_derechollave").submit(function(){
	var v=$.ajax({
		url:'/planpagos/savegarantia/',
		type:'POST',
		datatype: 'json',
		data:{garantia_id:$("#garantia_id").val(),contratoproducto_id:$("#contratoproducto_id").val(),fecha_deposito:$("#fecha_deposito_derechollave").val(),nro_deposito:$("#nro_deposito_derechollave").val(),monto_deposito:$("#monto_deposito_derechollave").val(),tipo:$("#tipo").val()},
		success: function(data) { 
				garantia();
				devolucion();
				}, //mostramos el error
				error: function() { alert('Se ha producido un error Inesperado'); }
			});
	$('#myModal_derechollave').modal('hide');
    return false; // ajax used, block the normal submit
});
/*
Devolucion Garantia
 */
devolucion();

function devolucion(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'tipo',type: 'number'},
			{ name: 'tipo_text',type: 'string'},
			{ name: 'fecha_deposito',type: 'date'},
			{ name: 'nro_deposito',type: 'string'},
			{ name: 'monto_deposito',type: 'number'},
			{ name: 'accion',type: 'string'},
			],
			url: '/planpagos/listdevoluciongarantia/'+$("#contratoproducto_id").val(),
			cache: false,
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
		$("#jqxgrid_devolucion").jqxGrid({
            width: '100%',
            source: dataAdapter,
            pageable: false,
            autorowheight: true,
            autoheight: true,
            altrows: true,
            theme: 'custom',
            columnsresize: true,
            // showstatusbar: true,
            // statusbarheight: 25,
            // showaggregates: true,
            columns: [
			{ text: 'Devolución', datafield: 'tipo_text', filtertype: 'input',width: '20%' },
			{ text: 'Nro Deposito', datafield: 'nro_deposito', filtertype: 'input',width: '20%' },
			{ text: 'Fecha Deposito', datafield: 'fecha_deposito', filtertype: 'range', width: '20%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Monto Depositado', datafield: 'monto_deposito', filtertype: 'input',width: '30%', cellsformat: 'c2',cellsalign: 'right',align:'center'},
			{ text: '', datafield: 'accion', filtertype: 'input',width: '10%',cellsalign: 'center',align:'center'},
			]
		});
}
// /*
// Adicionar Derecho de llave
//  */
// $("#add_derechollave").click(function() {
// 	$('#titulo_derechollave').text('Adicionar Derecho de LLave');
// 	$("#garantia_id").val('');
// 	$('#myModal_derechollave').modal('show');
// });

// $("#edit_derechollave").click(function() {
// 	$('#titulo_derechollave').text('Editar Derecho de LLave');
// 	$("#garantia_id").val($(this).attr('garantia_id'));
// 	$("#fecha_deposito_derechollave").val($(this).attr('fecha_deposito'));
// 	$("#nro_deposito_derechollave").val($(this).attr('nro_deposito'));
// 	$("#monto_deposito_derechollave").val($(this).attr('monto_deposito'));
// 	$('#myModal_derechollave').modal('show');
// });

// $("#testForm_derechollave").submit(function(){
// 	var v=$.ajax({
// 		url:'/planpagos/savederechollave/',
// 		type:'POST',
// 		datatype: 'json',
// 		data:{garantia_id:$("#garantia_id").val(),contratoproducto_id:$("#contratoproducto_id").val(),fecha_deposito:$("#fecha_deposito_derechollave").val(),nro_deposito:$("#nro_deposito_derechollave").val(),monto_deposito:$("#monto_deposito_derechollave").val()},
// 		complete:function(){
// 			$("#edit_derechollave").click(function() {
// 				$('#titulo_derechollave').text('Editar Derecho de LLave');
// 				$("#garantia_id").val($(this).attr('garantia_id'));
// 				$("#fecha_deposito_derechollave").val($(this).attr('fecha_deposito'));
// 				$("#nro_deposito_derechollave").val($(this).attr('nro_deposito'));
// 				$("#monto_deposito_derechollave").val($(this).attr('monto_deposito'));
// 				$('#myModal_derechollave').modal('show');
// 			});	
// 		},
// 		success: function(data) { 
// 			$("#html_derechollave").html(data); 
// 				}, //mostramos el error
// 				error: function() { alert('Se ha producido un error Inesperado'); }
// 			});
// 	$('#myModal_derechollave').modal('hide');
//     return false; // ajax used, block the normal submit
// });

/*
Adicionar Garantia
 */
// $("#add_garantia").click(function() {
// 	$('#titulo_garantia').text('Adicionar Garantia');
// 	$('#myModal_garantia').modal('show');
// });

// $("#edit_garantia").click(function() {
// 	$('#titulo_garantia').text('Editar Garantia');
// 	$("#garantia_id").val($(this).attr('garantia_id'));
// 	$("#fecha_deposito_garantia").val($(this).attr('fecha_deposito'));
// 	$("#nro_deposito_garantia").val($(this).attr('nro_deposito'));
// 	$("#monto_deposito_garantia").val($(this).attr('monto_deposito'));

// 	$("#fecha_devolucion_garantia").val($(this).attr('fecha_devolucion'));
// 	$("#nro_devolucion_garantia").val($(this).attr('nro_devolucion'));
// 	$("#monto_devolucion_garantia").val($(this).attr('monto_devolucion'));

// 	$('#myModal_garantia').modal('show');
// });

// $("#testForm_garantia").submit(function(){
// 	var v=$.ajax({
// 		url:'/planpagos/savegarantia/',
// 		type:'POST',
// 		datatype: 'json',
// 		data:{garantia_id:$("#garantia_id").val(),contratoproducto_id:$("#contratoproducto_id").val(),fecha_deposito:$("#fecha_deposito_garantia").val(),nro_deposito:$("#nro_deposito_garantia").val(),monto_deposito:$("#monto_deposito_garantia").val(),fecha_devolucion:$("#fecha_devolucion_garantia").val(),nro_devolucion:$("#nro_devolucion_garantia").val(),monto_devolucion:$("#monto_devolucion_garantia").val()},
// 		complete:function(){
// 			$("#edit_garantia").click(function() {
// 				$('#titulo_garantia').text('Editar Garantia');
// 				$("#garantia_id").val($(this).attr('garantia_id'));
// 				$("#fecha_deposito_garantia").val($(this).attr('fecha_garantia'));
// 				$("#nro_deposito_garantia").val($(this).attr('nro_garantia'));
// 				$("#monto_deposito_garantia").val($(this).attr('monto_garantia'));

// 				$("#fecha_devolucion_garantia").val($(this).attr('fecha_devolucion'));
// 				$("#nro_devolucion_garantia").val($(this).attr('nro_devolucion'));
// 				$("#monto_devolucion_garantia").val($(this).attr('monto_devolucion'));

// 				$('#myModal_garantia').modal('show');
// 			});	
// 		},
// 		success: function(data) { 
// 			$("#html_garantia").html(data); 
// 				}, //mostramos el error
// 				error: function() { alert('Se ha producido un error Inesperado'); }
// 			});
// 	$('#myModal_garantia').modal('hide');
//     return false; // ajax used, block the normal submit
// });

/*
REgistro de deposito de pago
 */

$("#reg_deposito").click(function() {
 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		$("#planpago_id").val(dataRecord.id);
 		$("#titulo_deposito").text("Registrar Deposito");
 		$("#tipo_deposito").val(1);
 		var fp = $.jqx.dataFormat.formatdate(dataRecord.fecha_programado, 'dd-MM-yyyy');
 		$("#fecha_deposito").val(fp);
 		$("#monto_deposito").val(dataRecord.monto_reprogramado);
 		$('#myModal_deposito').modal('show');
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
 	}
 });

/*
REgistro de deposito de pago mora
 */

$("#reg_deposito_mora").click(function() {
 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		$("#planpago_id").val(dataRecord.id);
 		$("#titulo_deposito").text("Registrar Deposito Mora");
 		$("#tipo_deposito").val(2);
 		$('#myModal_deposito').modal('show');
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
 	}
 });

$("#testForm_deposito").submit(function(){
	var v=$.ajax({
		url:'/planpagos/savedepositopago/',
		type:'POST',
		datatype: 'json',
		data:{contratoproducto_id:$("#contratoproducto_id").val(),planpago_id:$("#planpago_id").val(),nro_deposito:$("#nro_deposito").val(),fecha_deposito:$("#fecha_deposito").val(),monto_deposito:$("#monto_deposito").val(),tipo_deposito:$("#tipo_deposito").val()},
		success: function(data) { 
				alert(data);
				cargar();
				}, //mostramos el error
				error: function() { alert('Se ha producido un error Inesperado'); }
			});
	$('#myModal_deposito').modal('hide');
    return false; // ajax used, block the normal submit
});


/*
Edicion de depositos
 */
$("#edit").click(function() {
 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		$("#planpago_id").val(dataRecord.id);
 		htmldepositos(dataRecord.id);	
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
 	}
 });



function htmldepositos(planpago_id) {
	
	var v=$.ajax({
		url:'/planpagos/htmldepositos/',
		type:'POST',
		datatype: 'json',
		complete:function(){

			$(".eliminar_deposito").click(function(){
				var ppd =$(this).attr('planpagodeposito_id');
				if(ppd!=""){
					bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el deposito?.", function(result) {
						if (result==true) {
							var v=$.ajax({
								url:'/planpagos/deletedeposito/',
								type:'POST',
								datatype: 'json',
								data:{planpagodeposito_id:ppd},
								success: function(data) { 
									htmldepositos($("#planpago_id").val());
									cargar();
								},
								error: function() { alert('Se ha producido un error Inesperado'); }
							});
						}
					});
				
				}else{
					bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para eliminar.");
				}
			});
    	},
		data:{planpago_id:planpago_id},
		success: function(data) { 
			$("#html_depositos").html(data); 
				}, //mostramos el error
				error: function() { alert('Se ha producido un error Inesperado'); }
		});
	$('#myModal_editdeposito').modal('show');
}


$("#fecha_deposito, #fecha_deposito_derechollave, #fecha_deposito_garantia, #fecha_devolucion_garantia").datepicker({
	autoclose:true,
});

})

var editar_garantia = function (row) {
	var rowindex = $('#jqxgrid_garantia').jqxGrid('getselectedrowindex');
	if (rowindex > -1) {
		var dataRecord = $("#jqxgrid_garantia").jqxGrid('getrowdata', rowindex);
		$("#garantia_id").val(dataRecord.id);
		$("#tipo").val(dataRecord.tipo);
		var fe = $.jqx.dataFormat.formatdate(dataRecord.fecha_deposito, 'dd-MM-yyyy');
		$("#fecha_deposito_derechollave").val(fe);
		$("#nro_deposito_derechollave").val(dataRecord.nro_deposito);
		$("#monto_deposito_derechollave").val(dataRecord.monto_deposito);
		$('#myModal_derechollave').modal('show');
	}else{
		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
	}
};

var eliminar_garantia = function (row) {
	var offset = $("#jqxgrid_garantia").offset();
	var rowindex = $('#jqxgrid_garantia').jqxGrid('getselectedrowindex');
	var dataRecord = $("#jqxgrid_garantia").jqxGrid('getrowdata', rowindex);
	bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el deposito?.", function(result) {
		if (result==true) {
			var v=$.ajax({
				url:'/planpagos/deletegarantia/',
				type:'POST',
				datatype: 'json',
				data:{id:dataRecord.id},
				success: function(data) { 
					$("#jqxgrid_garantia").jqxGrid('updatebounddata');
				},
				error: function() { alert('Se ha producido un error Inesperado'); }
			});
		}	
	});
};

var editar_devolucion = function (row) {
	var rowindex = $('#jqxgrid_devolucion').jqxGrid('getselectedrowindex');
	if (rowindex > -1) {
		var dataRecord = $("#jqxgrid_devolucion").jqxGrid('getrowdata', rowindex);
		$("#garantia_id").val(dataRecord.id);
			 		$("#tipo").val(dataRecord.tipo);
			 		var fe = $.jqx.dataFormat.formatdate(dataRecord.fecha_deposito, 'dd-MM-yyyy');
			 		$("#fecha_deposito_derechollave").val(fe);
			 		$("#nro_deposito_derechollave").val(dataRecord.nro_deposito);
			 		$("#monto_deposito_derechollave").val(dataRecord.monto_deposito);
			 		$('#myModal_derechollave').modal('show');
	}else{
		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
	}
};

var eliminar_devolucion = function (row) {
	var offset = $("#jqxgrid_devolucion").offset();
	var rowindex = $('#jqxgrid_devolucion').jqxGrid('getselectedrowindex');
	var dataRecord = $("#jqxgrid_devolucion").jqxGrid('getrowdata', rowindex);
	bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el deposito?.", function(result) {
		if (result==true) {
			var v=$.ajax({
								url:'/planpagos/deletegarantia/',
								type:'POST',
								datatype: 'json',
								data:{id:dataRecord.id},
								success: function(data) { 
									devolucion();
								},
								error: function() { alert('Se ha producido un error Inesperado'); }
							});
		}	
	});
};
