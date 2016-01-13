<?php 
/**
* 
*/
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Clientes extends \Phalcon\Mvc\Model
{
	private $_db;
	public function lista()
	{
		$sql = "SELECT cl.*, (
			SELECT IF(COUNT(cp.id)>0,'Activo','Pasivo')
			FROM contratos c
			INNER JOIN contratosproductos cp ON c.id = cp.contrato_id AND cp.baja_logica=1
			WHERE c.cliente_id=cl.id AND c.baja_logica = 1 AND CURDATE() <= cp.fecha_fin
			) as estado, a.nombre_archivo,a.carpeta
FROM clientes cl
LEFT JOIN archivos a ON cl.id =a.producto_id  AND tabla = 2 AND a.baja_logica =1
WHERE cl.baja_logica = 1";
$this->_db = new Clientes();
return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	}	

	public function listContratosCliente($cliente_id)
	{
		$sql="SELECT c.*, CONCAT(COALESCE(u.paterno,' '),' ',COALESCE(u.materno,' '),' ',COALESCE(u.nombre,' ')) as responsable,
		COUNT(c.id) as num_productos,
		(CASE WHEN MIN(cp.fecha_inicio)>CURDATE() THEN 'Pasivo' WHEN CURDATE()<MAX(cp.fecha_fin) AND CURDATE()>MIN(cp.fecha_inicio) THEN 'Activo' ELSE 'Concluido' END) as estado
		FROM contratos c
		INNER JOIN usuarios u ON c.responsable_id = u.id
		LEFT JOIN contratosproductos cp ON c.id = cp.contrato_id AND cp.baja_logica=1
		WHERE c.baja_logica = 1 AND c.cliente_id = '$cliente_id'
		GROUP BY c.id
		ORDER BY c.fecha_contrato DESC";
		$this->_db = new Clientes();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	}

	
}