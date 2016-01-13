$(document).ready(function (){
		$("#buscar").on("click",function(){
			var text="";
			var tag=$("#b").val();
			$.getJSON("http://localhost/estaciones.json?estacion="+tag,function (datos) {
				$.each(datos.estaciones,function (i,item) {
					text="<div>";
					text="Linea:"+item.linea+"Estacion:"+item.estacion;
					text="</div>";
				});
			});
		})
		
	})