
$(document).ready(function (){
cargar();
function cargar(){
	var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id', type: 'number' },
			{ name: 'contrato', type: 'string' },
			{ name: 'cliente_id', type: 'number' },
			{ name: 'razon_social', type: 'string' },
			{ name: 'fecha_contrato', type: 'date' },
			{ name: 'descripcion', type: 'string' },
			{ name: 'num_productos', type: 'number' },
			{ name: 'dias_tolerancia', type: 'number' },
			{ name: 'porcentaje_mora', type: 'number' },
			{ name: 'responsable', type: 'string' },
			{ name: 'responsable_id', type: 'number' },
			{ name: 'estado', type: 'number' },
			{ name: 'estado_text', type: 'string' },
			{ name: 'tipo_pago', type: 'number' },
			{ name: 'tipo_cobro_mora', type: 'number' },

			],
			url: '/contratos/list',
			cache: false
		};
		// var dataAdapter = new $.jqx.dataAdapter(source);
		var dataAdapter = new $.jqx.dataAdapter(source, {
                // downloadComplete: function (data, status, xhr) { },
                loadComplete: function (data) { 
                	if ($("#opcion").val()==1) {
                		firstNameColumnFilter();
                	}
                },
                // loadError: function (xhr, status, error) { }
            });

		var firstNameColumnFilter = function () {
	 	 $("#jqxgrid").jqxGrid('clearfilters');
	 	var filtergroup = new $.jqx.filter();
	 	var filter_or_operator = 1;
	 	var filtervalue = 'Vigente';
	 	var filtercondition = 'contains';
	 	var filter = filtergroup.createfilter('stringfilter', filtervalue, filtercondition);
	 	filtergroup.addfilter(filter_or_operator, filter);
	 	// return filtergroup;
	 	$("#jqxgrid").jqxGrid('addfilter', 'estado_text', filtergroup);
              // apply the filters.
        $("#jqxgrid").jqxGrid('applyfilters');
	 	}


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
			showfilterrow: true,
			filterable: true,
			autorowheight: true,
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
			{ text: 'Responsable', datafield: 'responsable', filtertype: 'input',width: '17%' },
			{ text: 'Razón Social', datafield: 'razon_social', filtertype: 'input',width: '17%' },
			{ text: 'Nro Contrato', datafield: 'contrato', filtertype: 'input',width: '10%' },
			{ text: 'Descripción', datafield: 'descripcion',filtertype: 'input', width: '20%' },
			{ text: 'Fecha Contrato', datafield: 'fecha_contrato', filtertype: 'range', width: '10%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Dias Tolerancia', datafield: 'dias_tolerancia', filtertype: 'input',width: '8%' },
			{ text: '% Mora', datafield: 'porcentaje_mora', filtertype: 'input',width: '8%' },
			{ text: 'Estado', datafield: 'estado_text', filtertype: 'input',width: '9%' },
			{ text: 'Nro Productos', datafield: 'num_productos', filtertype: 'input',width: '5%' },
			{ text: 'Tipo Pago', datafield: 'tipo_pago', filtertype: 'input',width: '10%' },
			{ text: 'Tipo Cobro Mora', datafield: 'tipo_cobro_mora', filtertype: 'input',width: '10%' }			
			],
		// groups: ['razon_social']
	});


/*	Segunda Grilla*/
var dataFields = [
{ name: 'id',type: 'number'},
			{ name: 'contrato_id',type: 'number'},
			{ name: 'razon_social',type: 'string'},
			{ name: 'nit',type: 'string'},
			{ name: 'grupo',type: 'string'},
			{ name: 'linea',type: 'string'},
			{ name: 'estacion',type: 'string'},
			{ name: 'producto',type: 'string'},
			{ name: 'contrato',type: 'string'},
			{ name: 'fecha_contrato',type:'date'},
			{ name: 'fecha_inicio',type:'date'},
			{ name: 'fecha_fin',type:'date'},
			{ name: 'total',type: 'number'},
			{ name: 'deposito',type:'number'},
			{ name: 'cobrar',type:'number'},
			{ name: 'mora',type: 'number'},
			{ name: 'estado',type: 'string'},
];

var sourceSeg =
{
	datafields: dataFields,
	datatype: "json",
	url: '/planpagos/list/',
	async: false
};

var dataAdapter = new $.jqx.dataAdapter(sourceSeg);
dataAdapter.dataBind();

$("#jqxgrid").on('rowselect', function (event) {
	$("#productos_alquilados").text(event.args.row.razon_social);
	var id = event.args.row.id;
	var records = new Array();
	var length = dataAdapter.records.length;
	for (var i = 0; i < length; i++) {
		var record = dataAdapter.records[i];
		if (record.contrato_id == id) {
			records[records.length] = record;
		}
	}

	var dataSource = {
		datafields: dataFields,
		localdata: records
	}
	var adapter = new $.jqx.dataAdapter(dataSource);
    $("#jqxgrid_productos").jqxGrid({ source: adapter });
});

	var tooltiprenderer = function (element) {
                $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
        };

		$("#jqxgrid_productos").jqxGrid({

			width: '100%',
			height: '200',
            source: dataAdapter,                
            sortable: true,
            altRows: true,
            columnsresize: true,
            theme: 'custom',
            // showstatusbar: true,
            showfilterrow: true,
            filterable: true,
            autorowheight: true,
            pageable: true,
            pagerMode: 'advanced',
            // groupable: true,
			columns: [
			{
				text: '#', sortable: false, filterable: false, editable: false,
				groupable: false, draggable: false, resizable: false,
				datafield: '', columntype: 'number', width: '3%',
				cellsrenderer: function (row, column, value) {
					return "<div style='margin:4px;'>" + (value + 1) + "</div>";
				}
			},
			{ text: 'Grupo', datafield: 'grupo', filtertype: 'checkedlist',width: '7%', rendered: tooltiprenderer },
			{ text: 'Linea', datafield: 'linea', filtertype: 'checkedlist',width: '10%' },
			{ text: 'Estación', datafield: 'estacion', filtertype: 'checkedlist',width: '10%' },
			// { text: 'Cliente / Razón Social', datafield: 'razon_social', filtertype: 'input',width: '10%' },
			// { text: 'Contrato', datafield: 'contrato', filtertype: 'input',width: '5%' },
			// { text: 'Fecha Contrato ', datafield: 'fecha_contrato', filtertype: 'range', width: '7%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Producto', datafield: 'producto', filtertype: 'input',width: '10%' },
			{ text: 'Fecha Inicio', datafield: 'fecha_inicio', filtertype: 'range', width: '8%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Fecha Final', datafield: 'fecha_fin', filtertype: 'range', width: '8%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Total Bs.', datafield: 'total', filtertype: 'number', width: '9%',cellsformat: "c2", cellsalign: 'right'},
	        { text: 'Deposito Bs.', datafield: 'deposito', filtertype: 'number', width: '9%',cellsformat: "c2", cellsalign: 'right'},
			{ text: 'Por Cobrar Bs.', datafield: 'cobrar', filtertype: 'number',width: '9%',cellsformat: "c2", cellsalign: 'right' },
 			{ text: 'Mora Bs.', datafield: 'mora', filtertype: 'number', width: '9%',cellsformat: "c2", cellsalign: 'right'},
 			{ text: 'Estado', datafield: 'estado', filtertype: 'input',width: '8%' },
			],
			// groups: ['razon_social','contrato']
		});

			var localizationobj = {};
            localizationobj.currencysymbol = "Bs ";
            $("#jqxgrid_productos").jqxGrid('localizestrings', localizationobj);
}

/* ************************************************************* */	


/*
Crear nuevo contrato
 */
 $("#crear_contrato").click(function(){
 		$("#titulo_contrato").text("Crear Nuevo Contrato");
 		$("#id").val('');
 		$('#myModal_contrato').modal('show');
 });

 $("#cliente_id").change(function(){
 	// alert($(this).val());
 	if($(this).val()>0){
 		var v=$.ajax({
 			url:'/clientes/getcliente/',
 			type:'POST',
 			datatype: 'json',
 			data:{id:$(this).val()},
 			success: function(data) { 
 				var obj = jQuery.parseJSON(data);
 				$("#nit").val(obj.nit);
 				$("#rl").val(obj.representante_legal);
 				$("#solicitud_id").html(obj.opciones);
                     },
            error: function() { alert('Se ha producido un error Inesperado'); 
                  }

              });
 	}
 });

 /*
 Editar Contrato Creado
  */
$("#edit_contrato").click(function(){
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		if (dataRecord.estado==1) {
 			$("#contrato_id").val(dataRecord.id);
 			$("#titulo_contrato").text("Editar Contrato");
 			$("#rs").val(dataRecord.razon_social);
 			$("#rl").val(dataRecord.representante_legal);
 			$("#contrato").val(dataRecord.contrato);
 			$("#descripcion").val(dataRecord.descripcion);
 			var fc = $.jqx.dataFormat.formatdate(dataRecord.fecha_contrato, 'dd-MM-yyyy');
 			$("#fecha_contrato").val(fc);
 			$("#cliente_id").val(dataRecord.cliente_id);
 			$('#cliente_id').trigger("chosen:updated");
 			$("#nit").val(dataRecord.nit);
 			$("#responsable_id").val(dataRecord.responsable_id);
 			$("#tipo_pago_"+dataRecord.tipo_pago).prop("checked", true);
 			$("#tipo_cobro_mora_"+dataRecord.tipo_pago).prop("checked", true);
 			$('#myModal_contrato').modal('show');
 		}else{
 			bootbox.alert("<strong>¡Mensaje!</strong> No puede editar contrato por que ha finalizado.");		
 		}
 		
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar contrato.");
 	}
});


/*
Ver Check List
 */
$("#ver_checklist").click(function(){
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
	// alert(rowindex);
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		var url = "/checklists/index/"+dataRecord.id;    
		$(location).attr('href',url);	
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro.");
 	}
});


/*
Ver Productod del Contrato
 */
$("#ver_productos").click(function(){
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		var url = "/contratos/crear/"+dataRecord.id;    
		$(location).attr('href',url);	
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro.");
 	}
});

/*
Eliminar Contrato
 */
$("#delete_contrato").click(function(){
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		if (dataRecord.num_productos==0 && dataRecord.estado==1) {
 			bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el registro.", function(result) {
                if (result == true) {
                    var v = $.ajax({
                        url: '/contratos/deletecontrato/',
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
 		}else{
			bootbox.alert("<strong>¡Mensaje!</strong> No puede eliminar el contrato por que tiene productos agregados o ha finalizado el contrato."); 			
 		}
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para eliminar.");
 	}
});

/*
guardar 
 */
$("#testForm_contrato").submit(function() {
	var tipo_pago = $('input:radio[name=tipo_pago]:checked').val();
	var tipo_cobro_mora = $('input:radio[name=tipo_cobro_mora]:checked').val()
	var v=$.ajax({
            	url:'/contratos/savecontrato/',
            	type:'POST',
            	datatype: 'json',
            	data:{contrato_id:$("#contrato_id").val(),solicitud_id:$("#solicitud_id").val(),cliente_id:$("#cliente_id").val(),contrato:$("#contrato").val(),fecha_contrato:$("#fecha_contrato").val(),arrendador:$("#arrendador").val(),arrendador_rep_legal:$("#arrendador_rep_legal").val(),arrendador_cargo:$("#arrendador_cargo").val(),descripcion:$("#descripcion").val(),dias_tolerancia:$("#dias_tolerancia").val(),porcentaje_mora:$("#porcentaje_mora").val(),responsable_id:$("#responsable_id").val(),tipo_pago:tipo_pago,tipo_cobro_mora:tipo_cobro_mora},
				success: function(data) { 
						cargar();
						$("#divMsjeExito").show();
                    	$("#divMsjeExito").addClass('alert alert-info alert-dismissable');
                    	$("#aMsjeExito").html(data); 
					
				}, //mostramos el error
			error: function() { alert('Se ha producido un error Inesperado'); }
			});
            $('#myModal_contrato').modal('hide');
            return false; // ajax used, block the normal submit
	});

$("#fecha_contrato").datepicker({
	autoclose:true,
});

/*
Finalizar contrato
 */
$("#finalizar_contrato").click(function(){
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		document.location.href = "/contratos/finalizar/"+dataRecord.id;
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para eliminar.");
 	}
});

})