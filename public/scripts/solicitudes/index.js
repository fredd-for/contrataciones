$(document).ready(function (){
	cargar();
	function cargar(){
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id', type: 'number' },
			{ name: 'nro_solicitud', type: 'string' },
			{ name: 'fecha_envio_solicitud', type: 'date' },
			{ name: 'fecha_recepcion_solicitud', type: 'date' },
			{ name: 'respuesta', type: 'string' },
			{ name: 'fecha_envio_resp', type: 'date' },
			{ name: 'fecha_recepcion_resp', type: 'date' },
			{ name: 'descripcion_resp', type: 'string' },
			{ name: 'fecha_recepcion_solicitud', type: 'date' },
			{ name: 'descripcion_resp', type: 'string' },
			{ name: 'cliente_id', type: 'number' },
			{ name: 'razon_social', type: 'string' },
			{ name: 'responsable_id', type: 'number' },
			{ name: 'responsable', type: 'string' },
			{ name: 'representante', type: 'string' },
			{ name: 'cargo_representante', type: 'string' },
			{ name: 'descripcion_solicitud', type: 'string' },
			{ name: 'num_productos', type: 'number' },
			{ name: 'estado', type: 'string' },
			{ name: 'accion', type: 'string' },
			],
			url: '/solicitudes/list',
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
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
			{ text: 'Responsable', datafield: 'responsable', filtertype: 'input',width: '14%' },
			{ text: 'Razón Social', datafield: 'razon_social', filtertype: 'input',width: '15%' },
			{ text: 'Nro Solicitud', datafield: 'nro_solicitud', filtertype: 'input',width: '8%' },
			{ text: 'Representante', datafield: 'representante',filtertype: 'input', width: '10%' },
			{ text: 'Cargo Representante', datafield: 'cargo_representante',filtertype: 'input', width: '15%' },
			{ text: 'Fecha Envio', datafield: 'fecha_envio_solicitud', filtertype: 'range', width: '10%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Fecha Recepeción', datafield: 'fecha_recepcion_solicitud', filtertype: 'range', width: '10%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Estado', datafield: 'estado',filtertype: 'input', width: '5%' },
			{ text: '', datafield: 'accion', filtertype: 'input',width: '10%',cellsalign: 'center',align:'center'},
			],
		// groups: ['razon_social']
	});


/*	Segunda Grilla*/
var dataFields = [
{ name: 'id',type: 'number'},
{ name: 'solicitud_id',type: 'number'},
{ name: 'producto_id',type: 'number'},
{ name: 'grupo',type: 'string'},
{ name: 'linea',type: 'string'},
{ name: 'estacion',type: 'string'},
{ name: 'codigo',type: 'string'},
{ name: 'producto',type: 'string'},
{ name: 'precio_unitario',type: 'number'},
{ name: 'tiempo',type: 'string'},
{ name: 'cantidad',type: 'number'},
{ name: 'num_productos',type: 'number'},

];

var sourceSeg =
{
	datafields: dataFields,
	datatype: "json",
	url: '/solicitudesproductos/list/',
	async: false
};

var dataAdapter = new $.jqx.dataAdapter(sourceSeg);
dataAdapter.dataBind();

$("#jqxgrid").on('rowselect', function (event) {
	$("#productos_solicitados").text(event.args.row.razon_social);
	var id = event.args.row.id;
	var records = new Array();
	var length = dataAdapter.records.length;
	for (var i = 0; i < length; i++) {
		var record = dataAdapter.records[i];
		if (record.solicitud_id == id) {
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
	showfilterrow: true,
	filterable: true,
	autorowheight: true,
	pageable: true,
	pagerMode: 'advanced',
	columns: [
	{
		text: '#', sortable: false, filterable: false, editable: false,
		groupable: false, draggable: false, resizable: false,
		datafield: '', columntype: 'number', width: '3%',
		cellsrenderer: function (row, column, value) {
			return "<div style='margin:4px;'>" + (value + 1) + "</div>";
		}
	},
	{ text: 'Grupo', datafield: 'grupo', filtertype: 'checkedlist',width: '10%', rendered: tooltiprenderer },
	{ text: 'Linea', datafield: 'linea', filtertype: 'checkedlist',width: '10%' },
	{ text: 'Estación', datafield: 'estacion', filtertype: 'checkedlist',width: '15%' },
	{ text: 'Codigo', datafield: 'codigo', filtertype: 'input',width: '10%'},
	{ text: 'Producto', datafield: 'producto', filtertype: 'input',width: '22%'},
	{ text: 'Precio Unitario Bs.', datafield: 'precio_unitario', filtertype: 'number', width: '10%',cellsformat: "c2", cellsalign: 'right'},
	{ text: 'Cantidad', datafield: 'cantidad', filtertype: 'input',width: '10%' },
	{ text: 'Tiempo', datafield: 'tiempo', filtertype: 'input',width: '10%' },
	],
});

var localizationobj = {};
localizationobj.currencysymbol = "Bs ";
$("#jqxgrid_productos").jqxGrid('localizestrings', localizationobj);

}

/* ************************************************************* */	


/*
Crear nuevo solicitud
*/
$("#add").click(function(){
	$("#titulo").text("Crear Nueva Solicitud");
	$("#id").val('');
	$('#myModal').modal('show');
});

/*
 Editar Contrato Creado
 */
 $("#edit").click(function(){
 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);

 		$("#id").val(dataRecord.id);
 		$("#titulo").text("Editar Solicitud");
 		$("#nro_solicitud").val(dataRecord.nro_solicitud);
 		$("#representante").val(dataRecord.representante);
 		$("#cargo_representante").val(dataRecord.cargo_representante);
 		$("#descripcion_solicitud").val(dataRecord.descripcion_solicitud);
 		var fe = $.jqx.dataFormat.formatdate(dataRecord.fecha_envio_solicitud, 'dd-MM-yyyy');
 		var fr = $.jqx.dataFormat.formatdate(dataRecord.fecha_recepcion_solicitud, 'dd-MM-yyyy');
 		$("#fecha_envio_solicitud").val(fe);
 		$("#fecha_recepcion_solicitud").val(fr);
 		$("#cliente_id").val(dataRecord.cliente_id);
 		$('#cliente_id').trigger("chosen:updated");
 		$("#responsable_id").val(dataRecord.responsable_id);
 		$('#myModal').modal('show');
 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar solicitud|.");
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
 		var url = "/solicitudesproductos/crear/"+dataRecord.id;    
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
$("#delete").click(function(){
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
	if (rowindex > -1)
	{
		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		// alert(dataRecord.num_productos);
 		if (dataRecord.num_productos==0) {
 			bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el registro.", function(result) {
 				if (result == true) {
 					var v = $.ajax({
 						url: '/solicitudes/delete/',
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
 			bootbox.alert("<strong>¡Mensaje!</strong> No puede eliminar la solicitud por que tiene productos agregados."); 			
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
$("#testForm").submit(function() {
	var v=$.ajax({
		url:'/solicitudes/save/',
		type:'POST',
		datatype: 'json',
		data:{id:$("#id").val(),nro_solicitud:$("#nro_solicitud").val(),representante:$("#representante").val(),cargo_representante:$("#cargo_representante").val(),descripcion_solicitud:$("#descripcion_solicitud").val(),fecha_envio_solicitud:$("#fecha_envio_solicitud").val(),fecha_recepcion_solicitud:$("#fecha_recepcion_solicitud").val(),cliente_id:$("#cliente_id").val(),responsable_id:$("#responsable_id").val()},
		success: function(data) { 
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

/*
Guardar Respuesta
 */
$("#testForm_respuesta").submit(function() {
	var v=$.ajax({
		url:'/solicitudes/saverespuesta/',
		type:'POST',
		datatype: 'json',
		data:{id:$("#id").val(),fecha_envio_resp:$("#fecha_envio_resp").val(),fecha_recepcion_resp:$("#fecha_recepcion_resp").val(),descripcion_resp:$("#descripcion_resp").val(),estado:$("#estado").val(),respuesta:$( "#estado option:selected" ).text()},
		success: function(data) { 
			cargar();
			$("#divMsjeExito").show();
			$("#divMsjeExito").addClass('alert alert-info alert-dismissable');
			$("#aMsjeExito").html(data); 
		},
		error: function() { alert('Se ha producido un error Inesperado'); }
	});
	$('#myModal_respuesta').modal('hide');
	return false;
});

/*
guardar informe
 */
$("#testForm_informe").submit(function() {
	var v=$.ajax({
            	url:'/informes/save/',
            	type:'POST',
            	datatype: 'json',
            	data:{id:0,solicitud_id:$("#solicitud_id").val(),nur:$("#nur").val()},
				success: function(data) { cargar(); 
					$("#divMsjeExito").show();
                    $("#divMsjeExito").addClass('alert alert-info alert-dismissable');
                    $("#aMsjeExito").html(data); 
				}, //mostramos el error
			error: function() { alert('Se ha producido un error Inesperado'); }
			});
            $('#myModal_informe').modal('hide');
            return false; // ajax used, block the normal submit
});

/*
auto complete
 */    
    $.fn.delayPasteKeyUp = function(fn, ms)
    {
        var timer = 0;
        $(this).on("keyup paste", function()
        {
            clearTimeout(timer);
            timer = setTimeout(fn, ms);
        });
    };
 
    $("input[name=nur]").delayPasteKeyUp(function()
    {
        $.ajax({
        	type: "POST",
            // url: "http://localhost/autocompletado/app/instancias/autocomplete.php",
            url: "/solicitudes/documentos",
            data: "autocomplete="+$("input[name=nur]").val(),
            success: function(data)
            {
            	$("#busqueda").html(data);
            }
        });
    }, 500);

	// $(document).on("click", "a", function()
	// {
	// 	$("a").removeClass("active");
	// 	$(this).addClass("active");
	// })    


// $("#fecha_envio_solicitud,#fecha_recepcion_solicitud, #fecha_envio_resp,#fecha_recepcion_resp").datepicker({
// 	autoclose:true,
// });
$(".input-daterange").datepicker({weekStart:1});
$(".input-datepicker-close").datepicker({weekStart:1}).on("changeDate",function(){$(this).datepicker("hide")})

})


var info = function (id, nur) {
	$("#nur").val(nur);
	$('.list-group').hide();
	// alert("ID: " + id + " Nombre: " + nur);	
};

var informe = function (row) {
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
	if (rowindex > -1) {
		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
		$("#solicitud_id").val(dataRecord.id);
		// $("#razon_social_text").text(dataRecord.razon_social);
		// $("#nro_solicitud_text").text(dataRecord.nro_solicitud);
		$('#myModal_informe').modal('show');
	}else{
		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
	}
};

var respuesta = function (row) {
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
	if (rowindex > -1) {
		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
		$("#id").val(dataRecord.id);
		$("#razon_social_text").text(dataRecord.razon_social);
		$("#nro_solicitud_text").text(dataRecord.nro_solicitud);
		$('#myModal_respuesta').modal('show');
	}else{
		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
	}
};