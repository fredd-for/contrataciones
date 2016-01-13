<?php 

/**
* 
*/
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Informes extends \Phalcon\Mvc\Model
{
	private $_db;
	
	public function lista()
	{
		$sql = "SELECT cl.razon_social,s.nro_solicitud,i.*
		FROM informes i
		INNER JOIN solicitudes s ON i.solicitud_id=s.id
		INNER JOIN clientes cl ON s.cliente_id = cl.id
		WHERE i.baja_logica = 1";
		$this->_db=new Informes();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	}
}