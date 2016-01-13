$(document).ready(function (){

cargar();
function cargar(){
	var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'razon_social_href',type: 'string'},
			{ name: 'razon_social',type: 'string'},
			{ name: 'nit',type: 'string'},
			{ name: 'telefono',type: 'number'},
			{ name: 'celular',type: 'number'},
			{ name: 'correo',type: 'string'},
			{ name: 'direccion',type: 'string'},
			{ name: 'representante_legal',type:'string'},
			{ name: 'ci_representante_legal',type:'string'},
			{ name: 'celular_representante_legal',type:'number'},
			{ name: 'correo_representante_legal',type:'string'},
			{ name: 'nombre_ref',type:'string'},
			{ name: 'ci_ref',type:'string'},
			{ name: 'celular_ref',type:'celular'},
			{ name: 'correo_ref',type:'string'},
			{ name: 'estado',type:'string'},
			{ name: 'foto'},
			],
			url: '/clientes/list',
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
		// var cellclass = function (row, columnfield, value) {
  //               if (value == 'Activo') {
  //                   return 'green';
  //               }else{
  //               	return 'red';
  //               }
  //       }

		$("#jqxgrid").jqxGrid({
			width: '100%',
			height: '450',
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
			scrollfeedback: function (row)
			{
				return '<table style="height: 80px;"><tr><td><img src="' + row.foto + '"  height="90"/></td></tr><tr><td>' + row.producto + '</td></tr></table>';
			},

			columns: [
			// {
			// 	text: '#', sortable: false, filterable: false, editable: false,
			// 	groupable: false, draggable: false, resizable: false,
			// 	datafield: '', columntype: 'number', width: '3%',
			// 	cellsrenderer: function (row, column, value) {
			// 		return "<div style='margin:4px;'>" + (value + 1) + "</div>";
			// 	}
			// },
			{text: 'Image', datafield: 'foto', width: 100, cellsrenderer: function (row, column, value) {
				return '<img style="margin-left: 5px;" height="70" width="100%" src="' + value + '" />';
				}
			},
			{ text: 'Razón Social', columngroup: 'cliente',datafield: 'razon_social_href', filtertype: 'input',width: '15%' },
			{ text: 'NIT', columngroup: 'cliente',datafield: 'nit', filtertype: 'input',width: '8%' },
			{ text: 'Telefono', columngroup: 'cliente',datafield: 'telefono', filtertype: 'input',width: '8%'},
			{ text: 'Celular', columngroup: 'cliente',datafield: 'celular', filtertype: 'input',width: '8%'},
			{ text: 'Correo', columngroup: 'cliente',datafield: 'correo', filtertype: 'input',width: '8%'},
			{ text: 'Dirección', columngroup: 'cliente',datafield: 'direccion', filtertype: 'input',width: '20%'},
			{ text: 'Estado', columngroup: 'cliente',datafield: 'estado', filtertype: 'input',width: '8%'},
			{ text: 'Representante Legal', columngroup: 'representante',datafield: 'representante_legal', filtertype: 'input',width: '10%'},
			{ text: 'Celular', columngroup: 'representante',datafield: 'celular_representante_legal',filtertype: 'input', width: '10%' },
			{ text: 'Correo', columngroup: 'representante',datafield: 'correo_representante_legal',filtertype: 'input', width: '10%'},
			{ text: 'Persona Contacto', columngroup: 'contacto',datafield: 'nombre_ref', filtertype: 'input',width: '10%'},
			{ text: 'Celular', columngroup: 'contacto',datafield: 'celular_ref',filtertype: 'input', width: '10%' },
			{ text: 'Correo', columngroup: 'contacto',datafield: 'correo_ref',filtertype: 'input', width: '10%' },
			],
			columngroups: [
			{ text: 'CLIENTE / EMPRESA', align: 'center', name: 'cliente' },
			{ text: 'REPRESENTANTE LEGAL', align: 'center', name: 'representante' },
			{ text: 'PERSONA DE CONTACTO', align: 'center', name: 'contacto' }
			]
		});


/*	Segunda Grilla*/
// var dataFields = [
// { name: 'id', type: 'number' },
// { name: 'contrato', type: 'string' },
// { name: 'cliente_id', type: 'number' },
// { name: 'fecha_contrato', type: 'date' },
// { name: 'descripcion', type: 'string' },
// { name: 'num_productos', type: 'number' },
// { name: 'dias_tolerancia', type: 'number' },
// { name: 'porcentaje_mora', type: 'number' },
// { name: 'responsable', type: 'string' },
// { name: 'responsable_id', type: 'number' },
// ];

// var sourceSeg =
// {
// 	datafields: dataFields,
// 	datatype: "json",
// 	url: '/clientes/listcontratos',
// 	async: false
// };

// var dataAdapter = new $.jqx.dataAdapter(sourceSeg);
// dataAdapter.dataBind();

// $("#jqxgrid").on('rowselect', function (event) {
// 	$("#text_cliente").text(event.args.row.razon_social);
// 	var id = event.args.row.id;
// 	var records = new Array();
// 	var length = dataAdapter.records.length;
// 	for (var i = 0; i < length; i++) {
// 		var record = dataAdapter.records[i];
// 		if (record.cliente_id == id) {
// 			records[records.length] = record;
// 		}
// 	}

// 	var dataSource = {
// 		datafields: dataFields,
// 		localdata: records
// 	}
// 	var adapter = new $.jqx.dataAdapter(dataSource);
//     $("#jqxgrid_contratos").jqxGrid({ source: adapter });
// });

// $("#jqxgrid_contratos").jqxGrid(
// {
// 	width: '100%',
// 	height: '300',
// 	source: dataAdapter,
// 	sortable: true,
// 	altRows: true,
// 	columnsresize: true,
// 	pageable: true,
// 	pagerMode: 'advanced',
// 	theme: 'custom',
// 	showfilterrow: true,
// 	// showstatusbar: true,
// 	showfilterrow: true,
// 	filterable: true,
// 	autorowheight: true,
// 	columns: [
// 	{
// 		text: '#', sortable: false, filterable: false, editable: false,
// 		groupable: false, draggable: false, resizable: false,
// 		datafield: '', columntype: 'number', width: '3%',
// 		cellsrenderer: function (row, column, value) {
// 			return "<div style='margin:4px;'>" + (value + 1) + "</div>";
// 		}
// 	},
// 	{ text: 'Responsable', datafield: 'responsable', filtertype: 'input',width: '17%' },
// 	{ text: 'Nro Contrato', datafield: 'contrato', filtertype: 'input',width: '10%' },
// 	{ text: 'Descripción', datafield: 'descripcion',filtertype: 'input', width: '40%' },
// 	{ text: 'Fecha Contrato', datafield: 'fecha_contrato', filtertype: 'range', width: '10%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
// 	{ text: 'Dias Tolerancia', datafield: 'dias_tolerancia', filtertype: 'input',width: '10%' },
// 	{ text: '% Mora', datafield: 'porcentaje_mora', filtertype: 'input',width: '10%' },
// 	{ text: 'Nro Productos', datafield: 'num_productos', filtertype: 'input',width: '5%' }
// 	]
// });

}
		
/*
adicionar 
*/
$("#add").click(function(){
	$("#titulo").text("Adicionar Cliente");
	$("#id").val("");

	$("#razon_social").val("");
	$("#nit").val("");
	$("#telefono").val("");
	$("#celular").val("");
	$("#correo").val("");
	$("#direccion").val("");
	$("#representante_legal").val("");
	$("#ci_representante_legal").val();
	$("#celular_representante_legal").val("");
	$("#correo_representante_legal").val("");
	$("#nombre_ref").val("");
	$("#ci_ref").val("");
	$("#celular_ref").val("");
	$("#correo_ref").val("");

	$('#myModal').modal('show');
});

/*
Ver
 */

 $("#view").click(function() {
 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		window.location.href = 'clientes/view/'+dataRecord.id;
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para ver.");
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
 		$("#titulo").text("Editar Cliente");

 		$("#razon_social").val(dataRecord.razon_social);
 		$("#nit").val(dataRecord.nit);
 		$("#telefono").val(dataRecord.telefono);
 		$("#celular").val(dataRecord.celular);
 		$("#correo").val(dataRecord.correo);
 		$("#direccion").val(dataRecord.direccion);
 		$("#representante_legal").val(dataRecord.representante_legal);
 		$("#ci_representante_legal").val(dataRecord.ci_representante_legal);
 		$("#celular_representante_legal").val(dataRecord.celular_representante_legal);
 		$("#correo_representante_legal").val(dataRecord.correo_representante_legal);
 		$("#nombre_ref").val(dataRecord.nombre_ref);
 		$("#ci_ref").val(dataRecord.ci_ref);
 		$("#celular_ref").val(dataRecord.celular_ref);
 		$("#correo_ref").val(dataRecord.correo_ref);

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
                        url: '/clientes/delete/',
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
$("#wizard").submit(function() {
	var v=$.ajax({
            	url:'/clientes/save/',
            	type:'POST',
            	datatype: 'json',
            	data:{id:$("#id").val(),razon_social:$("#razon_social").val(),nit:$("#nit").val(),telefono:$("#telefono").val(),celular:$("#celular").val(),correo:$("#correo").val(),direccion:$("#direccion").val(),representante_legal:$("#representante_legal").val(),ci_representante_legal:$("#ci_representante_legal").val(),celular_representante_legal:$("#celular_representante_legal").val(),correo_representante_legal:$("#correo_representante_legal").val(),nombre_ref:$("#nombre_ref").val(),ci_ref:$("#ci_ref").val(),celular_ref:$("#celular_ref").val(),correo_ref:$("#correo_ref").val()},
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


/*
Crear nuevo contrato
 */
 // $("#crear_contrato").click(function(){
 // 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 // 	if (rowindex > -1)
 // 	{
 // 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 // 		$("#id").val(dataRecord.id);
 // 		$("#contrato_id").val(0);
 // 		$("#titulo_contrato").text("Crear Nuevo Contrato");
 // 		$("#rs").val(dataRecord.razon_social);
 // 		$("#rl").val(dataRecord.representante_legal);
 // 		$("#cliente_id").val(dataRecord.id);

 // 		$('#myModal_contrato').modal('show');
 // 	}
 // 	else
 // 	{
 // 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para crear un contrato.");
 // 	}
 // });

 /*
 Editar Contrato Creado
  */
// $("#edit_contrato").click(function(){
// 	var rowindex = $('#jqxgrid_contratos').jqxGrid('getselectedrowindex');
//  	if (rowindex > -1)
//  	{
//  		var dataRecord = $("#jqxgrid_contratos").jqxGrid('getrowdata', rowindex);

//  		var rowindex2 = $('#jqxgrid').jqxGrid('getselectedrowindex');
//  		var dataRecord2 = $("#jqxgrid").jqxGrid('getrowdata', rowindex2);

//  		$("#contrato_id").val(dataRecord.id);
//  		$("#titulo_contrato").text("Editar Contrato");
//  		$("#rs").val(dataRecord2.razon_social);
//  		$("#rl").val(dataRecord2.representante_legal);
//  		$("#contrato").val(dataRecord.contrato);
//  		$("#descripcion").val(dataRecord.descripcion);
//  		var fc = $.jqx.dataFormat.formatdate(dataRecord.fecha_contrato, 'dd-MM-yyyy');
//  		$("#fecha_contrato").val(fc);
//  		$("#cliente_id").val(dataRecord.cliente_id);
//  		$("#responsable_id").val(dataRecord.responsable_id);
//  		$('#myModal_contrato').modal('show');
//  	}
//  	else
//  	{
//  		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar contrato.");
//  	}
// });


/*
Ver Productod del Contrato
 */
// $("#ver_productos").click(function(){
// 	var rowindex = $('#jqxgrid_contratos').jqxGrid('getselectedrowindex');
//  	if (rowindex > -1)
//  	{
//  		var dataRecord = $("#jqxgrid_contratos").jqxGrid('getrowdata', rowindex);
//  		var url = "/contratos/crear/"+dataRecord.id;    
// 		$(location).attr('href',url);	
//  	}
//  	else
//  	{
//  		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro.");
//  	}
// });

/*
Eliminar Contrato
 */
// $("#delete_contrato").click(function(){
// 	var rowindex = $('#jqxgrid_contratos').jqxGrid('getselectedrowindex');
//  	if (rowindex > -1)
//  	{
//  		var dataRecord = $("#jqxgrid_contratos").jqxGrid('getrowdata', rowindex);
//  		if (dataRecord.num_productos==0) {
//  			bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el registro.", function(result) {
//                 if (result == true) {
//                     var v = $.ajax({
//                         url: '/clientes/deletecontrato/',
//                         type: 'POST',
//                         datatype: 'json',
//                         data: {id: dataRecord.id},
//                         success: function(data) {
//                             cargar(); //alert('Guardado Correctamente'); 
//                             $("#divMsjeExito2").show();
//                     		$("#divMsjeExito2").addClass('alert alert-warning alert-dismissable');
//                     		$("#aMsjeExito2").html(data); 
//                         }, //mostramos el error
//                         error: function() {
//                             alert('Se ha producido un error Inesperado');
//                         }
//                     });
//                 }
//             });
//  		}else{
// 			bootbox.alert("<strong>¡Mensaje!</strong> No puede eliminar el contrato por que tiene productos agregados."); 			
//  		}
//  	}
//  	else
//  	{
//  		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para eliminar.");
//  	}
// });

/*
guardar 
 */
// $("#testForm_contrato").submit(function() {
// 	var v=$.ajax({
//             	url:'/clientes/savecontrato/',
//             	type:'POST',
//             	datatype: 'json',
//             	data:{contrato_id:$("#contrato_id").val(),cliente_id:$("#cliente_id").val(),contrato:$("#contrato").val(),fecha_contrato:$("#fecha_contrato").val(),arrendador:$("#arrendador").val(),arrendador_rep_legal:$("#arrendador_rep_legal").val(),arrendador_cargo:$("#arrendador_cargo").val(),descripcion:$("#descripcion").val(),dias_tolerancia:$("#dias_tolerancia").val(),porcentaje_mora:$("#porcentaje_mora").val(),responsable_id:$("#responsable_id").val()},
// 				success: function(data) { 
// 					if ($("#contrato_id").val()>0) {
// 						cargar();
// 						$("#divMsjeExito").show();
//                     	$("#divMsjeExito").addClass('alert alert-info alert-dismissable');
//                     	$("#aMsjeExito").html('Guardado Correctamente'); 
// 					}else{
// 						var url = "/contratos/crear/"+data;    
// 						$(location).attr('href',url);	
// 					}
					
					
// 				}, //mostramos el error
// 			error: function() { alert('Se ha producido un error Inesperado'); }
// 			});
//             $('#myModal_contrato').modal('hide');
//             return false; // ajax used, block the normal submit
// 	});



/*
grilla de solicitudes
 */
// var source =
// 		{
// 			datatype: "json",
// 			datafields: [
// 			{ name: 'id',type: 'number'},
// 			{ name: 'nro_solicitud',type: 'string'},
// 			{ name: 'fecha_envio_solicitud',type: 'date'},
// 			{ name: 'fecha_recepcion_solicitud',type: 'date'},
// 			{ name: 'productos_solicitados',type: 'string'},
// 			{ name: 'respuesta',type: 'string'},
// 			{ name: 'fecha_envio_resp',type: 'date'},
// 			{ name: 'fecha_recepcion_resp',type: 'date'},
// 			{ name: 'descripcion_resp',type: 'string'},
// 			{ name: 'cliente_id',type: 'number'},
// 			],
// 			url: '/solicitudes/list',
// 			cache: false
// 		};
// 		var dataAdapter = new $.jqx.dataAdapter(source);

// 		$("#jqxgrid_solicitudes").jqxGrid({
// 			width: '100%',
// 			height: '300',
// 			source: dataAdapter,
// 			sortable: true,
// 			altRows: true,
// 			columnsresize: true,
// 			pageable: true,
// 			pagerMode: 'advanced',
// 			theme: 'custom',
// 			//scrollmode: 'deferred',
// 			//showstatusbar: true,
// 			showfilterrow: true,
// 			filterable: true,
// 			autorowheight: true,
// 			keyboardnavigation: false,
// 			columns: [
// 			{
// 				text: '#', sortable: false, filterable: false, editable: false,
// 				groupable: false, draggable: false, resizable: false,
// 				datafield: '', columntype: 'number', width: '3%',
// 				cellsrenderer: function (row, column, value) {
// 					return "<div style='margin:4px;'>" + (value + 1) + "</div>";
// 				}
// 			},
// 			{ text: 'Nro Solicitud', datafield: 'nro_solicitud', filtertype: 'input',width: '27%' },
// 			{ text: 'Fecha Recepción Solicitud', datafield: 'fecha_recepcion_solicitud', filtertype: 'input',width: '70%' },
// 			{ text: 'Productos Solicitados', datafield: 'productos_solicitados', filtertype: 'input',width: '27%' },
// 			{ text: 'Respuesta', datafield: 'respuesta', filtertype: 'input',width: '27%' },
// 			]
// 		});
/*
End grilla de solicitud
 */


})