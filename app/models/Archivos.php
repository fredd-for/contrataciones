<?php

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Archivos extends \Phalcon\Mvc\Model {
    /* personal activo de la instatitucion */

    public static function archivosPermitidos($c) {
        $sql = "SELECT t.id,t.tipo_documento,t.codigo,' ' as nombre_archivo,'' as fecha FROM tipodocumento t 
                INNER JOIN tipodoccondicion d 
                ON t.id=d.tipodocumento_id
                where d.condicion_id='$c'
                AND t.baja_logica='1'
                ";
        $db = new Archivos();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }

    public static function listaArchivos($p) {
        $sql = "SELECT id,nombre_archivo,to_char(fecha, 'DD-mm-YYYY') as fecha, tamanio,tipo_documento,tipo_archivo
                FROM archivos WHERE persona_id='$p'
                AND baja_logica='1'
                ";
        $db = new Archivos();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }

    public function deleteImagenCliente($cliente_id)
    {
        $sql="UPDATE archivos SET baja_logica=0 WHERE producto_id ='$cliente_id' and tabla=2";
        $this->_db = new Clientes();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));   
    }

    public function desactivarTodo($archivo_id)
    {
        $sql="UPDATE archivos  
        SET archivos.estado=0
        WHERE archivos.producto_id = (SELECT * FROM(SELECT cast(aa.producto_id as UNSIGNED) FROM archivos aa WHERE aa.id='$archivo_id' limit 1)temp_table)";
        $this->_db = new Archivos();
        return new Resultset(null, $this->_db, $this->_db->getReadConnection()->query($sql));   
    }

}
