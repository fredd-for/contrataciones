<?php 
/**
* 
*/
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Contratos extends \Phalcon\Mvc\Model
{
	private $_db;
	public function lista()
	{
		$sql = "SELECT c.*,cl.razon_social
		FROM contratos c
		INNER JOIN clientes cl ON c.cliente_id = cl.id
		WHERE c.baja_logica = 1";
		$this->_db = new Contratos();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	}
	
	public function listContrato($contrato_id)
	{
		$sql = "SELECT co.*,cl.razon_social,cl.nit,cl.representante_legal,CONCAT(COALESCE(paterno,' '),' ',COALESCE(materno,' '),' ',COALESCE(nombre,' ')) as responsable,p.valor_1
		FROM contratos co
		INNER JOIN clientes cl ON co.cliente_id=cl.id 
		INNER JOIN usuarios u ON co.responsable_id = u.id
		INNER JOIN parametros p ON co.estado = p.nivel AND p.parametro = 'contratos_estados'
		WHERE co.id='$contrato_id' AND co.baja_logica=1 LIMIT 1";
		$this->_db = new Contratos();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	}

	public function listcp($contrato_id)
	{
		$sql = "SELECT g.grupo,l.linea, e.estacion,p.producto,p.codigo,c.contrato,cp.*,pa.valor_1
		FROM contratosproductos cp 
		INNER JOIN contratos c ON cp.contrato_id=c.id
		INNER JOIN productos p	ON cp.producto_id = p.id
		INNER JOIN estaciones e ON p.estacion_id = e.id
		INNER JOIN lineas l ON e.linea_id = l.id
		INNER JOIN grupos g ON p.grupo_id = g.id
		INNER JOIN parametros pa ON cp.estado = pa.nivel AND pa.parametro ='contratos_estados'
		WHERE cp.baja_logica=1 AND cp.contrato_id='$contrato_id' 
		ORDER BY fecha_fin ASC";
		$this->_db = new Contratos();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));			
	}

	public function listadocontratos()
	{
		$sql = "SELECT c.*,p.valor_1, CONCAT(COALESCE(u.paterno,' '),' ',COALESCE(u.materno,' '),' ',COALESCE(u.nombre,' ')) as responsable,
		(SELECT COUNT(cp.id) FROM contratosproductos cp WHERE cp.baja_logica = 1 AND cp.contrato_id = c.id) as num_productos,
		cl.razon_social
		FROM contratos c
		INNER JOIN usuarios u ON c.responsable_id = u.id
		INNER JOIN clientes cl ON c.cliente_id = cl.id
		INNER JOIN parametros p ON c.estado = p.nivel AND p.parametro='contratos_estados'
		WHERE c.baja_logica = 1
		ORDER BY c.fecha_contrato DESC ";
		$this->_db = new Contratos();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));			
	}

public function getcontrato($contratoproducto_id)
{
	$sql = "SELECT g.grupo,l.linea, e.estacion,p.producto,c.contrato,cp.*
	FROM contratosproductos cp 
	INNER JOIN contratos c ON cp.contrato_id=c.id
	INNER JOIN productos p	ON cp.producto_id = p.id
	INNER JOIN estaciones e ON p.estacion_id = e.id
	INNER JOIN lineas l ON e.linea_id = l.id
	INNER JOIN grupos g ON p.grupo_id = g.id
	WHERE cp.baja_logica=1 AND cp.id='$contratoproducto_id' 
	ORDER BY fecha_fin ASC";
	$this->_db = new Contratos();
	return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
}

public function activos($cliente_id)
{
	$sql="SELECT cp.id
	FROM contratos c
	LEFT JOIN contratosproductos cp ON c.id = cp.contrato_id AND cp.baja_logica=1
	WHERE c.baja_logica = 1 AND c.cliente_id = '$cliente_id'
	GROUP BY c.id
	HAVING MIN(cp.fecha_inicio)<=CURDATE() AND CURDATE()<=MAX(cp.fecha_fin)";
	$this->_db = new Contratos();
	return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
}	

public function proceso($cliente_id)
{
	$sql="SELECT c.id
	FROM contratos c
	LEFT JOIN contratosproductos cp ON c.id = cp.contrato_id AND cp.baja_logica=1
	WHERE c.baja_logica = 1 AND c.cliente_id = '$cliente_id' 
	GROUP BY c.id
	HAVING MIN(cp.fecha_inicio)>CURDATE()";
	$this->_db = new Contratos();
	return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
}

public function concluido($cliente_id)
{
	$sql="SELECT cp.id
	FROM contratos c
	LEFT JOIN contratosproductos cp ON c.id = cp.contrato_id AND cp.baja_logica=1
	WHERE c.baja_logica = 1 AND c.cliente_id = '1'
	GROUP BY c.id
	HAVING CURDATE()>MAX(cp.fecha_fin)";
	$this->_db = new Contratos();
	return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
}

public function totalContrato($cliente_id)
{
	$sql="SELECT COALESCE(SUM(cp.total),0) as total
	FROM contratos c
	INNER JOIN contratosproductos cp ON c.id = cp.contrato_id AND cp.baja_logica = 1
	WHERE c.baja_logica = 1 AND c.cliente_id = '$cliente_id'";
	$this->_db = new Contratos();
	return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
}

public function depositoTotal($cliente_id)
{
	$sql="SELECT COALESCE((SUM(ppd.monto_deposito)),'0') as deposito	FROM contratos c
	INNER JOIN contratosproductos cp ON c.id = cp.contrato_id AND cp.baja_logica = 1
	INNER JOIN planpagos pp ON cp.id = pp.contratoproducto_id AND pp.baja_logica = 1
	INNER JOIN planpagodepositos ppd ON pp.id = ppd.planpago_id AND ppd.baja_logica = 1 AND ppd.tipo_deposito = 1
	WHERE c.baja_logica = 1 AND c.cliente_id = '$cliente_id'";
	$this->_db = new Contratos();
	return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
}

public function moraTotal($cliente_id)
{
	$sql="SELECT 
	COALESCE(SUM(
		(SELECT SUM(IF(pp.monto_reprogramado<=(SELECT SUM(monto_deposito) FROM planpagodepositos WHERE planpago_id =pp.id AND tipo_deposito=1 AND baja_logica = 1),pp.mora,
			(IF((DATEDIFF(CURDATE(),ADDDATE(pp.fecha_programado, INTERVAL c.dias_tolerancia DAY)))>0,cp.total/cp.nro_dias*c.porcentaje_mora*(DATEDIFF(CURDATE(),ADDDATE(pp.fecha_programado, INTERVAL c.dias_tolerancia DAY))),0))
			)
)
FROM planpagos pp
WHERE pp.contratoproducto_id =cp.id AND pp.baja_logica = 1 )
),'0') as mora
FROM contratos c
INNER JOIN contratosproductos cp ON c.id = cp.contrato_id
WHERE c.baja_logica =1 AND cp.baja_logica = 1 AND c.cliente_id ='$cliente_id'";
$this->_db = new Contratos();
return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
}

	public function finalizarProductos($contrato_id,$estado,$observacion,$usuario)
	{
		$sql="UPDATE contratosproductos SET estado='$estado',fecha_finalizacion=now() , obs_finalizacion = '$observacion', usuario_finalizacion = '$usuario'
		WHERE baja_logica = 1 AND estado = 1 AND contrato_id = '$contrato_id'";
		$this->_db = new Contratos();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	}

}