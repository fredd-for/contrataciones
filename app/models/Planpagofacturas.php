<?php 
/**
* 
*/
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Planpagofacturas extends \Phalcon\Mvc\Model
{
	private $_db;	
	
	// public function getdatoscontrato($planpagofactura_id)
	// {
	// 	$sql="SELECT ppf.fecha_factura,ppf.fecha_recepcion_cliente,ppf.monto_factura,ppf.nro_factura,pp.fecha_programado,pp.monto_reprogramado,c.dias_tolerancia,c.porcentaje_mora,c.tipo_pago,c.tipo_cobro_mora
	// 	FROM planpagofacturas  ppf
	// 	INNER JOIN planpagos pp ON ppf.planpago_id=pp.id
	// 	INNER JOIN contratos c ON pp.contrato_id = c.id
	// 	WHERE ppf.id = '$planpagofactura_id'";
	// 	$this->_db = new Planpagofacturas();
	// 	return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));
	// }
}