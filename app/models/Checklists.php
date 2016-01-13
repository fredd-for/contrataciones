<?php 
/**
* 
*/
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Checklists extends \Phalcon\Mvc\Model
{
	
	private $_db;
	public function lista($contrato_id)
	{
		$sql= "SELECT pck.*,p.valor_1 as tipo_empresa_text, IF(pck.obligatorio,'SI','NO') as obligatorio_text,IF(pck.escaner,'SI','NO') as escaner_text, COALESCE(ck.cumple,0) as cumple, 
		COALESCE(ck.parametro_id,0) as parametro_id,
		COALESCE(ck.contrato_id,0) as contrato_id
		FROM parametroschecklists pck
		INNER JOIN parametros p ON pck.tipo_empresa = p.nivel AND p.parametro='checklist_tipoempresas'
		LEFT JOIN checklists ck ON pck.id=ck.parametro_id AND ck.contrato_id='$contrato_id'
		WHERE pck.baja_logica = 1  
		ORDER BY pck.tipo_empresa,pck.parametro";
		$this->_db = new Checklists();
		return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	}

	public function obtenerarchivo($parametro_id,$contrato_id)
	{
		$sql="SELECT ack.* ,COUNT(cliente_id)-1 as archivosactualizados
		FROM checklistsarchivos ckl
		INNER JOIN archivoschecklists ack ON ckl.archivo_id = ack.id
		WHERE ckl.parametro_id='$parametro_id' AND ckl.contrato_id='$contrato_id'
		ORDER BY fecha_reg DESC
		LIMIT 1";
		$this->_db = new Checklists();
		return new Resultset(null, $this->_db,$this->_db->getReadConnection()->query($sql));
	}

	public function obtenerarchivos($parametro_id,$contrato_id)
	{
		$sql="SELECT ack.*,ckl.parametro_id
		FROM checklistsarchivos ckl
		INNER JOIN archivoschecklists ack ON ckl.archivo_id = ack.id
		WHERE ckl.parametro_id='$parametro_id' AND ckl.contrato_id='$contrato_id'
		ORDER BY fecha_reg DESC";
		$this->_db = new Checklists();
		return new Resultset(null, $this->_db,$this->_db->getReadConnection()->query($sql));
	}

	public function getContrato($cliente_id,$contrato_id)
	{
		$sql = "SELECT * 
		FROM contratos c
		WHERE c.cliente_id='$cliente_id' AND c.id<>'$contrato_id' AND c.baja_logica =1
		ORDER BY fecha_contrato DESC";
		$this->_db = new Checklists();
		return new Resultset(null, $this->_db,$this->_db->getReadConnection()->query($sql));
	}

	public function cantChecklist($contrato_id)
	{
		$sql = "SELECT COUNT(contrato_id) as cant_checklist
		FROM checklists 
		WHERE contrato_id = '$contrato_id' AND baja_logica = 1 AND cumple=1";
		$this->_db = new Checklists();
		return new Resultset(null, $this->_db,$this->_db->getReadConnection()->query($sql));
	}

	public function migrar($contrato_id,$contrato_id_migrar)
	{
		$sql = "SELECT migrarChecklist('$contrato_id','$contrato_id_migrar')";
		$this->_db = new Checklists();
		return new Resultset(null, $this->_db,$this->_db->getReadConnection()->query($sql));
	}
}