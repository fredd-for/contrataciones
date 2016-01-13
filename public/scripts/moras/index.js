
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
			{ name: 'deposito_mora_total',type:'number'},
			{ name: 'mora',type:'number'},
			{ name: 'dias_atraso',type:'number'},
			{ name: 'accion',type:'string'}
			],
			url: '/moras/list/',
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
				datafield: '', columntype: 'number', width: '2%',
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
			{ text: 'Monto Programado Bs.', datafield: 'monto_reprogramado', filtertype: 'number', width: '8%',cellsformat: "c2", cellsalign: 'right',cellclassname: cellclass},
			{ text: 'Monto Depositado Bs.', datafield: 'monto_depositado', filtertype: 'number', width: '8%',cellsformat: "c2", cellsalign: 'right',cellclassname: cellclass},
	        { text: 'Dias Atraso', datafield: 'dias_atraso', filtertype: 'number', width: '5%',cellsalign: 'center',cellclassname: cellclass},
	        { text: 'Mora Bs.', datafield: 'mora', filtertype: 'number', width: '5%',cellsformat: "c2", cellsalign: 'right',cellclassname: cellclass},
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

tinymce.init({
    selector: "textarea"
 });



})