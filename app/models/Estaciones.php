<?php 
/**
* 
*/
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Estaciones extends Phalcon\Mvc\Model
{
	private $_db;
	public function lista()
	{
		$sql="SELECT e.*,l.linea
		FROM estaciones e
		INNER JOIN lineas l ON e.linea_id = l.id
		WHERE e.baja_logica = 1 
		ORDER BY id ASC";
		$this->_db = new Estaciones();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	}

}