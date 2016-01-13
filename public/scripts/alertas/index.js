
$(document).ready(function (){
cargar();	
	function cargar(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'razon_social',type: 'string'},
			{ name: 'correo',type: 'string'},
			{ name: 'representante_legal',type: 'string'},
			{ name: 'correo_representante_legal',type: 'string'},
			{ name: 'nombre_ref',type: 'string'},
			{ name: 'correo_ref',type: 'string'},
			{ name: 'nit',type: 'string'},
			{ name: 'grupo',type: 'string'},
			{ name: 'linea',type: 'string'},
			{ name: 'estacion',type: 'string'},
			{ name: 'producto',type: 'string'},
			{ name: 'contrato',type: 'string'},
			{ name: 'fecha_programado',type:'date'},
			{ name: 'monto_reprogramado',type: 'number'},
			{ name: 'monto_depositado',type: 'number'},
			{ name: 'diferencia_dias',type:'number'},
			{ name: 'accion',type:'string'}
			],
			url: '/alertas/list/',
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
		var tooltiprenderer = function (element) {
                $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
        };
        var cellclass = function (row, columnfield, value,data) {
                if (data.diferencia_dias > 0) {
                    return 'red';
                } else {
                	return 'yellow';	
                }
                
        }
		$("#jqxgrid").jqxGrid({

			width: '100%',
            source: dataAdapter,                
            sortable: true,
            altRows: true,
            columnsresize: true,
            theme: 'custom',
            //showstatusbar: true,
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
			//{ text: 'Grupo', datafield: 'grupo', filtertype: 'checkedlist',width: '8%', rendered: tooltiprenderer },
			{ text: 'Linea', datafield: 'linea', filtertype: 'checkedlist',width: '8%',cellclassname: cellclass },
			{ text: 'Estación', datafield: 'estacion', filtertype: 'checkedlist',width: '12%',cellclassname: cellclass },
			{ text: 'Cliente / Razón Social', datafield: 'razon_social', filtertype: 'input',width: '15%',cellclassname: cellclass },
			{ text: 'Contrato', datafield: 'contrato', filtertype: 'input',width: '10%',cellclassname: cellclass },
			{ text: 'Producto', datafield: 'producto', filtertype: 'input',width: '12%',cellclassname: cellclass },
			{ text: 'Fecha Programado', datafield: 'fecha_programado', filtertype: 'range', width: '10%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center',cellclassname: cellclass},
			{ text: 'Monto Programado Bs.', datafield: 'monto_reprogramado', filtertype: 'number', width: '10%',cellsformat: "c2", cellsalign: 'right',cellclassname: cellclass},
			{ text: 'Monto Depositado Bs.', datafield: 'monto_depositado', filtertype: 'number', width: '10%',cellsformat: "c2", cellsalign: 'right',cellclassname: cellclass},
	        { text: 'Dias Atraso', datafield: 'diferencia_dias', filtertype: 'number', width: '5%',cellsalign: 'center',cellclassname: cellclass},
	        { text: '', datafield: 'accion', filtertype: 'input', width: '5%',cellsalign: 'center'},
			],
			//groups: ['razon_social','contrato']
		});

 		//$("#jqxgrid").jqxGrid('expandgroup',4);
}

$("#enviar_correo").click(function() {
 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		$("#titulo").text("Envio de Correo");
 		$("#text_destinatario").text(dataRecord.razon_social+' - '+dataRecord.correo);
 		$("#destinatario_correo").val(dataRecord.correo);
 		$("#destinatario").val(dataRecord.razon_social);
 		var text_concopia='';
 		var concopia='';
 		var concopia_correo='';
 		// alert(dataRecord.representante_legal);
 		if (dataRecord.correo_representante_legal!='') {
 			text_concopia+=dataRecord.representante_legal+' - '+dataRecord.correo_representante_legal+';';
 			concopia+=dataRecord.representante_legal+';';
 			concopia_correo+=dataRecord.correo_representante_legal+';';
 		}
 		if (dataRecord.correo_ref!='') {
 			text_concopia+=dataRecord.nombre_ref+' - '+dataRecord.correo_ref+';';
 			concopia+=dataRecord.nombre_ref+';';
 			concopia_correo+=dataRecord.correo_ref+';';
 		}
 		$("#text_concopia").text(text_concopia);
 		$("#concopia_correo").val(concopia_correo);
 		$("#concopia").val(concopia);
 		$("#asunto").val('Notificación Pago de Alquiler');
 		$('#myModal').modal('show');
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
 	}
 });


cargar2();	
	function cargar2(){	
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
			{ name: 'fecha_fin',type:'date'},
			{ name: 'diferencia_dias',type:'number'}
			],
			url: '/alertas/listcontratos/',
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
		var tooltiprenderer = function (element) {
                $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
        };
        var cellclass = function (row, columnfield, value,data) {
                if (data.diferencia_dias > 15) {
                    return 'yellow';
                } else {
                	return 'red';	
                }
                
        }
		$("#jqxgrid_contratos").jqxGrid({

			width: '100%',
            source: dataAdapter,                
            sortable: true,
            altRows: true,
            columnsresize: true,
            theme: 'custom',
            //showstatusbar: true,
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
			//{ text: 'Grupo', datafield: 'grupo', filtertype: 'checkedlist',width: '8%', rendered: tooltiprenderer },
			{ text: 'Linea', datafield: 'linea', filtertype: 'checkedlist',width: '10%',cellclassname: cellclass },
			{ text: 'Estación', datafield: 'estacion', filtertype: 'checkedlist',width: '15%',cellclassname: cellclass },
			{ text: 'Cliente / Razón Social', datafield: 'razon_social', filtertype: 'input',width: '19%',cellclassname: cellclass },
			{ text: 'Contrato', datafield: 'contrato', filtertype: 'input',width: '10%',cellclassname: cellclass },
			{ text: 'Producto', datafield: 'producto', filtertype: 'input',width: '15%',cellclassname: cellclass },
			{ text: 'Fecha Finalización', datafield: 'fecha_fin', filtertype: 'range', width: '10%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center',cellclassname: cellclass},
	        { text: 'Dias Faltantes', datafield: 'diferencia_dias', filtertype: 'number', width: '10%',cellsalign: 'center',cellclassname: cellclass},
			],
			//groups: ['razon_social','contrato']
		});

 		//$("#jqxgrid").jqxGrid('expandgroup',4);
}

tinymce.init({
    selector: "textarea"
 });


/*
prueba para borrar
 */

//  function cargarGrilla(){
//  	/*$("#jqxgrid").jqxGrid('updatebounddata');*/
//  	var theme = 'classic';
//  	var dataAdapter = new $.jqx.dataAdapter(source,
//  	{
//  		formatData: function (data) {
//  			return {};
//  		}
//  	}
//  	);

//  	var source =
//  	{
//  		datatype: "json",
//  		datafields: [
//  		{ name: 'numHojaruta',type: 'string',sortable: false, editable: true},
//  		{ name: 'codref',type: 'string',sortable: false, editable: true},
//  		{ name: 'titulo',type: 'string',sortable: false, editable: true},
//  		{ name: 'tipoArchivo',type: 'string',sortable: false, editable: true},
//  		{ name: 'fecha',type: 'string'},
//  		{ name: 'notas',type: 'string',sortable: false, editable: true},
//  		{ name: 'oficina',type: 'string',index: 'oficina',sortable: false, editable: true},
//  		{ name: 'gestion', index: 'gestion', sortable: false, editable: true },
//  		{ name: 'idac',type:'numeric'},
//  		{ name: 'iddi',type:'numeric'},
//  		{ name: 'idreg',type:'numeric'}
//  		],
//  		url:'/archivo/ajax/listGrillaExpediente/',
//  		async: false,
//  		root: 'Rows',
//  		beforeprocessing: function(data)
//  		{
//  			source.totalrecords = data[0].TotalRows;
//  		}
//  	};
//  	var dataAdapter = new $.jqx.dataAdapter(source);
//  	$("#jqxgrid").jqxGrid(
//  	{
//  		width: '100%',
//  		source: dataAdapter,
//  		sortable: true,
//  		rowsheight:30,
//  		pageable: true,
//  		selectionmode: 'multiplerowsextended',
//  		pagerMode: 'advanced',
//  		columnsresize: true,
//  		autoheight: true,
//  		filterable: true,
//  		autorowheight: true,
//  		virtualmode: true,
//  		altrows: true,
//  		rendergridrows: function()
//  		{
//  			return dataAdapter.records;
//  		},
//  		pagermode: 'simple',
//  		columns: [
//  		{ text: '#', sortable: false, filterable: false, editable: false,groupable: false, draggable: false, resizable: false,datafield: '', columntype: 'number', width: '2%'},
//  	{ text: 'NUM', datafield: 'number',cellsalign: 'center',align: 'center',width: '4%',hidden:true},
//  	{ text: 'HOJA RUTA', datafield: 'numHojaruta',filtercondition: 'starts_with',align:'center',width: '6%'},
//  	{ text: 'COD. REFERENCIA', datafield: 'codref',filtercondition: 'starts_with',align:'center',width: '10%'},
//  	{ text: 'TITULO', datafield: 'link',align:'left', width: '19%'},
//  { text: 'TIPO', datafield: 'tipoArchivo',align:'center',cellsalign: 'center', width: '6%' },
//  { text: 'FECHA REG.', datafield: 'fecha',filtercondition: 'starts_with', filtertype: 'date',align:'center',cellsalign: 'center',width: '6%', cellsformat: 'dd-mm-yyyy', dateformat: 'dd-mm-yyyy' },
//  { text: 'NOTAS', datafield: 'notas',align:'center', width: '29.2%' },
//  { text: 'OFICINA', datafield: 'oficina',align:'center', width: '11.5%' },
//  { text: 'GESTION', datafield: 'gestion',cellsalign: 'center', align: 'center', width: '4%'},
//  { text: 'ACCIONES', datafield: 'idac', width: '119px;',align:'center' ,cellsalign:'center', sortable:false,showfilterrow:false, filterable:false,columntype: 'number',
//  cellsrenderer: function (rowline) {
//  	ctrlrow = rowline
//  	var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', ctrlrow);
// 	var idac = dataRecord.idac;
//  		return "<a onclick='verdetalleArchivo("+idac+");' title='UBICACION EXPEDIENTE' class='btn btn-info iconshowrexpediete'> </a> "
//  		+"<a onclick='modificarExpediente("+idac+");' title='MODIFICAR EXPEDIENTE' class='btn btn-info iconoedit' data-type='zoomin'></a> "
//  		+"<a onclick='eliminarExpediente("+idac+");' title='ELIMINAR EXPEDIENTE' class='btn btn-info iconoeli deletexpediente'></a>";
//  	}
//  }
//  ]
// });

// }
// style css
// .iconshowrexpediete{

// 	width: 14px;

// 	height: 18px;

// 	background:url(/mediaa/icono/centrala.png) center right no-repeat;

// 	center right no-repeat

// }

// .iconoedit{

// 	width: 14px;

// 	height: 18px;

// 	background:url(/mediaa/icono/Update1.png) center right no-repeat;

// 	center right no-repeat

// }

// .iconoeli{

// 	width: 14px;

// 	height: 18px;

// 	text-align: ;

// 	background:url(/mediaa/icono/delete1.png) center right no-repeat;

// 	center right no-repeat

// }
/*
fin prueba
 */

})