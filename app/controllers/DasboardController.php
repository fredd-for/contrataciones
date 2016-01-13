<?php

class DasboardController extends ControllerBase {

	public function solicitudesAction()
    {
        $this->view->disable();
        $fechaActual = date('Y-m');
        $nuevafecha = strtotime ('-11 month' , strtotime ( $fechaActual ) ) ;
        $nuevafecha = date ( 'Y-m' , $nuevafecha );

        $category = array();
        $category['name'] = 'Meses';
        $usuariocomercial = Usuarios::find(array('habilitado = 1 and nivel in (2,3)',"order"=>"id ASC"));
        $ids = array();
        foreach ($usuariocomercial as $v) {
            $series[$v->id] = array();
            $series[$v->id]['name'] = $v->nombre.' '.$v->paterno;            
            $ids[] = $v->id; 
        }

        while ($nuevafecha<=$fechaActual) {
            $category['data'][] = date("M",strtotime($nuevafecha));
            for ($i=0; $i < count($ids); $i++) { 
                $model = new consultas();
                $cantidadcontratos = $model->contratosComerciales($nuevafecha,$ids[$i]);
                $series[$ids[$i]][$i]['data'][] = $cantidadcontratos[0]->cant;
            }            
            $nuevafecha = strtotime ('1 month' , strtotime ( $nuevafecha ) ) ;
            $nuevafecha = date ( 'Y-m' , $nuevafecha );
        }

        $result = array();//         array_push($result,$category);
        array_push($result,$category);
        for ($i=0; $i < count($ids); $i++) { 
            array_push($result,$series[$ids[$i]][$i]);
        }
        echo var_dump($result);
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function container3Action()
    {   $this->view->disable();
        $model = new consultas();
        $resul = $model->contratosResponsable();
        $rows = array();
        foreach ($resul as $v) {
            $row['name'] = $v->nombre;
            $row['y'] = $v->monto;
            $row['x'] = $v->id;
            array_push($rows,$row);
        }
        // echo var_dump($rows);
        echo json_encode($rows, JSON_NUMERIC_CHECK);
        
    }

    public function container4Action($responsable_id)
    {   $this->view->disable();
        $model = new consultas();
        $resul = $model->contratosClientes($responsable_id);
        $rows = array();
        foreach ($resul as $v) {
            $row['name'] = $v->razon_social;
            $row['y'] = $v->monto;
            array_push($rows,$row);
        }
        // echo var_dump($rows);
        echo json_encode($rows, JSON_NUMERIC_CHECK);
        
    }

//     public function solicitudesAction()
//     {
//         $this->view->disable();
//         $category = array();
//         $category['name'] = 'Meses';

//         $series15 = array();
//         $series15['name'] = 'Wordpress';

//         $series2 = array();
//         $series2['name'] = 'CodeIgniter';

//         $series3 = array();
//         $series3['name'] = 'Highcharts';

// // while($r = mysql_fetch_array($query)) {
//         $category['data'][] = 'Ene';
//         $series15['data'][] = 25;
//         $series2['data'][] = 46;
//         $series3['data'][] = 2;  

//         $category['data'][] = 'Feb';
//         $series15['data'][] = 25;
//         $series2['data'][] = 46;
//         $series3['data'][] = 2;  

//         $category['data'][] = 'Mar';
//         $series15['data'][] = 25;
//         $series2['data'][] = 46;
//         $series3['data'][] = 2;  
// // }

//         $result = array();
//         array_push($result,$category);
//         array_push($result,$series15);
//         array_push($result,$series2);
//         array_push($result,$series3);
//         echo var_dump($result);
//         echo json_encode($result);

//     }
}