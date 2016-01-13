<?php 
/**
* 
*/
class FacturasController extends ControllerBase
{
    
    public function indexAction()
    {
        $this->assets
                ->addCss('/jqwidgets/styles/jqx.base.css')
                ->addCss('/jqwidgets/styles/jqx.custom.css')
                //->addCss('/js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css')
                //->addCss('/media/plugins/form-stepy/jquery.stepy.css')
                ;
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
                ->addJs('/media/plugins/bootbox/bootbox.min.js')
                ->addJs('/jqwidgets/jqxtooltip.js')
                // ->addJs('/js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')
                // ->addJs('/media/plugins/form-validation/jquery.validate.min.js')
                // ->addJs('/assets/js/plugins.js')
                // ->addJs('/assets/js/pages/formsValidation.js')
                
                ->addJs('/scripts/facturas/index.js')
        ;
    }

    public function listAction()
    {   $this->view->disable();
        $model = new Facturas();
        $resul = $model->lista();
        $customers = array();
        foreach ($resul as $v) {
            //echo 'ver =>'.$v->id;
            $customers[] = array(
                'id' => $v->id,
                'razon_social' => $v->razon_social,
                'nit' => $v->nit,
                'grupo' => $v->grupo,
                'linea' => $v->linea,
                'estacion' => $v->estacion,
                'contrato' => $v->contrato,
                'producto' => $v->producto,
                'fecha_programado' => $v->fecha_programado.' 00:00:00',
                'monto_reprogramado' => $v->monto_reprogramado,
                'diferencia_dias' => $v->diferencia_dias,
            );
        }
        echo json_encode($customers);
        
    }


    public function listfacturasAction()
    {   $this->view->disable();
        $model = new Facturas();
        $resul = $model->listafacturas();
        $customers = array();
        foreach ($resul as $v) {
            //echo 'ver =>'.$v->id;
            $customers[] = array(
                'id' => $v->id,
                'razon_social' => $v->razon_social,
                'nit' => $v->nit,
                'grupo' => $v->grupo,
                'linea' => $v->linea,
                'estacion' => $v->estacion,
                'contrato' => $v->contrato,
                'producto' => $v->producto,
                'fecha_programado' => $v->fecha_programado.' 00:00:00',
                'monto_reprogramado' => $v->monto_reprogramado,
                'diferencia_dias' => $v->diferencia_dias,
                'planpagofactura_id' => $v->planpagofactura_id,
                'fecha_factura' => $v->fecha_factura.' 00:00:00',
                'fecha_recepcion_cliente' => $v->fecha_recepcion_cliente.' 00:00:00',
                'monto_factura' => $v->monto_factura,
                'nro_factura' => $v->nro_factura,
                'fecha_reg' => $v->fecha_reg,
            );
        }
        echo json_encode($customers);
        
    }

    public function saveAction()
    {
        if (isset($_POST['id'])) {
            if ($_POST['id']>0) {
                $resul = Planpagofacturas::findFirstById($_POST['id']);
                $resul->fecha_factura = date("Y-m-d",strtotime($_POST['fecha_factura']));
                $resul->fecha_recepcion_cliente = date("Y-m-d",strtotime($_POST['fecha_recepcion_cliente']));
                $resul->monto_factura = $_POST['monto_factura'];
                $resul->nro_factura = $_POST['nro_factura'];
                if ($resul->save()) {
                    $msm = 'Exito: Se guardo correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
            }
            else{
                $resul = new Planpagofacturas();
                $resul->planpago_id = $_POST['planpago_id'];
                $resul->fecha_factura = date("Y-m-d",strtotime($_POST['fecha_factura']));
                $resul->fecha_recepcion_cliente = date("Y-m-d",strtotime($_POST['fecha_recepcion_cliente']));
                $resul->monto_factura = $_POST['monto_factura'];
                $resul->nro_factura = $_POST['nro_factura'];
                $resul->fecha_reg = date("Y-m-d H:i:s");
                $resul->usuario_reg = $this->_user->id;
                $resul->estado = 0;
                $resul->baja_logica = 1;
                if ($resul->save()) {
                    // $model = new Planpagofacturas();
                    // $resul2 = $model->getdatoscontrato($resul->id);
                    $msm = 'Exito: Se guardo correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
            }
        }
        $this->view->disable();
        echo json_encode($msm);
    }


    public function deleteAction()
    {
        if (isset($_POST['id'])) {
            if ($_POST['id']>0) {
                $resul = Planpagofacturas::findFirstById($_POST['id']);
                $resul->baja_logica = 0;
                if ($resul->save()) {
                    $msm = 'Exito: Se elimino correctamente';
                }else{
                    $msm = 'Error: No se elimino el registro';
                }
            }
        }
        $this->view->disable();
        echo json_encode($msm);
    }

    
}
