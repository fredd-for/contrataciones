<?php 
/**
* 
*/
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Archivoschecklists extends \Phalcon\Mvc\Model
{
	
	private $_db;
	// public function lista()
	// {
	// 	$sql= "SELECT pck.*,p.valor_1 as tipo_empresa_text, IF(pck.obligatorio,'SI','NO') as obligatorio_text,IF(pck.escaner,'SI','NO') as escaner_text
	// 	FROM parametroschecklists pck
	// 	INNER JOIN parametros p ON pck.tipo_empresa = p.nivel AND p.parametro='checklist_tipoempresas'
	// 	WHERE pck.baja_logica = 1  
	// 	ORDER BY pck.tipo_empresa";
	// 	$this->_db = new Parametroschecklists();
	// 	return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	// }
}