$(document).ready(function (){
	// var t = "9,10,".split(',');
	var t = $("#cp_ids").val().split(',');
	for (var i =0 ; i < t.length; i++) {
		if (t[i]>0) {
			cargar(t[i]);
			garantia(t[i]);
			devolucion(t[i]);
		};
		
	}

	function cargar(cp_id){	
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
			{ name: 'monto_factura',type: 'string'},
			{ name: 'fecha_actual',type: 'date'},
			{ name: 'fecha_10',type: 'date'},
			{ name: 'fecha_tolerancia',type: 'date'},
			],
			url: '/planpagos/listcontrolpago/'+cp_id,
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

		$("#jqxgrid"+cp_id).jqxGrid({
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

			columns: [
			{ text: 'Fecha Programado', datafield: 'fecha_programado', filtertype: 'range', width: '10%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Monto Programado', datafield: 'monto_reprogramado_div', filtertype: 'input',width: '12%' ,cellsformat: 'c2',cellsalign: 'right',align:'center',aggregates: [{ '<b>Total Bs.</b>': 
                            function (aggregatedValue, currentValue, column, record) {
                                var total = aggregatedValue + record['monto_programado'];
                                return total;
                            }
                      }]                  
            },
			// { text: 'Nro Factura', datafield: 'nro_factura', filtertype: 'input',width: '8%' },
			{ text: 'Fecha Factura', datafield: 'fecha_factura', filtertype: 'input',width: '10%', cellsalign: 'center',align:'center',cellclassname: cellclass },
			{ text: 'Monto Factura', datafield: 'monto_factura', filtertype: 'input',width: '10%', cellsformat: 'c2',cellsalign: 'right',align:'center',cellclassname: cellclass,aggregates: [{ '<b>Bs.</b>': 
                            function (aggregatedValue, currentValue, column, record) {
                                var total = aggregatedValue + record['factura_total'];
                                return total;
                            }
                      }]
                  },
			// { text: 'Nro Deposito', datafield: 'nro_deposito', filtertype: 'input',width: '8%' },
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
			// { text: 'Nro Deposito Mora', datafield: 'nro_deposito_mora', filtertype: 'input',width: '8%' },
			{ text: 'Fecha Deposito Mora', datafield: 'fecha_deposito_mora', filtertype: 'input',width: '10%', cellsalign: 'center',align:'center',cellclassname:cellclassmora },
			{ text: 'Monto Deposito Mora', datafield: 'monto_deposito_mora', filtertype: 'input',width: '10%',cellsformat: 'c2', cellsalign: 'right',align:'center',cellclassname:cellclassmora,
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

function garantia(cp_id){	
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
			url: '/planpagos/listgarantia/'+cp_id,
			cache: false,
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
			
		$("#jqxgrid_garantia"+cp_id).jqxGrid({
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
            { text: 'Fecha Deposito', datafield: 'fecha_deposito', filtertype: 'range', width: '30%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
            { text: 'Monto Depositado', datafield: 'monto_deposito', filtertype: 'input',width: '30%', cellsformat: 'c2',cellsalign: 'right',align:'center'},
            // { text: '', datafield: 'accion', filtertype: 'input',width: '10%',cellsalign: 'center',align:'center'},
			]
		});
}

function devolucion(cp_id){	
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
			url: '/planpagos/listdevoluciongarantia/'+cp_id,
			cache: false,
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
		$("#jqxgrid_devolucion"+cp_id).jqxGrid({
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
			{ text: 'Fecha Deposito', datafield: 'fecha_deposito', filtertype: 'range', width: '30%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Monto Depositado', datafield: 'monto_deposito', filtertype: 'input',width: '30%', cellsformat: 'c2',cellsalign: 'right',align:'center'},
			// { text: '', datafield: 'accion', filtertype: 'input',width: '10%',cellsalign: 'center',align:'center'},
			]
		});
}

$("#finalizar_contrato").click(function(){
	$("#titulo").text("Finalizar Contrato Nro: "+$(this).attr('nro_contrato'));
	$("#contrato_id").val($(this).attr('contrato_id'));
	$("#contratoproducto_id").val(0);
	$("#estado").val("");
	$("#observacion").val("");
	$('#myModal').modal('show');
});

$("a.productos").click(function(){
	// alert($(this).attr('producto_id'));
	$("#titulo").text("Finalizar Producto: "+$(this).attr('producto'));
	// $("#contrato_id").val(0);
	$("#contratoproducto_id").val($(this).attr('contratoproducto_id'));
	$("#estado").val("");
	$("#observacion").val("");
	$('#myModal').modal('show');
});

/*
guardar 
 */
// $("#testForm").submit(function() {
// 	var v=$.ajax({
//             	url:'/contratos/savefinalizar/',
//             	type:'POST',
//             	datatype: 'json',
//             	data:{contrato_id:$("#contrato_id").val(),contratoproducto_id:$("#contratoproducto_id").val(),estado:$("#estado").val(),observacion:$("#observacion").val()},
// 				success: function(data) { 
// 					// $("#divMsjeExito").show();
//      //                $("#divMsjeExito").addClass('alert alert-info alert-dismissable');
//      //                $("#aMsjeExito").html(data); 
//                    document.location.href = "/contratos/finalizar/"+$("#contrato_id").val();
// 				}, //mostramos el error
// 			error: function() { alert('Se ha producido un error Inesperado'); }
// 			});
//             $('#myModal').modal('hide');
//             return false; // ajax used, block the normal submit
// });

})