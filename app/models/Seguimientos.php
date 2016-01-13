<?php
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
class Seguimientos extends \Phalcon\Mvc\Model
{

    public function prueba()
    {
        $this->setConnectionService('sigec');
        $sql = "select * from seguimiento where nur='MT/2014-00002'";
        $users = new Seguimientos();
        return new Resultset(null, $users, $users->getReadConnection()->query($sql));    
    }    

    public function documentos($valor)
    {
    	$this->setConnectionService('sigec');
        $sql = "SELECT * FROM documentos WHERE nur like '%$valor%' ORDER BY nur DESC LIMIT 100";
        $users = new Seguimientos();
        return new Resultset(null, $users, $users->getReadConnection()->query($sql));    
    }

    public function documento($nur)
    {
        $this->setConnectionService('sigec');
        $sql = "SELECT d.*, p.proceso,t.tipo
        FROM documentos d
        INNER JOIN procesos p ON d.id_proceso = p.id
        INNER JOIN tipos t ON d.id_tipo = t.id
        WHERE d.nur = '$nur' AND d.original = 1";
        $users = new Seguimientos();
        return new Resultset(null, $users, $users->getReadConnection()->query($sql));       
    }

    public function seguimiento($nur)
    {
        $this->setConnectionService('sigec');
        $sql = "SELECT s.*,e.estado as estados,
        IF(s.fecha_recepcion IS NULL,(datediff(CURDATE(),s.fecha_emision)),(DATEDIFF(s.fecha_recepcion,s.fecha_emision))) as dias_recepcion,
        (CASE s.estado WHEN 2 THEN DATEDIFF(CURDATE(),s.fecha_recepcion) WHEN 4 THEN DATEDIFF((SELECT fecha_emision FROM seguimiento WHERE id_seguimiento=s.id ORDER BY fecha_emision LIMIT 1),s.fecha_recepcion) ELSE '0' END) as dias_pendiente
        FROM seguimiento s
        INNER JOIN estados e ON s.estado = e.id 
        WHERE s.nur = '$nur' ORDER BY s.id";
        $users = new Seguimientos();
        return new Resultset(null, $users, $users->getReadConnection()->query($sql));          
    }

    public function adjuntos($id_seguimiento)
    {
        $this->setConnectionService('sigec');
        $sql="SELECT cite_original FROM documentos where id_seguimiento ='$id_seguimiento'";
        $users = new Seguimientos();
        return new Resultset(null, $users, $users->getReadConnection()->query($sql));          
    }
}
