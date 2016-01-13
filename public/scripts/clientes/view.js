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
			{ name: 'fecha_contrato', type: 'date' },
			{ name: 'descripcion', type: 'string' },
			{ name: 'num_productos', type: 'number' },
			{ name: 'dias_tolerancia', type: 'number' },
			{ name: 'porcentaje_mora', type: 'number' },
			{ name: 'responsable', type: 'string' },
			{ name: 'responsable_id', type: 'number' },
			{ name: 'estado', type: 'string' },
			],
			url: '/clientes/listcontratosclientes/'+$("#cliente_id").val(),
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
		var cellclass = function (row, columnfield, value) {
			if (value == 'Activo') {
				return 'green';
			}else{
				return 'red';
			}

		};
		$("#jqxgrid").jqxGrid({
			width: '100%',
			// height: 300,
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
			{ text: 'Nro Contrato', datafield: 'contrato', filtertype: 'input',width: '10%'},
			{ text: 'Descripción', datafield: 'descripcion',filtertype: 'input', width: '40%' },
			{ text: 'Fecha Contrato', datafield: 'fecha_contrato', filtertype: 'range', width: '10%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			// { text: 'Dias Tolerancia', datafield: 'dias_tolerancia', filtertype: 'input',width: '10%' },
			// { text: '% Mora', datafield: 'porcentaje_mora', filtertype: 'input',width: '10%' },
			{ text: 'Nro Productos', datafield: 'num_productos', filtertype: 'input',width: '10%' },
			{ text: 'Estado', datafield: 'estado', filtertype: 'input',width: '10%' }
			]
		});



}

/*
Grid Productos
 */

productos();	
	function productos(){	
		var source =
		{
			datatype: "json",
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'razon_social',type: 'string'},
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
			],
			url: '/planpagos/listproductosclientes/'+$("#cliente_id").val(),
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);
		var tooltiprenderer = function (element) {
                $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
        };
        var totalcolumnrenderer = function (row, column, cellvalue) {
                var cellvalue = $.jqx.dataFormat.formatnumber(cellvalue, 'c2');
                return cellvalue;
            };
		$("#jqxgrid_producto").jqxGrid({
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
            statusbarheight:25,
            showaggregates: true,
			columns: [
			{
				text: '#', sortable: false, filterable: false, editable: false,
				groupable: false, draggable: false, resizable: false,
				datafield: '', columntype: 'number', width: '2%',
				cellsrenderer: function (row, column, value) {
					return "<div style='margin:4px;'>" + (value + 1) + "</div>";
				}
			},
			{ text: 'Grupo', datafield: 'grupo', filtertype: 'checkedlist',width: '10%'},
			{ text: 'Linea', datafield: 'linea', filtertype: 'checkedlist',width: '10%' },
			{ text: 'Estación', datafield: 'estacion', filtertype: 'checkedlist',width: '15%' },
			// { text: 'Cliente / Razón Social', datafield: 'razon_social', filtertype: 'input',width: '10%' },
			{ text: 'Contrato', datafield: 'contrato', filtertype: 'input',width: '8%' },
			// { text: 'Fecha Contrato ', datafield: 'fecha_contrato', filtertype: 'range', width: '7%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Producto', datafield: 'producto', filtertype: 'input',width: '15%' },
			// { text: 'Fecha Inicio', datafield: 'fecha_inicio', filtertype: 'range', width: '7%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			// { text: 'Fecha Final', datafield: 'fecha_fin', filtertype: 'range', width: '7%', cellsalign: 'center', cellsformat: 'dd-MM-yyyy', align:'center'},
			{ text: 'Total Bs.', datafield: 'total', filtertype: 'number', width: '10%',cellsformat: "c2", cellsalign: 'right',aggregates: ['sum']},
	        { text: 'Deposito Bs.', datafield: 'deposito', filtertype: 'number', width: '10%',cellsformat: "c2", cellsalign: 'right',aggregates: ['sum']},
			{ text: 'Por Cobrar Bs.', datafield: 'cobrar', filtertype: 'number',width: '10%',cellsformat: "c2", cellsalign: 'right',aggregates: ['sum'] },
 			{ text: 'Mora Bs.', datafield: 'mora', filtertype: 'number', width: '10%',cellsformat: "c2", cellsalign: 'right',aggregates: ['sum']
            },
			]
			//groups: ['grupo']
		});

 		//$("#jqxgrid").jqxGrid('expandgroup',4);
}


/*
Ver Productod del Contrato
*/
$("#ver_productos").click(function(){
	var rowindex = $('#jqxgrid_contratos').jqxGrid('getselectedrowindex');
	if (rowindex > -1)
	{
		var dataRecord = $("#jqxgrid_contratos").jqxGrid('getrowdata', rowindex);
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
	var rowindex = $('#jqxgrid_contratos').jqxGrid('getselectedrowindex');
	if (rowindex > -1)
	{
		var dataRecord = $("#jqxgrid_contratos").jqxGrid('getrowdata', rowindex);
		if (dataRecord.num_productos==0) {
			bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el registro.", function(result) {
				if (result == true) {
					var v = $.ajax({
						url: '/clientes/deletecontrato/',
						type: 'POST',
						datatype: 'json',
						data: {id: dataRecord.id},
						success: function(data) {
                            cargar(); //alert('Guardado Correctamente'); 
                            $("#divMsjeExito2").show();
                            $("#divMsjeExito2").addClass('alert alert-warning alert-dismissable');
                            $("#aMsjeExito2").html(data); 
                        }, //mostramos el error
                        error: function() {
                        	alert('Se ha producido un error Inesperado');
                        }
                    });
				}
			});
		}else{
			bootbox.alert("<strong>¡Mensaje!</strong> No puede eliminar el contrato por que tiene productos agregados."); 			
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
	var v=$.ajax({
		url:'/clientes/savecontrato/',
		type:'POST',
		datatype: 'json',
		data:{contrato_id:$("#contrato_id").val(),cliente_id:$("#cliente_id").val(),contrato:$("#contrato").val(),fecha_contrato:$("#fecha_contrato").val(),arrendador:$("#arrendador").val(),arrendador_rep_legal:$("#arrendador_rep_legal").val(),arrendador_cargo:$("#arrendador_cargo").val(),descripcion:$("#descripcion").val(),dias_tolerancia:$("#dias_tolerancia").val(),porcentaje_mora:$("#porcentaje_mora").val(),responsable_id:$("#responsable_id").val()},
		success: function(data) { 
			if ($("#contrato_id").val()>0) {
				cargar();
				$("#divMsjeExito").show();
				$("#divMsjeExito").addClass('alert alert-info alert-dismissable');
				$("#aMsjeExito").html('Guardado Correctamente'); 
			}else{
				var url = "/contratos/crear/"+data;    
				$(location).attr('href',url);	
			}


				}, //mostramos el error
				error: function() { alert('Se ha producido un error Inesperado'); }
			});
	$('#myModal_contrato').modal('hide');
            return false; // ajax used, block the normal submit
        });

$("#archivo").fileinput({
		// showUpload: false,
		//showCaption: false,
		language: 'es',
		allowedFileExtensions : ['jpg','jpeg', 'png','gif'],
		maxFileSize: 1000,
		browseClass: "btn btn-primary btn-sm",
		//fileType: "any",
        //previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
	});

})