<?php

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Consultas extends \Phalcon\Mvc\Model {
    /* personal activo de la instatitucion */

    public static function contratosComerciales($mesanio,$comercial)
    {
        $sql = "SELECT COUNT(id) as cant from contratos 
        WHERE Date_format(fecha_contrato,'%Y-%m') = '".$mesanio."' AND responsable_id = '".$comercial."' AND baja_logica = 1";
        $db = new Clientes();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }

    public static function clientesContrato() {
        $sql = "SELECT c.cliente_id
        FROM contratosproductos cp
        INNER JOIN contratos c ON cp.contrato_id = c.id AND c.baja_logica = 1
        WHERE cp.baja_logica =1 AND CURDATE()<=cp.fecha_fin
        GROUP BY c.cliente_id";
        $db = new Clientes();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }
    public static function productosSinAlquilar() {
        $sql = "SELECT SUM(cantidad) as cantidad FROM productos WHERE baja_logica = 1 AND cantidad >0";
        $db = new Clientes();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }
    public static function personigramacargo($id) {
        $sql = "SELECT r.id,r.num_contrato,CONCAT(p.p_nombre,' ',p.s_nombre,' ',p.p_apellido,' ',p.s_apellido) as nombre,c.codigo, c.id as cargo_id,
                c.cargo,e.estado,to_char(r.fecha_ini, 'DD-mm-YYYY') as fecha_ini,to_char(r.fecha_incor, 'DD-mm-YYYY') as fecha_incorporacion,
                to_char(p.fecha_nac, 'DD-mm-YYYY') as fecha_nac,CONCAT(p.ci,' ',p.expd) as ci,o.unidad_administrativa,p.foto
                FROM  (SELECT * FROM relaborales
                WHERE estado >='1' ) as r
                INNER JOIN personas p ON r.persona_id=p.id
                INNER JOIN organigramas o ON r.organigrama_id=o.id
                INNER JOIN cargos c ON r.cargo_id=c.id               
                INNER JOIN cargosestados e ON c.cargo_estado_id=e.id
                WHERE r.baja_logica='1' AND o.id='$id'
                ORDER BY r.estado";
        $db = new personas();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }
    //DETALLES PERSONA
    public static function archivoActivo($id) {
        $sql = "SELECT r.id,r.num_contrato,CONCAT(p.p_nombre,' ',p.s_nombre,' ',p.p_apellido,' ',p.s_apellido) as nombre,c.codigo, 
                c.cargo,n.denominacion,n.sueldo,e.estado,to_char(r.fecha_ini, 'DD-mm-YYYY') as fecha_ini,to_char(r.fecha_incor, 'DD-mm-YYYY') as fecha_incorporacion,
                to_char(p.fecha_nac, 'DD-mm-YYYY') as fecha_nac,CONCAT(p.ci,' ',p.expd) as ci,o.unidad_administrativa,p.foto
                FROM  (SELECT * FROM relaborales
                WHERE estado >='1' and id='$id' ) as r
                INNER JOIN personas p ON r.persona_id=p.id
                INNER JOIN organigramas o ON r.organigrama_id=o.id
                INNER JOIN cargos c ON r.cargo_id=c.id
                INNER JOIN nivelsalariales n ON r.nivelsalarial_id=n.id
                INNER JOIN cargosestados e ON c.cargo_estado_id=e.id
                WHERE r.baja_logica='1'
                ORDER BY r.estado";
        $db = new personas();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }

    public static function personasActivo() {
        $sql = "SELECT p.id,CONCAT(p.p_nombre,' ',p.s_nombre) as nombres,CONCAT(p.p_apellido,' ',p.s_apellido) as apellidos,to_char(p.fecha_nac, 'DD-mm-YYYY') as fecha_nac,p.ci,p.expd,p.nacionalidad
                ,foto,genero,nacionalidad FROM personas p
                WHERE p.id not in 
                (
                select distinct persona_id FROM relaborales  WHERE baja_logica='1'
                ) ORDER BY p.p_apellido ASC";
        $db = new personas();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }
   

    public static function acefalos() {
        $sql = "SELECT c.id,c.cargo,c.codigo,o.unidad_administrativa as oficina,n.denominacion,n.sueldo,ce.estado from cargos c
                inner join organigramas o on c.organigrama_id = o.id
                inner join nivelsalariales n on c.codigo_nivel = n.nivel
                inner join ejecutoras e on c.ejecutora_id = e.id
                inner join cargosestados ce on c.cargo_estado_id = ce.id
                inner join finpartidas fp on c.fin_partida_id = fp.id
                inner join condiciones cs on fp.condicion_id=cs.id
                left join organigramas temporganigramas on temporganigramas.id = o.padre_id
                where c.id not in (
                        select distinct r.cargo_id from relaborales r	
                        where r.baja_logica=1
                        and r.estado>=1
                )
                
";
        $db = new personas();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }
    
    public static function organigrama(){
        $sql="SELECT o.id,n.nivel_estructural,o.padre_id,o.unidad_administrativa
               FROM  organigramas o 
               INNER JOIN nivelestructurales n ON o.nivel_estructural_id=n.id
               WHERE o.baja_logica='1' and o.visible='1'";
         $db = new personas();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }
    public static function personigrama($id){
        $sql="select id,organigrama_id,depende_id,cargo from cargos where organigrama_id='$id'  and baja_logica='1'";
         $db = new personas();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }

/*
SQl para obtener los el monto por contrato agrupado por Responsables
 */
    public function contratosResponsable()
    {
        $sql = "SELECT u.id,CONCAT(u.nombre,' ',u.paterno) as nombre,COALESCE(SUM(cp.total),0) as monto
        FROM usuarios u
        LEFT JOIN contratos c ON u.id = c.responsable_id AND c.baja_logica = 1
        LEFT JOIN contratosproductos cp ON c.id = cp.contrato_id AND cp.baja_logica = 1
        WHERE u.habilitado = 1 AND u.nivel = 2 
        GROUP BY u.id";
        $db = new Consultas();
        return new Resultset(null, $db, $db->getReadConnection()->query($sql));
    }

   public function contratosClientes($responsable_id)
   {
    $sql = "SELECT cl.id,cl.razon_social,COALESCE(SUM(cp.total),0)  as monto
    FROM 
    contratos c 
    INNER JOIN clientes cl ON c.cliente_id = cl.id
    LEFT JOIN contratosproductos cp ON c.id = cp.contrato_id AND cp.baja_logica = 1
    WHERE c.responsable_id ='$responsable_id'
    GROUP BY c.cliente_id";
    $db = new Consultas();
    return new Resultset(null, $db, $db->getReadConnection()->query($sql));
} 

}
