<?php 
/**
* 
*/
class PlanpagosController extends ControllerBase
{
	private $tipo = array('1' =>'Garantia','2'=>'Derecho de Llave','3'=>'Devolución Garantia','4'=>'Devolución Derecho de Llave' );
	public function indexAction()
	{
		$this->assets
        ->addCss('/jqwidgets/styles/jqx.base.css')
        ->addCss('/jqwidgets/styles/jqx.custom.css');
        $this->assets
        ->addJs('/jqwidgets/jqxcore.js')
        ->addJs('/jqwidgets/jqxmenu.js')
        ->addJs('/jqwidgets/jqxdropdownlist.js')
        ->addJs('/jqwidgets/jqxlistbox.js')
        ->addJs('/jqwidgets/jqxcheckbox.js')
        ->addJs('/jqwidgets/jqxscrollbar.js')
        ->addJs('/jqwidgets/jqxgrid.js')
        ->addJs('/jqwidgets/jqxdata.js')
        ->addJs('/jqwidgets/jqxgrid.sort.js')
        ->addJs('/jqwidgets/jqxgrid.pager.js')
        ->addJs('/jqwidgets/jqxgrid.filter.js')
        ->addJs('/jqwidgets/jqxgrid.selection.js')
        ->addJs('/jqwidgets/jqxgrid.grouping.js')
        ->addJs('/jqwidgets/jqxgrid.columnsreorder.js')
        ->addJs('/jqwidgets/jqxgrid.columnsresize.js')
        ->addJs('/jqwidgets/jqxdatetimeinput.js')
        ->addJs('/jqwidgets/jqxcalendar.js')
        ->addJs('/jqwidgets/jqxbuttons.js')
        ->addJs('/jqwidgets/jqxdata.export.js')
        ->addJs('/jqwidgets/jqxgrid.export.js')
        ->addJs('/jqwidgets/globalization/globalize.js')
        ->addJs('/jqwidgets/jqxgrid.aggregates.js')
        ->addJs('/jqwidgets/jqxtooltip.js')
        ->addJs('/scripts/planpagos/index.js')
        ->addJs('/media/plugins/bootbox/bootbox.min.js')
        ;

    }

public function listAction()
{
      $model = new Planpagos();
      $resul = $model->lista();
      $this->view->disable();
      foreach ($resul as $v) {
        if ($v->estado==1) {
                $estado = "<span class='label label-primary'>".$v->valor_1."</span>";
            }elseif ($v->estado ==2) {
                $estado = "<span class='label label-success'>".$v->valor_1."</span>";
            }else{
                $estado = "<span class='label label-danger'>".$v->valor_1."</span>";
            }

        $customers[] = array(
            'id' => $v->id,
            'grupo' => $v->grupo,
            'razon_social' => $v->razon_social,
            'nit' => $v->nit,
            'linea' => $v->linea,
            'estacion' => $v->estacion,
            'producto' => $v->producto,
            'contrato_id' => $v->contrato_id,
            'contrato' => $v->contrato,
            'fecha_contrato' => $v->fecha_contrato,
            'fecha_inicio' => $v->fecha_inicio,
            'fecha_fin' => $v->fecha_fin,
            'total' => $v->total,
            'deposito' => $v->deposito,
            'cobrar' => $v->total-$v->deposito,
            'mora' => $v->mora,
            'estado' => $estado
            );
    }
    echo json_encode($customers);
}

public function listproductosclientesAction($cliente_id)
{
      $model = new Planpagos();
      $resul = $model->lista($cliente_id);
      $this->view->disable();
      foreach ($resul as $v) {
        $customers[] = array(
            'id' => $v->id,
            'grupo' => $v->grupo,
            'razon_social' => $v->razon_social,
            'linea' => $v->linea,
            'estacion' => $v->estacion,
            'producto' => '<a href="/planpagos/controlpago/'.$v->id.'">'.$v->producto.'</a>',
            'contrato' => $v->contrato,
            'fecha_contrato' => $v->fecha_contrato,
            'fecha_inicio' => $v->fecha_inicio,
            'fecha_fin' => $v->fecha_fin,
            'total' => $v->total,
            'deposito' => $v->deposito,
            'cobrar' => $v->total-$v->deposito,
            'mora' => $v->mora
            );
    }
    echo json_encode($customers);
}


public function controlpagoAction($contratoproducto_id)
{
        $this->assets
        ->addCss('/jqwidgets/styles/jqx.base.css')
        ->addCss('/jqwidgets/styles/jqx.custom.css');
        $this->assets
        ->addJs('/jqwidgets/jqxcore.js')
        ->addJs('/jqwidgets/jqxmenu.js')
        ->addJs('/jqwidgets/jqxdropdownlist.js')
        ->addJs('/jqwidgets/jqxlistbox.js')
        ->addJs('/jqwidgets/jqxcheckbox.js')
        ->addJs('/jqwidgets/jqxscrollbar.js')
        ->addJs('/jqwidgets/jqxgrid.js')
        ->addJs('/jqwidgets/jqxdata.js')
        ->addJs('/jqwidgets/jqxgrid.sort.js')
        ->addJs('/jqwidgets/jqxgrid.pager.js')
        ->addJs('/jqwidgets/jqxgrid.filter.js')
        ->addJs('/jqwidgets/jqxgrid.selection.js')
        ->addJs('/jqwidgets/jqxgrid.grouping.js')
        ->addJs('/jqwidgets/jqxgrid.columnsreorder.js')
        ->addJs('/jqwidgets/jqxgrid.columnsresize.js')
        ->addJs('/jqwidgets/jqxdatetimeinput.js')
        ->addJs('/jqwidgets/jqxcalendar.js')
        ->addJs('/jqwidgets/jqxbuttons.js')
        ->addJs('/jqwidgets/jqxdata.export.js')
        ->addJs('/jqwidgets/jqxgrid.export.js')
        ->addJs('/jqwidgets/globalization/globalize.js')
        ->addJs('/jqwidgets/jqxgrid.aggregates.js')
        ->addJs('/jqwidgets/jqxtooltip.js')
        ->addJs('/scripts/planpagos/controlpago.js')
        ->addJs('/media/plugins/bootbox/bootbox.min.js')
        ;

        $model = new Planpagos();
        $resul = $model->getcontrato($contratoproducto_id);
        // $contratoproducto = array();
        // foreach ($resul as $v) {
        //     $contratoproducto = $v;
        // }
        $this->view->setVar('contratoproducto',$resul[0]);

        // $html = $this->htmlcontrolpagos($contratoproducto_id);
        // $this->view->setVar('htmlp',$html);
        //$this->view->setVar('contratoproducto_id',$contratoproducto_id);

        $garantia = Garantias::findFirst(array('baja_logica=1 and tipo=1 and contratoproducto_id = '.$contratoproducto_id, 'order'=>'tipo ASC'));
        $this->view->setVar('garantia',$garantia);

        $derechollave = Garantias::findFirst(array('baja_logica=1 and tipo=2 and contratoproducto_id = '.$contratoproducto_id, 'order'=>'tipo ASC'));
        $this->view->setVar('derechollave',$derechollave);    
        
}

public function listcontrolpagoAction($contratoproducto_id)
{
    $model = new Planpagos();
    $resul = $model->listacontrolpago($contratoproducto_id);
    $contrato = $model->datoscontrato($contratoproducto_id);
    $hoy = date("Y-m-d");
    $dias =10;
    $fecha_10 = date("Y-m-d",strtotime( '+'.$dias.' day' , strtotime($hoy)));
    foreach ($resul as $v) {
        $html = $this->depositos($v->id,$v->diferencia);

        $diff = $v->monto_programado-$v->monto_reprogramado;
        $diff_text = '';
        if($diff>0){
        $diff_text = '<span class="label label-primary" style="float:left">'.number_format($diff,2,".",",").'</span>';
        }

        /* calculo de mora */
        $dias_atraso = '';
        $mora='';
        
        //segun fecha programada
        $fecha_tolerancia = date("Y-m-d",strtotime( '+'.$contrato[0]->dias_tolerancia.' day' , strtotime($v->fecha_programado)));
        if ($contrato[0]->tipo_cobro_mora==1) {
            if ($fecha_tolerancia<date("Y-m-d")) {
                if ($v->mora>0) {
                    $dias_atraso = $v->dias_atraso;
                    $mora=$v->mora;
                }elseif($v->deposito_total<$v->monto_reprogramado) {
                    $datetime1 = new DateTime($fecha_tolerancia);
                    $datetime2 = new DateTime(date("Y-m-d"));
                    $interval = $datetime1->diff($datetime2);
                    $dias_atraso = $interval->format('%R%a');
                    $mora=($contrato[0]->total/$contrato[0]->nro_dias*$contrato[0]->porcentaje_mora)*$dias_atraso;
                }
            }    
        }
        //segun fecha factura
        if ($contrato[0]->tipo_cobro_mora==2 && $v->fecha_factura) {
            $fecha_tolerancia = date("Y-m-d",strtotime( '+'.$contrato[0]->dias_tolerancia.' day' , strtotime($v->fecha_factura)));            
            if ($fecha_tolerancia<date("Y-m-d")) {
                if ($v->mora>0) {
                    $dias_atraso = $v->dias_atraso;
                    $mora=$v->mora;
                }elseif($v->factura_total>=$v->monto_reprogramado) {
                    $datetime1 = new DateTime($fecha_tolerancia);
                    $datetime2 = new DateTime(date("Y-m-d"));
                    $interval = $datetime1->diff($datetime2);
                    $dias_atraso = $interval->format('%R%a');
                    $mora=($contrato[0]->total/$contrato[0]->nro_dias*$contrato[0]->porcentaje_mora)*$dias_atraso;
                }
            }    
        }

        //segun fecha factura
        if ($contrato[0]->tipo_cobro_mora==3 && $v->fecha_recepcion_cliente) {
            $fecha_tolerancia = date("Y-m-d",strtotime( '+'.$contrato[0]->dias_tolerancia.' day' , strtotime($v->fecha_recepcion_cliente)));            
            if ($fecha_tolerancia<date("Y-m-d")) {
                if ($v->mora>0) {
                    $dias_atraso = $v->dias_atraso;
                    $mora=$v->mora;
                }elseif($v->factura_total>=$v->monto_reprogramado) {
                    $datetime1 = new DateTime($fecha_tolerancia);
                    $datetime2 = new DateTime(date("Y-m-d"));
                    $interval = $datetime1->diff($datetime2);
                    $dias_atraso = $interval->format('%R%a');
                    $mora=($contrato[0]->total/$contrato[0]->nro_dias*$contrato[0]->porcentaje_mora)*$dias_atraso;
                }
            }    
        }
        
        
        /* fin calculo de mora*/
        $customers[] = array(
            'id' => $v->id,
            'fecha_programado' => $v->fecha_programado.' 00:00:00',
            'monto_programado' => $v->monto_programado,
            'monto_reprogramado_div' => $diff_text.' '.number_format($v->monto_reprogramado,2,'.',','),
            'monto_reprogramado' => $v->monto_reprogramado,
            'dias_atraso' =>$dias_atraso,
            'mora' =>$mora,
            'diferencia' =>$v->diferencia,
            'factura_total' =>$v->factura_total,
            'deposito_total' =>$v->deposito_total,
            'mora_total' =>$v->mora_total,
            'nro_deposito' =>$html[0],
            'fecha_deposito' =>$html[1],
            'monto_deposito' =>$html[2],
            'nro_deposito_mora' =>$html[3],
            'fecha_deposito_mora' =>$html[4],
            'monto_deposito_mora' =>$html[5],
            'nro_factura' =>$html[6],
            'fecha_factura' =>$html[7],
            'monto_factura' =>$html[8],
            'fecha_recepcion_cliente' =>$html[9],
            'fecha_actual' =>$hoy,
            'fecha_10' =>$fecha_10,
            'fecha_tolerancia' =>$fecha_tolerancia,
            );
    }
    $this->view->disable();
    echo json_encode($customers);
}

public function depositos($planpago_id='',$diferencia,$sw='0')
{
    $resul = Planpagodepositos::find(array("planpago_id ='$planpago_id' AND baja_logica = 1 AND tipo_deposito = 1 ",'order'=>'fecha_deposito ASC'));
    $resul2 = Planpagodepositos::find(array("planpago_id ='$planpago_id' AND baja_logica = 1 AND tipo_deposito = 2 ",'order'=>'fecha_deposito ASC'));
    $resul3 = Planpagofacturas::find(array("planpago_id ='$planpago_id' AND baja_logica = 1 ",'order'=>'fecha_factura ASC'));
    $nro_deposito = '';
    $fecha_deposito ='';
    $monto_deposito = '';
    if ($diferencia>0 && $sw==0) {
        $monto_deposito.="<span class='label label-primary' style='float:left'>".$diferencia."</span>";    
    }
    
    foreach ($resul as $v) {
        $nro_deposito.="<div>".$v->nro_deposito."</div>";
        $fecha_deposito.="<div>".date("d-m-Y",strtotime($v->fecha_deposito))."</div>";
        $monto_deposito.="<div>".number_format($v->monto_deposito,2,'.',',')."</div>";
    }

    $nro_deposito_mora = '';
    $fecha_deposito_mora ='';
    $monto_deposito_mora = '';
    foreach ($resul2 as $v) {
        $nro_deposito_mora.="<div>".$v->nro_deposito."</div>";
        $fecha_deposito_mora.="<div>".date("d-m-Y",strtotime($v->fecha_deposito))."</div>";
        $monto_deposito_mora.="<div>".number_format($v->monto_deposito,2,'.',',')."</div>";
    }
    $nro_factura = '';
    $fecha_factura ='';
    $monto_factura = '';
    $fecha_recepcion_cliente ='';
    foreach ($resul3 as $v) {
        $nro_factura.="<div>".$v->nro_factura."</div>";
        $fecha_factura.="<div>".date("d-m-Y",strtotime($v->fecha_factura))."</div>";
        $monto_factura.="<div>".number_format($v->monto_factura,2,'.',',')."</div>";
        $fecha_recepcion_cliente.="<div>".date("d-m-Y",strtotime($v->fecha_recepcion_cliente))."</div>";
    }
    $res = array($nro_deposito,$fecha_deposito,$monto_deposito,$nro_deposito_mora,$fecha_deposito_mora,$monto_deposito_mora,$nro_factura,$fecha_factura,$monto_factura,$fecha_recepcion_cliente);
    return $res;
}

public function controlAction($contratoproducto_id)
{
        $model = new Planpagos();
        $resul = $model->getcontrato($contratoproducto_id);
        $contratoproducto = array();
        foreach ($resul as $v) {
            $contratoproducto = $v;
        }
        $this->view->setVar('contratoproducto',$contratoproducto);

        $html = $this->htmlcontrolpagos($contratoproducto_id);
        $this->view->setVar('htmlp',$html);
        $this->view->setVar('contratoproducto_id',$contratoproducto_id);

        $garantia = Garantias::findFirst(array('baja_logica=1 and tipo=1 and contratoproducto_id = '.$contratoproducto_id, 'order'=>'tipo ASC'));
        $this->view->setVar('garantia',$garantia);

        $derechollave = Garantias::findFirst(array('baja_logica=1 and tipo=2 and contratoproducto_id = '.$contratoproducto_id, 'order'=>'tipo ASC'));
        $this->view->setVar('derechollave',$derechollave);    
        $this->assets
        ->addJs('/media/plugins/bootbox/bootbox.min.js')
        ->addJs('/scripts/planpagos/control.js');

    
}

public function modificacionplanpagos($contratoproducto_id)
{
    $model = new Planpagodepositos();
    $resul_ppd = $model->listadepositos($contratoproducto_id);
    $diff=0;
    foreach ($resul_ppd as $v) {
        if ($diff>0) {
            $planpago=Planpagos::findFirstById($v->id);
            $planpago->monto_reprogramado = ($v->monto_programado-$diff);    
            $planpago->save();
        }else{
            $planpago=Planpagos::findFirstById($v->id);
            $planpago->monto_reprogramado = $v->monto_programado;    
            $planpago->save();
        }
        $diff = 0;
        if ($v->deposito >0) {
            $diff = ($v->deposito-$v->monto_reprogramado);
            $planpago=Planpagos::findFirstById($v->id);
            $planpago->diferencia = $diff;  
            $planpago->save();
        }
    }    
}
function modificacionmora($planpago_id)
{
    $model = new Planpagodepositos();
    $resulmora = $model->getdatosverificar($planpago_id,1);
    $dias_atraso =0;
    $mora=0;

    foreach ($resulmora as $v) {
        if ($v->deposito>=$v->monto_reprogramado) {

            if ($v->tipo_cobro_mora=='1') {
                $nuevafecha = strtotime ( '+'.$v->dias_tolerancia.' day' , strtotime ( $v->fecha_programado ) ) ;
                $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
                $datetime1 = new DateTime($nuevafecha);
                $datetime2 = new DateTime($v->fecha);   //fecha deposito
                $interval = $datetime1->diff($datetime2);
                $nro_dias = $interval->format('%R%a');    
            }elseif ($v->tipo_cobro_mora=='2' && $v->fecha_factura) {
                $nuevafecha = strtotime ( '+'.$v->dias_tolerancia.' day' , strtotime ( $v->fecha_factura ) ) ;
                $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
                $datetime1 = new DateTime($nuevafecha);
                $datetime2 = new DateTime($v->fecha);   //fecha deposito
                $interval = $datetime1->diff($datetime2);
                $nro_dias = $interval->format('%R%a');        
            }elseif ($v->tipo_cobro_mora=='3' && $v->fecha_recepcion_cliente) {
                $nuevafecha = strtotime ( '+'.$v->dias_tolerancia.' day' , strtotime ( $v->fecha_recepcion_cliente ) ) ;
                $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
                $datetime1 = new DateTime($nuevafecha);
                $datetime2 = new DateTime($v->fecha);   //fecha deposito
                $interval = $datetime1->diff($datetime2);
                $nro_dias = $interval->format('%R%a');        
            }

            if ($nro_dias>0) {
                $dias_atraso = $nro_dias;
                $mora = ($v->total/$v->nro_dias*$v->porcentaje_mora)*$nro_dias;
            }else{
                $dias_atraso = 0;
                $mora = 0;
            }

        }
        
    }
    $planpago = Planpagos::findFirstById($planpago_id);
    $planpago->dias_atraso = $dias_atraso;
    $planpago->mora = $mora;
    $planpago->save();
}

public function pruebaAction()
{
   
   $model = new Contratos();
   $contratoproducto = $model->getcontrato(1);
   $array = array();
   foreach ($contratoproducto as $v) {
    $array = $v;
    }
    //echo var_dump($array);
    echo $array->grupo;
}


public function savedepositopagoAction()
{
    if (isset($_POST['planpago_id'])) {
        if ($_POST['planpago_id']>0) {
         $fecha_deposito = date("Y-m-d",strtotime($this->request->getPost('fecha_deposito')));
         $resul = new Planpagodepositos();
         $resul->planpago_id = $this->request->getPost('planpago_id');
         $resul->fecha_deposito = $fecha_deposito;
         $resul->nro_deposito = $this->request->getPost('nro_deposito');
         $resul->monto_deposito = $this->request->getPost('monto_deposito');
         $resul->tipo_deposito = $this->request->getPost('tipo_deposito');
         $resul->fecha_reg = date("Y-m-d H:i:s");
         $resul->usuario_reg = $this->_user->id;
         $resul->baja_logica = 1;
         if ($resul->save()) {
            if ($this->request->getPost('tipo_deposito') ==1) {
                /*Realizamos la modificacion de montos en el caso de que esta sea mas o menos*/
                $this->modificacionplanpagos($this->request->getPost('contratoproducto_id'));

                /*Verificamos dias de mora y el monto*/
                $this->modificacionmora($_POST['planpago_id']);
                /*end*/

            }
            $msm = 'Exito: Se guardo correctamente';
        }else{
            $msm = 'Error: No se guardo el registro';
        }
    }
}

$this->view->disable();
echo $msm;
}
/*codigo para borrar*/
public function savedepositoAction()
{
    $html = '';
    //$AddEdit_derechollave = 'add_derechollave';
    if (isset($_POST['planpago_id'])) {
        if ($_POST['planpago_id']>0) {
         $fecha_deposito = date("Y-m-d",strtotime($this->request->getPost('fecha_deposito')));
         $resul = new Planpagodepositos();
         $resul->planpago_id = $this->request->getPost('planpago_id');
         $resul->fecha_deposito = $fecha_deposito;
         $resul->nro_deposito = $this->request->getPost('nro_deposito');
         $resul->monto_deposito = $this->request->getPost('monto_deposito');
         $resul->tipo_deposito = $this->request->getPost('tipo_deposito');
         $resul->fecha_reg = date("Y-m-d H:i:s");
         $resul->usuario_reg = $this->_user->id;
         $resul->baja_logica = 1;
         if ($resul->save()) {
            if ($this->request->getPost('tipo_deposito') ==1) {
            /*
            Realizamos la modificacion de montos en el caso de que esta sea mas o menos
             */
            $this->modificacionplanpagos($this->request->getPost('contratoproducto_id'));
            // end modificacion

            /*Verificamos dias de mora y el monto*/
            $this->modificacionmora($_POST['planpago_id']);
            
            /*end*/

        }

        
        $html = $this->htmlcontrolpagos($this->request->getPost('contratoproducto_id'));
        $msm = 'Exito: Se guardo correctamente';
    }else{
        $msm = 'Error: No se guardo el registro';
    }
}
}

$this->view->disable();
echo $html;
}

public function gethtmlcontrolpagosAction()
{
    $html = $this->htmlcontrolpagos($_POST['contratoproducto_id']);
    $msm = 'Exito: Se guardo correctamente';
    $this->view->disable();
    echo $html;
}

// public function savederechollaveAction()
// {
//     $garantia_id = '';
//     $fecha_deposito = '';
//     $nro_deposito = '';
//     $monto_deposito = '';
//     $AddEdit_derechollave = 'add_derechollave';
//     if (isset($_POST['garantia_id'])) {
//         if ($_POST['garantia_id']>0) {
//          $fecha_deposito = date("Y-m-d",strtotime($this->request->getPost('fecha_deposito')));
//          $resul = Garantias::findFirstById($_POST['garantia_id']);
//          $resul->fecha_deposito = $fecha_deposito;
//          $resul->nro_deposito = $this->request->getPost('nro_deposito');
//          $resul->monto_deposito = $this->request->getPost('monto_deposito');
//          if ($resul->save()) {
//             $msm = 'Exito: Se guardo correctamente';
//             $garantia_id = $resul->id;
//             $fecha_deposito = date("d-m-Y",strtotime($resul->fecha_deposito));
//             $nro_deposito = $resul->nro_deposito;
//             $monto_deposito = $resul->monto_deposito;
//             $AddEdit_derechollave = 'edit_derechollave';

//         }else{
//             $msm = 'Error: No se guardo el registro';
//         }
//     }
//     else{
//         $fecha_deposito = date("Y-m-d",strtotime($this->request->getPost('fecha_deposito')));
//         $resul = new Garantias();
//         $resul->contratoproducto_id = $this->request->getPost('contratoproducto_id');
//         $resul->tipo=2;
//         $resul->fecha_deposito = $fecha_deposito;
//         $resul->nro_deposito = $this->request->getPost('nro_deposito');
//         $resul->monto_deposito = $this->request->getPost('monto_deposito');
//         $resul->baja_logica = 1;
//         if ($resul->save()) {
//             $msm = 'Exito: Se guardo correctamente';
//             $garantia_id = $resul->id;
//             $fecha_deposito = date("d-m-Y",strtotime($resul->fecha_deposito));
//             $nro_deposito = $resul->nro_deposito;
//             $monto_deposito = $resul->monto_deposito;
//             $AddEdit_derechollave = 'edit_derechollave';

//         }else{
//             $msm = 'Error: No se guardo el registro';
//         }
//     }   
// }
// $html = '
// <td><a href="javascript:void(0)" id="'.$AddEdit_derechollave.'" garantia_id="'.$garantia_id.'" fecha_deposito="'.$fecha_deposito.'" nro_deposito="'.$nro_deposito.'" monto_deposito="'.$monto_deposito.'" ><strong>DERECHO DE LLAVE </strong></a></td>
// <td><strong>Fecha Deposito: </strong> '.$fecha_deposito.'</td>
// <td><strong>Nro Deposito: </strong> '.$nro_deposito.'</td>
// <td><strong>Monto Depositado: </strong> '.$monto_deposito.'</td>
// <td colspan="3"></td>
// ';
// $this->view->disable();
// echo $html;
// }


// public function savegarantiaAction()
// {
//     $garantia_id = '';
//     $fecha_deposito = '';
//     $nro_deposito = '';
//     $monto_deposito = '';

//     $fecha_devolucion = '';
//     $nro_devolucion = '';
//     $monto_devolucion = '';

//     $AddEdit_derechollave = 'add_garantia';
//     if (isset($_POST['garantia_id'])) {
//         if ($_POST['garantia_id']>0) {
//          $fecha_deposito = date("Y-m-d",strtotime($this->request->getPost('fecha_deposito')));
//          if ($this->request->getPost('fecha_devolucion') !='') {
//             $fecha_devolucion = date("Y-m-d",strtotime($this->request->getPost('fecha_devolucion')));    
//         }else{
//             $fecha_devolucion = null;
//         }

//         $resul = Garantias::findFirstById($_POST['garantia_id']);
//         $resul->fecha_deposito = $fecha_deposito;
//         $resul->nro_deposito = $this->request->getPost('nro_deposito');
//         $resul->monto_deposito = $this->request->getPost('monto_deposito');

//         $resul->fecha_devolucion = $fecha_devolucion;
//         $resul->nro_devolucion = $this->request->getPost('nro_devolucion');
//         $resul->monto_devolucion = $this->request->getPost('monto_devolucion');
//         if ($resul->save()) {
//             $msm = 'Exito: Se guardo correctamente';
//             $garantia_id = $resul->id;
//             $fecha_deposito = date("d-m-Y",strtotime($resul->fecha_deposito));
//             $nro_deposito = $resul->nro_deposito;
//             $monto_deposito = $resul->monto_deposito;

//             if ($resul->fecha_devolucion !=null) {
//                 $fecha_devolucion = date("d-m-Y",strtotime($resul->fecha_devolucion));
//             }else{
//                 $fecha_devolucion = null;
//             }
//             $nro_devolucion = $resul->nro_devolucion;
//             $monto_devolucion = $resul->monto_devolucion;
//             $AddEdit_derechollave = 'edit_garantia';

//         }else{
//             $msm = 'Error: No se guardo el registro';
//         }
//     }
//     else{
//         $fecha_deposito = date("Y-m-d",strtotime($this->request->getPost('fecha_deposito')));
//         if ($this->request->getPost('fecha_devolucion') !='') {
//             $fecha_devolucion = date("Y-m-d",strtotime($this->request->getPost('fecha_devolucion')));    
//         }else{
//             $fecha_devolucion = null;
//         }    
//         $resul = new Garantias();
//         $resul->contratoproducto_id = $this->request->getPost('contratoproducto_id');
//         $resul->tipo=1;
//         $resul->fecha_deposito = $fecha_deposito;
//         $resul->nro_deposito = $this->request->getPost('nro_deposito');
//         $resul->monto_deposito = $this->request->getPost('monto_deposito');

//         $resul->fecha_devolucion = $fecha_devolucion;
//         $resul->nro_devolucion = $this->request->getPost('nro_devolucion');
//         $resul->monto_devolucion = $this->request->getPost('monto_devolucion');

//         $resul->baja_logica = 1;
//         if ($resul->save()) {
//             $msm = 'Exito: Se guardo correctamente';
//             $garantia_id = $resul->id;
//             $fecha_deposito = date("d-m-Y",strtotime($resul->fecha_deposito));
//             $nro_deposito = $resul->nro_deposito;
//             $monto_deposito = $resul->monto_deposito;


//             if ($resul->fecha_devolucion !=null) {
//                 $fecha_devolucion = date("d-m-Y",strtotime($resul->fecha_devolucion));
//             }else{
//                 $fecha_devolucion = null;
//             }
//             $nro_devolucion = $resul->nro_devolucion;
//             $monto_devolucion = $resul->monto_devolucion;
//             $AddEdit_derechollave = 'edit_garantia';

//         }else{
//             $msm = 'Error: No se guardo el registro';
//         }
//     }   
// }
// $html = '
// <td><a href="javascript:void(0)" id="'.$AddEdit_derechollave.'" garantia_id="'.$garantia_id.'" fecha_deposito="'.$fecha_deposito.'" nro_deposito="'.$nro_deposito.'" monto_deposito="'.$monto_deposito.'" fecha_devolucion="'.$fecha_devolucion.'" nro_devolucion="'.$nro_devolucion.'" monto_devolucion="'.$monto_devolucion.'" ><strong>GARANTIA </strong></a></td>
// <td><strong>Fecha Deposito: </strong> '.$fecha_deposito.'</td>
// <td><strong>Nro Deposito: </strong> '.$nro_deposito.'</td>
// <td><strong>Monto Depositado: </strong> '.$monto_deposito.'</td>

// <td><strong>Fecha Devolución: </strong> '.$fecha_devolucion.'</td>
// <td><strong>Nro Devolución: </strong> '.$nro_devolucion.'</td>
// <td><strong>Monto Devolución: </strong> '.$monto_devolucion.'</td>
// ';
// $this->view->disable();
// echo $html;
// }



    
    public function deletedepositoAction()
    {
        $resul = Planpagodepositos::findFirstById($_POST['planpagodeposito_id']);
        $resul->baja_logica = 0;
        if ($resul->save()) {
            $planpago = Planpagos::findFirstById($resul->planpago_id);
            $this->modificacionplanpagos($planpago->contratoproducto_id);
            $this->modificacionmora($planpago->id);
            $msm = 'Exito: Se elimino correctamente';
        }else{
            $msm = 'Error: No se elimino el registro';
        }

        $this->view->disable();
        echo json_encode($msm);
    }

    public function reporteAction($contratoproducto_id)
    {
include_once('tbs_us/tbs_class.php'); // Load the TinyButStrong template engine
include_once ('tbs_us/tbs_plugin_opentbs/tbs_plugin_opentbs.php'); // Load the OpenTBS plugin
$this->view->disable();

$model = new Planpagos();
$resul = $model->getcontrato($contratoproducto_id);
$this->view->setVar('contratoproducto',$resul[0]);
$garantia = Garantias::find(array('baja_logica=1 and contratoproducto_id = '.$contratoproducto_id, 'order'=>'tipo,fecha_deposito ASC'));
// $derechollave = Garantias::findFirst(array('baja_logica=1 and tipo=2 and contratoproducto_id = '.$contratoproducto_id, 'order'=>'tipo ASC'));



$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

$TBS->VarRef['usuario'] = $this->_user->nombre.' '.$this->_user->paterno;
$TBS->VarRef['contrato'] = $resul[0]->contrato;
$TBS->VarRef['razon_social'] = $resul[0]->razon_social;
$TBS->VarRef['fecha_inicio'] = date('d-m-Y',strtotime($resul[0]->fecha_inicio));
$TBS->VarRef['fecha_fin'] = date('d-m-Y',strtotime($resul[0]->fecha_fin));
$TBS->VarRef['grupo'] = $resul[0]->grupo;
$TBS->VarRef['linea'] = $resul[0]->linea;
$TBS->VarRef['estacion'] = $resul[0]->estacion;
$TBS->VarRef['producto'] = $resul[0]->producto;



$model = new Planpagos();
$resul = $model->listacontrolpago($contratoproducto_id);
$contrato = $model->datoscontrato($contratoproducto_id);
    $hoy = date("Y-m-d");
    // $dias =10;
    // $fecha_10 = date("Y-m-d",strtotime( '+'.$dias.' day' , strtotime($hoy)));
$data = array(); 
    foreach ($resul as $v) {
        $html = $this->depositos($v->id,$v->diferencia,1);

        $diff = $v->monto_programado-$v->monto_reprogramado;
        $diff_text = '';
        if($diff>0){
        $diff_text = '<span class="label label-primary" style="float:left">'.number_format($diff,2,".",",").'</span>';
        }

        /* calculo de mora */
        $dias_atraso = '';
        $mora='';
        $fecha_tolerancia = date("Y-m-d",strtotime( '+'.$contrato[0]->dias_tolerancia.' day' , strtotime($v->fecha_programado)));
        if ($fecha_tolerancia<date("Y-m-d")) {
            if ($v->mora>0) {
                $dias_atraso = $v->dias_atraso;
                $mora=$v->mora;
            }elseif($v->deposito_total<$v->monto_reprogramado) {
                $datetime1 = new DateTime($fecha_tolerancia);
                $datetime2 = new DateTime(date("Y-m-d"));
                $interval = $datetime1->diff($datetime2);
                $dias_atraso = $interval->format('%R%a');
                $mora=($contrato[0]->total/$contrato[0]->nro_dias*$contrato[0]->porcentaje_mora)*$dias_atraso;
            }
        }
        /* fin calculo de mora*/

        $data[] = array('rank'=> 'A', 'fecha_programado'=>date("d-m-Y",strtotime($v->fecha_programado)) , 'monto_programado'=>$v->monto_reprogramado, 'nro_factura'=>str_replace("</div>","\n",str_replace("<div>", "" , $html[6])),'fecha_factura'=>str_replace("</div>","\n",str_replace("<div>", "" , $html[7])), 'monto_factura'=>str_replace("</div>","\n",str_replace("<div>", "" , $html[8])), 'nro_deposito'=>str_replace("</div>","\n",str_replace("<div>", "" , $html[0])),'fecha_deposito'=>str_replace("</div>","\n",str_replace("<div>", "" , $html[1])),'monto_deposito'=>str_replace("</div>","\n",str_replace("<div>", "" , $html[2])),'dias_atraso'=>$v->dias_atraso,'mora'=>$mora
            , 'nro_deposito_mora'=>str_replace("</div>","\n",str_replace("<div>", "" , $html[3])),'fecha_deposito_mora'=>str_replace("</div>","\n",str_replace("<div>", "" , $html[4])),'monto_deposito_mora'=>str_replace("</div>","\n",str_replace("<div>", "" , $html[5])),'factura_total'=>$v->factura_total,'deposito_total'=>$v->deposito_total,'mora_total'=>$v->mora_total);
    
    }

$data1 = array(); 
    foreach ($garantia as $g) {
        $data1[] = array('rank'=> 'C','tipo'=>$this->tipo[$g->tipo], 'nro_deposito'=>$g->nro_deposito,'fecha_deposito'=>date("d-m-Y",strtotime($g->fecha_deposito)), 'monto_deposito'=>$g->monto_deposito);
    }

$template = 'file/template/temp_reporte_planpagos.xlsx';
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

// ----------------------
// Debug mode of the demo
// ----------------------
// if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
// if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
// if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

// Merge data in the first sheet
$TBS->MergeBlock('a,b', $data);
$TBS->MergeBlock('c,d', $data1);

// -----------------
// Output the result
// -----------------
// $output_file_name = str_replace('.', '_'.date('Y-m-d').'.', $template);
$output_file_name = date('Y-m-d').' '.'reporte.xlsx';
$TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
exit();

}


// /*Funcion para borrar */
// private function htmlcontrolpagos($contratoproducto_id)
// {
//     $cp = Contratosproductos::findFirstById($contratoproducto_id);
//     if ($cp != false) {
//         //$resul = Planpagos::find(array("baja_logica = 1 and contratoproducto_id = ".$contratoproducto_id, 'order'=>'fecha_programado ASC'));
//         $model = new Planpagos();
//         $resul = $model->listadoplanpago($contratoproducto_id);
//         $datos = array();
//         $id = 0;
//         $hoy = date("Y-m-d");
//         // $hoy = new DateTime();
//         // $fecha->add(new DateInterval('P10D'));
//         // echo $fecha->format('Y-m-d') . "\n";
//         foreach ($resul as $v) {
//             $datos[$v->id][$v->planpagodeposito_id]['id']=$v->planpagodeposito_id;
//             $datos[$v->id][$v->planpagodeposito_id]['fecha_programado']=$v->fecha_programado;
//             $datos[$v->id][$v->planpagodeposito_id]['monto_programado']=$v->monto_programado;
//             $datos[$v->id][$v->planpagodeposito_id]['mora']=$v->mora;
//             $datos[$v->id][$v->planpagodeposito_id]['dias_atraso']=$v->dias_atraso;
//             $datos[$v->id][$v->planpagodeposito_id]['nro_deposito']=$v->nro_deposito;
//             $datos[$v->id][$v->planpagodeposito_id]['fecha_deposito']=$v->fecha_deposito;
//             $datos[$v->id][$v->planpagodeposito_id]['monto_deposito']=$v->monto_deposito;
//             $datos[$v->id][$v->planpagodeposito_id]['tipo_deposito']=$v->tipo_deposito;
//             $datos[$v->id][$v->planpagodeposito_id]['monto_reprogramado']=$v->monto_reprogramado;
//             $datos[$v->id][$v->planpagodeposito_id]['diferencia']=$v->diferencia;
//         }
//         //echo var_dump($datos);
//         $html='<div class="table-responsive">
//                 <table class="table table-vcenter table-striped table-hover table-condensed">
//                             <thead>
//                                 <tr>
//                                     <th>Fecha Programado</th>
//                                     <th>Monto Programado</th>
//                                     <th class="tdFacDep">Nro Factura</th>
//                                     <th>Fecha Factura</th>
//                                     <th>Monto Facturado</th>
//                                     <th class="tdFacDep">Nro Deposito</th>
//                                     <th>Fecha Deposito</th>
//                                     <th>Monto Deposito</th>
//                                     <th>Dias Atraso</th>
//                                     <th>Mora</th>
//                                     <th class="tdFacDep">Nro Deposito Mora</th>
//                                     <th>Fecha Deposito Mora</th>
//                                     <th>Monto Deposito Mora</th>';
//                                     if ($this->_user->nivel==2) {
//                                         $html.='<th style="width: 150px;" class="text-center">Acción
//                                         <a href="javascript:void(0)" data-toggle="tooltip" title="Ver Nro de Facturas y Nro Deposito" id="verFacDep"><i class="fa fa-search-plus"></i></a>
//                                         </th>';    
//                                     }
//                                 $html.='</tr>
//                             </thead>
//                             <tbody>';
        
//         $total=0;
//         $t_deposito=0;
//         $total_mora = 0;
//         $total_deposito_mora = 0;
//         foreach ($resul as $v) {
//             if ($id != $v->id) {
//                 $total+=$v->monto_programado;
//                 $div_nrodeposito = '';
//                 $div_fecha_deposito = '';
//                 $div_monto_deposito = '';


//                 $div_nrodeposito_mora = '';
//                 $div_fecha_deposito_mora = '';
//                 $div_monto_deposito_mora = '';
//                 $dias = 10; // numero de dias antes de la fecha programada para mostrar el color amarillo
//                 $diff = $v->monto_programado-$v->monto_reprogramado;
//                 $diff_text = '';
//                 if($diff>0){
//                     $diff_text = '<span class="label label-primary">'.$diff.'</span>';
//                 }
//                 $html.='<tr id="html'.$v->id.'">
                            
//                             <td >'.date("d-m-Y",strtotime($v->fecha_programado)).'</td>
//                             <td class="text-right">'.$diff_text.' '.number_format($v->monto_reprogramado,2,'.',',').'</td>
//                             <td class="tdFacDep"></td>
//                             <td ></td>
//                             <td ></td>';
//                                 $total_deposito = 0;
                                
//                                 $color = '';
//                                 $masmenos = '';
//                                 //<span class="badge">8</span>
//                                 foreach ($datos[$v->id] as $k => $m) {
//                                     if ($datos[$v->id][$k]['tipo_deposito']==1) {
//                                         $div_nrodeposito .=$datos[$v->id][$k]['nro_deposito'].'<br>';
//                                         $div_fecha_deposito .=date("d-m-Y",strtotime($datos[$v->id][$k]['fecha_deposito'])).'<br>';
//                                         $div_monto_deposito .=number_format($datos[$v->id][$k]['monto_deposito'],2,'.',',').'<br>';    
//                                         $total_deposito += $datos[$v->id][$k]['monto_deposito'];
//                                         $t_deposito+=$datos[$v->id][$k]['monto_deposito'];
//                                     }else{
//                                         $div_nrodeposito_mora .=$datos[$v->id][$k]['nro_deposito'].'<br>';
//                                         $fdm=$datos[$v->id][$k]['fecha_deposito']!='' ? date("d-m-Y",strtotime($datos[$v->id][$k]['fecha_deposito'])) : '';
//                                         $div_fecha_deposito_mora .= $fdm .'<br>';
//                                         $div_monto_deposito_mora .= number_format($datos[$v->id][$k]['monto_deposito'],2,'.',',').'<br>';    
//                                         $total_deposito_mora+=$datos[$v->id][$k]['monto_deposito'];
//                                     }
                                    

//                                 }
//                                 $hoy10 = date("Y-m-d",strtotime( '+'.$dias.' day' , strtotime($hoy)));
//                                 if ($hoy>=$v->fecha_programado && $total_deposito<$v->monto_reprogramado) {
//                                     $color = 'danger';
//                                 }elseif ($hoy10>=$v->fecha_programado && $total_deposito<$v->monto_reprogramado) {
//                                     $color = 'warning';
//                                 }elseif ($total_deposito>=$v->monto_reprogramado) {
//                                     $color = 'success';
//                                 }
//                                 $diff_text = '';
//                                 if($v->diferencia!=0)
//                                     $diff_text = '<span class="label label-'.$color.'">'.$v->diferencia.'</span>';

//                                 //calculo de mora
//                                 $color_mora = '';
//                                 $model = new Planpagodepositos();
//                                 $resulmora = $model->getdatosverificar($v->id,2);
//                                 $dias_atraso = '';
//                                 $mora='';
//                                 foreach ($resulmora as $rm) {
//                                     $fecha_tolerancia = date("Y-m-d",strtotime( '+'.$rm->dias_tolerancia.' day' , strtotime($v->fecha_programado)));
//                                     if ($fecha_tolerancia<date("Y-m-d")) {
//                                         if ($v->mora>0) {
//                                             if ($v->mora > $rm->deposito) {
//                                                 $color_mora = 'danger';
//                                             }else{
//                                                 $color_mora = 'success';
//                                             }
//                                             $dias_atraso = $v->dias_atraso;
//                                             $mora=$v->mora;
//                                         }else{
//                                             if ($total_deposito<$v->monto_reprogramado) {
//                                                 $nuevafecha = strtotime ( '+'.$rm->dias_tolerancia.' day' , strtotime ( $v->fecha_programado ) ) ;
//                                                 $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

//                                                 $datetime1 = new DateTime($nuevafecha);
//                                                 $datetime2 = new DateTime(date("Y-m-d"));
//                                                 $interval = $datetime1->diff($datetime2);
//                                                 $dias_atraso = $interval->format('%R%a');
//                                                 $mora=($rm->total/$rm->nro_dias*$rm->porcentaje_mora)*$dias_atraso;
//                                                 $color_mora = 'danger';    
//                                             }else{
//                                                 $color_mora = 'success';   
//                                             }
                                            
//                                         }
//                                         $total_mora+=$mora;
//                                     }
//                                 }
                                

//                                 $html.='<td class="'.$color.' tdFacDep">'.$div_nrodeposito.'</td>
//                                 <td class="'.$color.'">'.$div_fecha_deposito.'</td>
//                                 <td class="'.$color.' text-right"> '.$masmenos.' '.$div_monto_deposito.' '.$diff_text.'</td>
//                                 <td class="'.$color_mora.' ">'.$dias_atraso.'</td>
//                                 <td class="'.$color_mora.' text-right">'.number_format($mora, 2, '.',',').'</td>
//                                 <td class="'.$color_mora.' tdFacDep">'.$div_nrodeposito_mora.'</td>
//                                 <td class="'.$color_mora.'">'.$div_fecha_deposito_mora.'</td>
//                                 <td class="'.$color_mora.' text-right">'.$div_monto_deposito_mora.'</td>';
//                                 if ($this->_user->nivel==2) {
//                         $html.='<td class="text-center">
//                                     <div class="btn-group btn-group-xs">
//                                         <a href="javascript:void(0)" data-toggle="tooltip" title="Realizar deposito" class="btn btn-primary reg_deposito" planpago_id ="'.$v->id.'" tipo_deposito="1" texto="Registrar Deposito"><i class="fa fa-tag"></i></a>
//                                         <a href="javascript:void(0)" data-toggle="tooltip" title="Editar Depositos" class="btn btn-warning edit_deposito" planpago_id ="'.$v->id.'"><i class="fa fa-pencil"></i></a>
//                                         <a href="javascript:void(0)" data-toggle="tooltip" title="Realizar deposito" class="btn btn-default reg_deposito" planpago_id ="'.$v->id.'" tipo_deposito="2" texto="Registrar Deposito Mora"><i class="fa fa-tags"></i></a>
//                                     </div>
//                                 </td>';
//                                 }
//                         $html.='</tr>';
//                 }
                           
//             $id = $v->id;
//         }
//          $html .='<tr class= "text-right">
                                    
//                                     <th>TOTAL</th>
//                                     <td>'.number_format($total,2,'.',',').'</td>
//                                     <td class="tdFacDep"></td>
//                                     <td></td>
//                                     <td>'.number_format($t_deposito,2,'.',',').'</td>
//                                     <td class="tdFacDep"></td>
//                                     <td></td>
//                                     <td>'.number_format($t_deposito,2,'.',',').'</td>
//                                     <td></td>
//                                     <td>'.number_format($total_mora,2,'.',',').'</td>
//                                     <tdclass="tdFacDep"></td>
//                                     <td></td>
//                                     <td>'.number_format($total_deposito_mora,2,'.',',').'</td>';
//                                     if ($this->_user->nivel==2) {
//                                     $html .='<td></td>';
//                                     }
//                                 $html .='</tr>'; 
//         $html .='</tbody>
//                 </table>
//                 </div>';
//         }
//         return $html;
//         //$this->view->setVar('htmlp',$html);
// }


public function htmldepositosAction()
{
    $resul = Planpagos::findFirstById($_POST['planpago_id']);
    $pp_deposito = Planpagodepositos::find(array("planpago_id=".$_POST['planpago_id']." and baja_logica = 1 and tipo_deposito =1","order"=>"fecha_deposito ASC"));
    $pp_deposito_mora = Planpagodepositos::find(array("planpago_id=".$_POST['planpago_id']." and baja_logica = 1 and tipo_deposito =2","order"=>"fecha_deposito ASC"));

    $html='<div class="table-responsive">
    <table class="table table-vcenter table-striped">
        <thead>
            <tr>
                <td colspan="2"><strong>Fecha Programada: </strong>'.$resul->fecha_programado.' </td>
                <td colspan="2"><strong>Monto Programada Bs.: </strong> '.$resul->monto_reprogramado.'</td>
            </tr>
            <tr>
                <th>Nro Deposito</th>
                <th>Fecha Deposito</th>
                <th>Monto Deposito</th>
                <th></th>
            </tr>
        </thead>
        <tbody>';
        foreach ($pp_deposito as $v) {
            $html.='<tr>
                <td>'.$v->nro_deposito.'</td>
                <td>'.$v->fecha_deposito.'</td>
                <td>'.$v->monto_deposito.'</td>
                <td class="text-center">
                     <div class="btn-group btn-group-xs">
                         <a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar Deposito" class="btn btn-danger eliminar_deposito" planpagodeposito_id ="'.$v->id.'"><i class="fa fa-trash-o"></i></a>
                     </div>
                </td>
            </tr>';    
        }
        
            $html.='<tr>
                <td colspan="2"><strong>Dias Atraso: </strong> '.$resul->dias_atraso.'</td>
                <td colspan="2"><strong>Mora: </strong> '.$resul->mora.'</td>
            </tr>';
        foreach ($pp_deposito_mora as $v) {
            $html.='<tr>
                <td>'.$v->nro_deposito.'</td>
                <td>'.$v->fecha_deposito.'</td>
                <td>'.$v->monto_deposito.'</td>
                <td class="text-center">
                     <div class="btn-group btn-group-xs">
                         <a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar Deposito" class="btn btn-danger eliminar_deposito" planpagodeposito_id ="'.$v->id.'"><i class="fa fa-trash-o"></i></a>
                     </div>
                </td>
            </tr>';    
        }
        $html.='</tbody>
    </table>
</div>';

    $this->view->disable();
    echo $html;
}


// derecho de llave y garantia
public function listgarantiaAction($contratoproducto_id)
{
    $resul = Garantias::find(array("baja_logica=1 and contratoproducto_id='$contratoproducto_id' and tipo in (1,2)",'order'=>'tipo, fecha_deposito'));
    // $tipo =array('1'=>'Garantia','2'=>'Derecho de Llave');
    foreach ($resul as $v) {
        $customers[] = array(
            'id' => $v->id,
            'tipo' => $v->tipo,
            'tipo_text' =>$this->tipo[$v->tipo],
            'fecha_deposito' => $v->fecha_deposito.' 00:00:00',
            'nro_deposito' => $v->nro_deposito,
            'monto_deposito' => $v->monto_deposito,
            'accion' => '<a class="btn btn-xs btn-warning" onclick="editar_garantia()" title="Editar"><i class="fa fa-pencil"></i></a>'.
                '<a class="btn btn-xs btn-danger" onclick="eliminar_garantia()" title="Eliminar"><i class="fa fa-times"></i></a>',
        );
    }
    $this->view->disable();
    echo json_encode($customers);
}

// devolucion derecho de llave y garantia
public function listdevoluciongarantiaAction($contratoproducto_id)
{
    $resul = Garantias::find(array("baja_logica=1 and contratoproducto_id='$contratoproducto_id' and tipo in (3,4)",'order'=>'tipo, fecha_deposito'));
    // $tipo =array('3'=>'Devolución Garantia','4'=>'Devolución Derecho de Llave');
    foreach ($resul as $v) {
        $customers[] = array(
            'id' => $v->id,
            'tipo' => $v->tipo,
            'tipo_text' => $this->tipo[$v->tipo],
            'fecha_deposito' => $v->fecha_deposito.' 00:00:00',
            'nro_deposito' => $v->nro_deposito,
            'monto_deposito' => $v->monto_deposito,
            'accion' => '<a class="btn btn-xs btn-warning" onclick="editar_devolucion()" title="Editar"><i class="fa fa-pencil"></i></a>'.
                '<a class="btn btn-xs btn-danger" onclick="eliminar_devolucion()" title="Eliminar"><i class="fa fa-times"></i></a>',
        );
    }
    $this->view->disable();
    echo json_encode($customers);
}


public function savegarantiaAction()
{
    if ($this->request->isPost()) {
        if ($_POST['garantia_id']>0) {
        $fecha_deposito = date("Y-m-d",strtotime($this->request->getPost('fecha_deposito')));
         
        $resul = Garantias::findFirstById($_POST['garantia_id']);
        $resul->fecha_deposito = $fecha_deposito;
        $resul->nro_deposito = $this->request->getPost('nro_deposito');
        $resul->monto_deposito = $this->request->getPost('monto_deposito');
            if ($resul->save()) {
                $msm = 'Exito: Se guardo correctamente';
            }else{
                $msm = 'Error: No se guardo el registro';
            }
        }
    else{
        $resul = new Garantias();
        $resul->contratoproducto_id = $this->request->getPost('contratoproducto_id');
        $resul->tipo=$this->request->getPost('tipo');
        $resul->fecha_deposito =  date("Y-m-d",strtotime($this->request->getPost('fecha_deposito')));
        $resul->nro_deposito = $this->request->getPost('nro_deposito');
        $resul->monto_deposito = $this->request->getPost('monto_deposito');
        $resul->fecha_devolucion = '';
        $resul->nro_devolucion = '';
        $resul->monto_devolucion = '';
        $resul->baja_logica = 1;
        if ($resul->save()) {
            $msm = 'Exito: Se guardo correctamente';
        }else{
            $msm = 'Error: No se guardo el registro';
        }
    }   
}
$this->view->disable();
echo $html;
}

 public function deletegarantiaAction()
    {
        $resul = Garantias::findFirstById($_POST['id']);
        $resul->baja_logica = 0;
        if ($resul->save()) {
            $msm = 'Exito: Se elimino correctamente';
        }else{
            $msm = 'Error: No se elimino el registro';
        }

        $this->view->disable();
        echo json_encode($msm);
    }

}