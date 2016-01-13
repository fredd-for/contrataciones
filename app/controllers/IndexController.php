<?php

class IndexController extends ControllerBase {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {
        $config = array();

        $this->assets

        ->addCss('/media/plugins/org/css/primitives.latest.css')
        ;
        $this->assets
        ->addJs('/js/highcharts/js/highcharts.js')
        ->addJs('/js/highcharts/js/modules/data.js')
        ->addJs('/js/highcharts/js/modules/exporting.js')
        ->addJs('/js/highcharts/js/modules/drilldown.js')
        ->addJs('/scripts/dashboard.js')
        // ->addJs('/js/jorgchart/jquery.jOrgChart.js')
        // ->addJs('/media/plugins/org/js/jquery/jquery-ui-1.10.2.custom.min.js')
        // ->addJs('/media/plugins/org/js/primitives.min.js')
        ;
        $this->view->setVar('usuario', $this->_user);
        
        $clientes = consultas::clientesContrato()->count();
        $productossinalquilar = Productos::sum(array("baja_logica=1 and cantidad>0", 'column' => 'cantidad'));
        $productosalquilados = Contratosproductos::sum(array("baja_logica=1 and cantidad>0", 'column' => 'cantidad'));
        $contratosActivos = Contratos::count(array("baja_logica=1"));

        $this->view->setVar('clientes', $clientes);
        $this->view->setVar('productossinalquilar', $productossinalquilar);
        $this->view->setVar('productosalquilados', $productosalquilados);
        $this->view->setVar('contratosActivos', $contratosActivos);

        /*Datos para el grafico*/
        $fechaActual = date('Y-m');
        $nuevafecha = strtotime ('-11 month' , strtotime ( $fechaActual ) ) ;
        $nuevafecha = date ( 'Y-m' , $nuevafecha );
        $usuariocomercial = Usuarios::find(array('habilitado = 1 and nivel in (2,3)',"order"=>"id ASC"));
        $html_tabla = '<tr><th></th>';
        $array_usuario_id=array();
        foreach ($usuariocomercial as $v) {
            $html_tabla .='<th>'.$v->nombre.' '.$v->paterno.'</th>';
            $array_usuario_id[]=$v->id;
        }
        $html_tabla.='</tr>';
        
        while ($nuevafecha<=$fechaActual) {
            $html_tabla .= '<tr><th>'.date("M",strtotime($nuevafecha)).'</th>';
            for ($i=0; $i < count($array_usuario_id); $i++) { 
                $model = new Consultas();
                $cantidadcontratos = $model->contratosComerciales($nuevafecha,$array_usuario_id[$i]);
                $html_tabla .= '<td>'.$cantidadcontratos[0]->cant.'</td>';
            }            
            $html_tabla.='</tr>';
            $nuevafecha = strtotime ('1 month' , strtotime ( $nuevafecha ) ) ;
            $nuevafecha = date ( 'Y-m' , $nuevafecha );
        }
        $this->view->setVar('html_tabla', $html_tabla);        
        
    }

    // public function solicitudesAction()
    // {
    //     $this->view->disable();
    //     $fechaActual = date('Y-m');
    //     $nuevafecha = strtotime ('-11 month' , strtotime ( $fechaActual ) ) ;
    //     $nuevafecha = date ( 'Y-m' , $nuevafecha );

    //     $category = array();
    //     $category['name'] = 'Meses';
    //     $usuariocomercial = Usuarios::find(array('habilitado = 1 and nivel in (2,3)',"order"=>"id ASC"));
    //     $ids = array();
    //     foreach ($usuariocomercial as $v) {
    //         $series.$v->id = array();
    //         $series.$v->id['name'] = $v->nombre.' '.$v->paterno;            
    //         $ids[] = $v->id 
    //     }

    //     while ($nuevafecha<=$fechaActual) {
    //         $category['data'][] = date("M",strtotime($nuevafecha));
    //         for ($i=0; $i < count($ids); $i++) { 
    //             $model = new Consultas();
    //             $cantidadcontratos = $model->contratosComerciales($nuevafecha,$ids[$i]);
    //             $series.$ids[$i]['data'][] = $cantidadcontratos[0]->cant;
    //         }            
    //         $nuevafecha = strtotime ('1 month' , strtotime ( $nuevafecha ) ) ;
    //         $nuevafecha = date ( 'Y-m' , $nuevafecha );
    //     }

    //     $result = array();
    //     array_push($result,$category);
    //     for ($i=0; $i < count($ids); $i++) { 
    //         array_push($result,$series.$ids[$i]);
    //     }

    //     echo json_encode($result, JSON_NUMERIC_CHECK);

    // }
    //organigrma
    
  //   public function organigramaAction($id){
  //       $this->view->disable();
  //       $mOrganigrama=  consultas::organigrama();
  //       $organigrama=array();
        
  //       foreach ($mOrganigrama as $o){
  //          $parent=$o->padre_id;
  //          if($o->padre_id==0)
  //           $parent=null;
  //       $organigrama[$o->id]=array(
  //           "id"=>$o->id,                
  //           "parent"=>$parent,
  //           "title"=>$o->nivel_estructural,
  //           "email"=>'Acefalo',
  //           "description"=>$o->unidad_administrativa,
  //           "phone"=>$o->id,  
  //           "email"=>'',  
  //           'templateName'=> "contactTemplate",
  //           'href'=> $o->id,  
  //           "itemTitleColor"=> '#0065B3'
  //           );
  //   }
  //       //fiscalizacion interna
  //        $organigrama[1223]=array(
  //               "id"=>1223,                
  //               "parent"=>1,
  //               "title"=>'DEPARTAMENTO',
  //               "email"=>'Acefalo',
  //               "description"=>'Fiscalizacion Interna',
  //               "phone"=>1223,  
  //               "email"=>'',  
  //               'templateName'=> "contactTemplate",
  //               'href'=> "contactTemplate",   
  //               'itemType'=>1,
  //             "itemTitleColor"=> '#9358AC'
             
  //           );
  //       echo json_encode(array_values($organigrama),JSON_NUMERIC_CHECK);
  //   }
  //   public function personigramaAction($id){
  //       $this->view->disable();
  //       $mOrganigrama=  consultas::personigrama($id);
  //       $organigrama=array();
  //       $relaciones=consultas::personigramacargo($id);
  //       foreach ($mOrganigrama as $o){
  //           $parent=$o->depende_id;
  //           if($o->depende_id==0)
  //           $parent=null;
  //           $organigrama[$o->id]=array(
  //               "id"=>$o->id,                
  //               "parent"=>$parent,
  //               "title"=>'ACEFALO',
  //               "email"=>'Acefalo',
  //               "description"=>$o->cargo,
  //               "image"=>'/personal/hombre.jpg',  
  //               'templateName'=> "PersonTemplate",
  //               'ci'=> $o->id
  //           );
  //       }
  //       foreach ($relaciones as $r){            
  //           $organigrama[$r->cargo_id]['title']=$r->nombre;                
  //           $foto='/personal/hombre.jpg';
  //            if (file_exists('personal/' . $r->foto)) {
  //                   $foto='/personal/' . $r->foto;
  //               }
  //           $organigrama[$r->cargo_id]['image']=$foto;                
  //           $organigrama[$r->cargo_id]['ci']=$r->ci;                
  //       }
  //       echo json_encode(array_values($organigrama),JSON_NUMERIC_CHECK);
  //   }
    
  //   public function listar($id, $oficina, $sigla) {
  //       $h = organigramas::count("padre_id='$id'");
  //       $this->lista.='<li id="org" style="display:none">
		// <hr/>
  //               <a href="javascript:void(0)" title="Ver Personigrama" class="personigrama" oficina="' . $id . '"   id="lista">' . $oficina . '</a>';

  //       if ($h > 0) {
  //           //echo '<ul>';
  //           $this->lista.='<ul>';
  //           $hijos = Organigramas::find(array("padre_id='$id' and baja_logica=1 AND visible='1'"));
  //           //$hijos = ORM::factory('oficinas')->where('padre', '=', $id)->find_all();
  //           foreach ($hijos as $hijo) {
  //               $oficina = $hijo->unidad_administrativa;
  //               $this->listar($hijo->id, $oficina, $hijo->sigla);
  //           }
  //           $this->lista.='</ul>';
  //           // echo '</ul>';
  //       } else {
  //           $this->lista.='</li>';
  //           //   echo '</li>';
  //       }
  //   }

  //   public function personalAction($organigrama_id) {
  //       $this->view->disable();

  //       $cargo = cargos::findFirst(array("organigrama_id='$organigrama_id' and depende_id='0'"));
  //       if ($cargo != false) {

  //           $this->listarPersonal($cargo->id, $cargo->cargo, $cargo->codigo, $cargo->estado);
  //           $this->lista.='</ul>';
  //           $config = array();
  //       } else {
  //           $this->lista.='<h3>No existe cargos dentro la oficina..</h3>';
  //       }
  //       echo $this->lista;
  //   }

  //   /* /lista de personal */

  //   public function listarPersonal($id, $cargo, $codigo, $estado) {
  //       $h = cargos::count("depende_id='$id'");
  //       $datos_usuario = "";
  //       $nombre = "";
  //       if ($estado == 0) {
  //           $datos_usuario = ' <img src="/images/personal/imagen_acefalo.jpg" class="foto"title="ACEFALO" height="50" width="50"><br>ACEFALO';
  //       } else {
  //           $ci_activo = '1';    
  //           $cargo_ci=new cargos();
  //           $ci = $cargo_ci->getCI($id);
            
  //           foreach ($ci as $v) {
  //               $ci_activo = $v->ci;
  //               $nombre = $v->nombre;
  //           }
  //           $datos_usuario = ' <img src="/personal/'.$ci_activo.'.jpg" class="foto" title="Adjudicado" height="50" width="50">';
  //           $datos_usuario.="<br>" . $nombre;
  //       }
  //       $this->lista.='<li id="org2" style="display:none"><span>' . $codigo . '</span><br>' . $cargo . '<br>' . $datos_usuario;
  //       if ($h > 0) {
  //           //echo '<ul>';

  //           $this->lista.='<ul>';
  //           $hijos = cargos::find("depende_id='$id' and baja_logica=1");
  //           //$hijos = ORM::factory('oficinas')->where('padre', '=', $id)->find_all();
  //           foreach ($hijos as $hijo) {
  //               $cargo = $hijo->cargo;
  //               $this->listarPersonal($hijo->id, $cargo, $hijo->codigo, $hijo->estado);
  //               //echo $hijo->id. $cargo. $hijo->codigo. $hijo->estado;
  //           }
  //           $this->lista.='</ul>';
  //           // echo '</ul>';
  //       } else {
  //           $this->lista.='</li>';
  //           //   echo '</li>';
  //       }
  //   }

   
}
