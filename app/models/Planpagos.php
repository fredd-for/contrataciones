<?php 
/**
* 
*/
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Planpagos extends \Phalcon\Mvc\Model
{
	private $_db;
	public function lista($cliente_id='')
	{
		$where ='';
		if ($cliente_id!='') {
			$where = ' AND cl.id = '.$cliente_id;
		}
		$sql = "SELECT cl.razon_social,cl.nit,c.cliente_id,c.contrato,c.fecha_contrato,c.descripcion,c.porcentaje_mora,p.producto,p.codigo,g.grupo,e.estacion,l.linea,cp.*,pa.valor_1,
		(SELECT SUM(ppd.monto_deposito)
			FROM planpagos pp,planpagodepositos ppd
			WHERE pp.contratoproducto_id = cp.id AND pp.baja_logica =1 AND pp.id = ppd.planpago_id AND ppd.baja_logica=1 AND ppd.tipo_deposito =1
			) as deposito,
(SELECT SUM(IF(pp.monto_reprogramado<=(SELECT SUM(monto_deposito) FROM planpagodepositos WHERE planpago_id =pp.id AND tipo_deposito=1 AND baja_logica = 1),pp.mora,
	(IF((DATEDIFF(CURDATE(),ADDDATE(pp.fecha_programado, INTERVAL c.dias_tolerancia DAY)))>0,cp.total/cp.nro_dias*c.porcentaje_mora*(DATEDIFF(CURDATE(),ADDDATE(pp.fecha_programado, INTERVAL c.dias_tolerancia DAY))),0))
	)
)
FROM planpagos pp
WHERE pp.contratoproducto_id =cp.id AND pp.baja_logica = 1 ) as mora

FROM contratos c
INNER JOIN clientes cl ON c.cliente_id = cl.id
INNER JOIN contratosproductos cp ON c.id = cp.contrato_id
INNER JOIN productos p ON p.id = cp.producto_id 
INNER JOIN grupos g ON p.grupo_id = g.id
INNER JOIN estaciones e ON p.estacion_id = e.id
INNER JOIN lineas l ON e.linea_id = l.id
INNER JOIN parametros pa ON cp.estado = pa.nivel AND pa.parametro='contratos_estados'
WHERE c.baja_logica =1 AND cp.baja_logica = 1 ".$where;
$this->_db = new Planpagos();
return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
}

	public function listadoplanpago($contratoproducto_id)
	{
		$sql="SELECT pp.id,pp.contratoproducto_id,pp.fecha_programado,pp.monto_programado,pp.monto_reprogramado,pp.diferencia,pp.mora,pp.dias_atraso,d.id as planpagodeposito_id,d.fecha_deposito,d.nro_deposito,d.monto_deposito,d.tipo_deposito
		FROM planpagos pp
		LEFT JOIN planpagodepositos d ON pp.id=d.planpago_id AND d.baja_logica = 1
		WHERE pp.contratoproducto_id = '$contratoproducto_id'
		ORDER BY pp.fecha_programado, d.fecha_deposito";
		$this->_db = new Planpagos();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));	
	}

	public function listacontrolpago($contratoproducto_id)
	{
		$sql="SELECT pp.*, 
		(SELECT SUM(monto_factura)
			FROM planpagofacturas
			WHERE planpago_id=pp.id and baja_logica = 1) as factura_total,
		(SELECT fecha_factura
			FROM planpagofacturas
			WHERE planpago_id=pp.id and baja_logica = 1 ORDER BY fecha_factura DESC LIMIT 1) as fecha_factura,
	(SELECT fecha_recepcion_cliente
			FROM planpagofacturas
				WHERE planpago_id=pp.id and baja_logica = 1 ORDER BY fecha_recepcion_cliente DESC LIMIT 1) as fecha_recepcion_cliente,
			(SELECT SUM(monto_deposito)
			FROM planpagodepositos 
			WHERE planpago_id=pp.id and baja_logica = 1 AND tipo_deposito =1) as deposito_total,
			(SELECT SUM(monto_deposito)
			FROM planpagodepositos 
			WHERE planpago_id=pp.id and baja_logica = 1 AND tipo_deposito =2) as mora_total
			FROM planpagos pp
			WHERE pp.contratoproducto_id = '$contratoproducto_id' AND pp.baja_logica=1";
			$this->_db = new Planpagos();
			return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));		
	}

	public function getcontrato($contratoproducto_id)
	{
		$sql = "SELECT cl.razon_social,c.cliente_id,c.contrato,c.fecha_contrato,c.descripcion,p.producto,p.codigo,g.grupo,e.estacion,l.linea,
		cp.*,pa.valor_1
		FROM contratos c
		INNER JOIN clientes cl ON c.cliente_id = cl.id
		INNER JOIN contratosproductos cp ON c.id = cp.contrato_id
		INNER JOIN productos p ON p.id = cp.producto_id 
		INNER JOIN grupos g ON p.grupo_id = g.id
		INNER JOIN estaciones e ON p.estacion_id = e.id
		INNER JOIN lineas l ON e.linea_id = l.id
		INNER JOIN parametros pa ON cp.estado = pa.nivel AND pa.parametro = 'contratos_estados'
		WHERE c.baja_logica =1 AND cp.baja_logica = 1 AND cp.id = '$contratoproducto_id'";
		$this->_db = new Planpagos();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));	
	}

	public function datoscontrato($contratoproducto_id)
	{
		$sql = "SELECT c.*,cp.total,cp.nro_dias 
		FROM contratosproductos cp
		INNER JOIN contratos c ON cp.contrato_id=c.id
		WHERE cp.id = '$contratoproducto_id'";
		$this->_db = new Planpagos();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));	
	}

	public function listapagospendientes()
	{
		$sql = "SELECT cl.razon_social,cl.correo,cl.representante_legal,cl.correo_representante_legal,cl.nombre_ref,cl.correo_ref,cl.nit,g.grupo,l.linea,e.estacion,c.contrato,p.producto,
		pp.*,(SELECT CAST( COALESCE(SUM(ppd.monto_deposito),0) AS DECIMAL(10,2)) FROM  planpagodepositos ppd WHERE ppd.planpago_id=pp.id AND ppd.baja_logica = 1 ) as monto_depositado,
		DATEDIFF(CURRENT_DATE(),pp.fecha_programado) AS diferencia_dias
		FROM planpagos pp
		INNER JOIN contratosproductos cp ON pp.contratoproducto_id = cp.id AND cp.baja_logica =1
		INNER JOIN productos p ON pp.producto_id = p.id
		INNER JOIN contratos c ON cp.contrato_id = c.id
		INNER JOIN clientes cl ON c.cliente_id = cl.id
		INNER JOIN grupos g ON p.grupo_id = g.id
		INNER JOIN estaciones e ON p.estacion_id = e.id
		INNER JOIN lineas l ON e.linea_id = l.id
		WHERE pp.baja_logica = 1 
		AND DATEDIFF(CURRENT_DATE(),pp.fecha_programado) >='-10' 
		AND (pp.monto_reprogramado-(SELECT CAST( COALESCE(SUM(ppd.monto_deposito),0) AS DECIMAL(10,2)) FROM  planpagodepositos ppd WHERE ppd.planpago_id=pp.id AND ppd.baja_logica = 1 )) >0
		ORDER BY pp.fecha_programado";
		$this->_db = new Planpagos();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	}

	public function listamoraspendientes()
	{
		$sql="SELECT cl.razon_social,cl.correo,cl.representante_legal,cl.correo_representante_legal,cl.nombre_ref,cl.correo_ref,cl.nit,g.grupo,l.linea,e.estacion,c.contrato,p.producto,
pp.id,pp.contratoproducto_id,pp.contrato_id,pp.producto_id,pp.fecha_programado,pp.monto_reprogramado,
(SELECT CAST( COALESCE(SUM(ppd.monto_deposito),0) AS DECIMAL(10,2)) FROM  planpagodepositos ppd WHERE ppd.planpago_id=pp.id AND ppd.baja_logica = 1 ) as monto_depositado,
pp.dias_atraso,COALESCE(pp.mora,0) as mora,c.dias_tolerancia,porcentaje_mora,cp.total,cp.nro_dias,
(SELECT COALESCE(SUM(monto_deposito),0)	FROM planpagodepositos WHERE planpago_id=pp.id and baja_logica = 1 AND tipo_deposito =2) as deposito_mora_total,
DATEDIFF(CURRENT_DATE(),ADDDATE(pp.fecha_programado, INTERVAL c.dias_tolerancia DAY)) AS diferencia_dias,
CAST((DATEDIFF(CURRENT_DATE(),ADDDATE(pp.fecha_programado, INTERVAL c.dias_tolerancia DAY))*((cp.total/cp.nro_dias)*c.porcentaje_mora)) AS DECIMAL(10.2)) AS mora_total
FROM planpagos pp
INNER JOIN contratosproductos cp ON pp.contratoproducto_id = cp.id AND cp.baja_logica=1
INNER JOIN productos p ON pp.producto_id = p.id
INNER JOIN contratos c ON cp.contrato_id = c.id
INNER JOIN clientes cl ON c.cliente_id = cl.id
INNER JOIN grupos g ON p.grupo_id = g.id
INNER JOIN estaciones e ON p.estacion_id = e.id
INNER JOIN lineas l ON e.linea_id = l.id
WHERE pp.baja_logica = 1 
AND DATEDIFF(CURRENT_DATE(),pp.fecha_programado) >='0'
AND IF(COALESCE(pp.mora,0)>0,
		(IF (pp.mora>(SELECT COALESCE(SUM(monto_deposito),0)	FROM planpagodepositos WHERE planpago_id=pp.id and baja_logica = 1 AND tipo_deposito =2),
		TRUE,FALSE
						)
		),
		(IF(pp.monto_reprogramado > (SELECT CAST( COALESCE(SUM(ppd.monto_deposito),0) AS DECIMAL(10,2)) FROM  planpagodepositos ppd WHERE ppd.planpago_id=pp.id AND ppd.baja_logica = 1 ),TRUE,FALSE)
		))=TRUE
ORDER BY pp.fecha_programado";
		$this->_db = new Planpagos();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	}
}