$(document).ready(function (){


$("#file-1").fileinput({
		//showUpload: false,
		// showCaption: false,
		language: 'es',
		allowedFileExtensions : ['jpg','jpeg', 'png','gif','xlsx','docx','pdf'],
		maxFileSize: 1000,
		browseClass: "btn btn-primary btn-sm",
		// fileType: "any",
  //       previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
	});

	cargar();	
	function cargar(){	
		var source =
		{
			datatype: "json",
			updaterow: function (rowid, rowdata, commit) {
                    var v=$.ajax({
                    	url:'/checklists/savecumple/',
                    	type:'POST',
                    	datatype: 'json',
                    	data:{parametro_id:rowdata.id,contrato_id:$("#contrato_id").val(),tipo_empresa:rowdata.tipo_empresa_text,parametro:rowdata.parametro,cumple:rowdata.cumple},
                    	success: function(data) { 
                    	$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
				}, //mostramos el error
				error: function() { alert('Se ha producido un error Inesperado'); }
			});
                    commit(true);
                },
			datafields: [
			{ name: 'id',type: 'number'},
			{ name: 'parametro',type: 'string'},
			{ name: 'abreviado',type: 'string'},
			{ name: 'tipo_empresa',type: 'number'},
			{ name: 'tipo_empresa_text',type: 'string'},
			{ name: 'obligatorio',type: 'number'},
			{ name: 'obligatorio_text',type: 'string'},
			{ name: 'escaner',type: 'number'},
			{ name: 'escaner_text',type: 'string'},
			{ name: 'clase',type: 'string'},
			{ name: 'cumple',type: 'number'},
			{ name: 'accion',type: 'string'},
			{ name: 'archivo',type: 'string'},
			{ name: 'parametro_id',type: 'number'},
			],
			url: '/checklists/list/'+$("#contrato_id").val(),
			cache: false
		};
		var dataAdapter = new $.jqx.dataAdapter(source);

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
			// groupable: true,
			editable: true,
			columns: [
			// {
			// 	text: '#', sortable: false, filterable: false, editable: false,
			// 	groupable: false, draggable: false, resizable: false,
			// 	datafield: '', columntype: 'number', width: '3%',
			// 	cellsrenderer: function (row, column, value) {
			// 		return "<div style='margin:4px;'>" + (value + 1) + "</div>";
			// 	}
			// },
			{ text: 'Tipo Empresa', datafield: 'tipo_empresa_text', filtertype: 'input',width: '35%' ,editable: false},
			{ text: 'Parametro', datafield: 'parametro', filtertype: 'input',width: '40%',editable: false},
			{ text: 'Cumple', datafield: 'cumple', columntype: 'checkbox', width: '10%' },
			{ text: 'Archivo Escaneado', datafield: 'archivo', filtertype: 'input',width: '10%' ,editable: false},
			{ text: '', datafield: 'accion', filtertype: 'input',width: '5%' ,editable: false},
			],
			groups: ['tipo_empresa_text']
		});

	 
}
// $("#expandall").jqxButton({ theme: theme });
// $("#expandall").click(function () {
// 	alert("hoal");
//                 //$("#jqxgrid").jqxGrid('expandallgroups');
// });

$("#expandall").click(function(){
	$("#jqxgrid").jqxGrid('expandallgroups');
});
// $("#tipo_empresa_text").jqxCheckBox({  checked: false });


/*
adicionar 
*/
$("#migrar").click(function(){
	$('#myModal_migrar').modal('show');
});

/*
Save Migrar 
 */
$("#testForm_migrar").submit(function() {
	var contrato_id_migrar = $('input:radio[name=contrato_id_migrar]:checked').val();
	var v=$.ajax({
            	url:'/checklists/savemigrar/',
            	type:'POST',
            	datatype: 'json',
            	data:{contrato_id_migrar:contrato_id_migrar,contrato_id:$("#contrato_id").val()},
				success: function(data) { cargar(); 
					$("#divMsjeExito").show();
                    $("#divMsjeExito").addClass('alert alert-info alert-dismissable');
                    $("#aMsjeExito").html(data); 
                    cargar();
				}, //mostramos el error
			error: function() { alert('Se ha producido un error Inesperado'); }
			}); //   

	 		$('#myModal_migrar').modal('hide');
            return false; // ajax used, block the normal submit
});

/*
Editar Archivos
 */
$("#edit").click(function() {
 	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
 	if (rowindex > -1)
 	{
 		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
 		// alert("Parametro_id:"+dataRecord.parametro_id+ " ==> Contrato_id:"+$("#contrato_id").val());
		lista_archivos(dataRecord.parametro_id,$("#contrato_id").val(),dataRecord.parametro); 		 
 		$('#myModal_deletearchivo').modal('show');

 	}
 	else
 	{
 		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
 	}

 });


function lista_archivos(parametro,contrato,parametro_text){
  
var v=$.ajax({
 			url:'/checklists/edit/',
 			type:'POST',
 			datatype: 'json',
 			complete:function(){
 				$(".delete_archivo").click(function(){
 					var parametro_x = $(this).attr("parametro");
 					var archivo_x = $(this).attr("archivo");
 					var contrato_x = $("#contrato_id").val();
 					bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el archivo. ", function(result) {
 						if (result==true) {
 							var v=$.ajax({
 								url:'/checklists/deletearchivo/',
 								type:'POST',
 								datatype: 'json',
 								data:{parametro_id:parametro_x,archivo_id:archivo_x,contrato_id:contrato_x},
 								success: function(data) { alert(data);
 									lista_archivos(parametro,contrato,parametro_text);
 									$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                        }, //mostramos el error
                        error: function() { alert('Se ha producido un error Inesperado'); }
                    });
 						}
 					});
 				});
 				
 			},
 			data:{parametro_id:parametro,contrato_id:contrato,parametro_text},
 			success: function(data) { 
 				$("#li_da").html(data);
 				$("#titulo_deletearchivo").text(parametro_text);	 
				}, //mostramos el error
				error: function() { alert('Se ha producido un error Inesperado'); }
		}); //   
}


// /*
// Eliminar
//  */
// $("#delete").click(function() {
//  	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
//  	if (rowindex > -1)
//  	{
//  		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
//  		bootbox.confirm("<strong>¡Mensaje!</strong> Esta seguro de eliminar el registro.", function(result) {
//                 if (result == true) {
//                     var v = $.ajax({
//                         url: '/parametroschecklists/delete/',
//                         type: 'POST',
//                         datatype: 'json',
//                         data: {id: dataRecord.id},
//                         success: function(data) {
//                             cargar(); //alert('Guardado Correctamente'); 
//                             $("#divMsjeExito").show();
//                     		$("#divMsjeExito").addClass('alert alert-warning alert-dismissable');
//                     		$("#aMsjeExito").html(data); 
//                         }, //mostramos el error
//                         error: function() {
//                             alert('Se ha producido un error Inesperado');
//                         }
//                     });
//                 }
//             });
//  	}
//  	else
//  	{
//  		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para eliminar.");
//  	}

//  });

// /*
// guardar 
//  */
// $("#testForm").submit(function() {
// 	var v=$.ajax({
//             	url:'/parametroschecklists/save/',
//             	type:'POST',
//             	datatype: 'json',
//             	data:{id:$("#id").val(),tipo_empresa:$("#tipo_empresa").val(),parametro:$("#parametro").val(),obligatorio:$("#obligatorio").val(),escaner:$("#escaner").val()},
// 				success: function(data) { cargar(); 
// 					$("#divMsjeExito").show();
//                     $("#divMsjeExito").addClass('alert alert-info alert-dismissable');
//                     $("#aMsjeExito").html(data); 
// 				}, //mostramos el error
// 			error: function() { alert('Se ha producido un error Inesperado'); }
// 			}); //             $('#myModal').modal('hide');
//             return false; // ajax used, block the normal submit
// });

})

var add_archivo = function (row) {
	var rowindex = $('#jqxgrid').jqxGrid('getselectedrowindex');
	if (rowindex > -1) {
		var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', rowindex);
		$("#parametro_id").val(dataRecord.parametro_id);
		// $("#tipo").val(dataRecord.tipo);
		$('#myModal').modal('show');
	
	}else{
		bootbox.alert("<strong>¡Mensaje!</strong> Seleccionar un registro para editar.");
	}
};
