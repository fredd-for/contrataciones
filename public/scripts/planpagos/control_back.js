
$(document).ready(function (){
/*
Adicionar Derecho de llave
 */
$("#add_derechollave").click(function() {
	$('#titulo_derechollave').text('Adicionar Derecho de LLave');
	$('#myModal_derechollave').modal('show');
});

$("#edit_derechollave").click(function() {
	$('#titulo_derechollave').text('Editar Derecho de LLave');
	$("#garantia_id").val($(this).attr('garantia_id'));
	$("#fecha_deposito_derechollave").val($(this).attr('fecha_deposito'));
	$("#nro_deposito_derechollave").val($(this).attr('nro_deposito'));
	$("#monto_deposito_derechollave").val($(this).attr('monto_deposito'));
	$('#myModal_derechollave').modal('show');
});

$("#testForm_derechollave").submit(function(){
	var v=$.ajax({
		url:'/planpagos/savederechollave/',
		type:'POST',
		datatype: 'json',
		data:{garantia_id:$("#garantia_id").val(),contratoproducto_id:$("#contratoproducto_id").val(),fecha_deposito:$("#fecha_deposito_derechollave").val(),nro_deposito:$("#nro_deposito_derechollave").val(),monto_deposito:$("#monto_deposito_derechollave").val()},
		complete:function(){
			$("#edit_derechollave").click(function() {
				$('#titulo_derechollave').text('Editar Derecho de LLave');
				$("#garantia_id").val($(this).attr('garantia_id'));
				$("#fecha_deposito_derechollave").val($(this).attr('fecha_deposito'));
				$("#nro_deposito_derechollave").val($(this).attr('nro_deposito'));
				$("#monto_deposito_derechollave").val($(this).attr('monto_deposito'));
				$('#myModal_derechollave').modal('show');
			});	
		},
		success: function(data) { 
			$("#html_derechollave").html(data); 
				}, //mostramos el error
				error: function() { alert('Se ha producido un error Inesperado'); }
			});
	$('#myModal_derechollave').modal('hide');
    return false; // ajax used, block the normal submit
});


/*
Adicionar Garantia
 */
$("#add_garantia").click(function() {
	$('#titulo_garantia').text('Adicionar Garantia');
	$('#myModal_garantia').modal('show');
});

$("#edit_garantia").click(function() {
	$('#titulo_garantia').text('Editar Garantia');
	$("#garantia_id").val($(this).attr('garantia_id'));
	$("#fecha_deposito_garantia").val($(this).attr('fecha_deposito'));
	$("#nro_deposito_garantia").val($(this).attr('nro_deposito'));
	$("#monto_deposito_garantia").val($(this).attr('monto_deposito'));

	$("#fecha_devolucion_garantia").val($(this).attr('fecha_devolucion'));
	$("#nro_devolucion_garantia").val($(this).attr('nro_devolucion'));
	$("#monto_devolucion_garantia").val($(this).attr('monto_devolucion'));

	$('#myModal_garantia').modal('show');
});

$("#testForm_garantia").submit(function(){
	var v=$.ajax({
		url:'/planpagos/savegarantia/',
		type:'POST',
		datatype: 'json',
		data:{garantia_id:$("#garantia_id").val(),contratoproducto_id:$("#contratoproducto_id").val(),fecha_deposito:$("#fecha_deposito_garantia").val(),nro_deposito:$("#nro_deposito_garantia").val(),monto_deposito:$("#monto_deposito_garantia").val(),fecha_devolucion:$("#fecha_devolucion_garantia").val(),nro_devolucion:$("#nro_devolucion_garantia").val(),monto_devolucion:$("#monto_devolucion_garantia").val()},
		complete:function(){
			$("#edit_garantia").click(function() {
				$('#titulo_garantia').text('Editar Garantia');
				$("#garantia_id").val($(this).attr('garantia_id'));
				$("#fecha_deposito_garantia").val($(this).attr('fecha_garantia'));
				$("#nro_deposito_garantia").val($(this).attr('nro_garantia'));
				$("#monto_deposito_garantia").val($(this).attr('monto_garantia'));

				$("#fecha_devolucion_garantia").val($(this).attr('fecha_devolucion'));
				$("#nro_devolucion_garantia").val($(this).attr('nro_devolucion'));
				$("#monto_devolucion_garantia").val($(this).attr('monto_devolucion'));

				$('#myModal_garantia').modal('show');
			});	
		},
		success: function(data) { 
			$("#html_garantia").html(data); 
				}, //mostramos el error
				error: function() { alert('Se ha producido un error Inesperado'); }
			});
	$('#myModal_garantia').modal('hide');
    return false; // ajax used, block the normal submit
});


/*
REgistro de deposito de pago
 */
$(".reg_deposito").click(function() {
	$("#planpago_id").val($(this).attr('planpago_id'));
	$("#fecha_deposito").val($(this).attr('fecha_deposito'));
	$("#nro_deposito").val($(this).attr('nro_deposito'));
	$("#monto_deposito").val($(this).attr('monto_deposito'));
	$('#titulo_deposito').text('Registrar Deposito');
	$('#myModal_deposito').modal('show');
});

$("#testForm_deposito").submit(function(){
	var v=$.ajax({
		url:'/planpagos/savedeposito/',
		type:'POST',
		datatype: 'json',
		data:{planpago_id:$("#planpago_id").val(),nro_deposito:$("#nro_deposito").val(),fecha_deposito:$("#fecha_deposito").val(),monto_deposito:$("#monto_deposito").val()},
		complete:function(){
			$(".reg_deposito").click(function() {
				$("#planpago_id").val($(this).attr('planpago_id'));
				$("#fecha_deposito").val($(this).attr('fecha_deposito'));
				$("#nro_deposito").val($(this).attr('nro_deposito'));
				$("#monto_deposito").val($(this).attr('monto_deposito'));
				$('#titulo_deposito').text('Registrar Deposito');
				$('#myModal_deposito').modal('show');
			});
		},
		success: function(data) { 
			$("#html"+$("#planpago_id").val()).html(data); 
				}, //mostramos el error
				error: function() { alert('Se ha producido un error Inesperado'); }
			});
	$('#myModal_deposito').modal('hide');
    return false; // ajax used, block the normal submit
});


$("#fecha_deposito, #fecha_deposito_derechollave, #fecha_deposito_garantia, #fecha_devolucion_garantia").datepicker({
	autoclose:true,
});

})