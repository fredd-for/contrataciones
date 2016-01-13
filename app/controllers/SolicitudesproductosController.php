<?php 
/**
* 
*/
class SolicitudesproductosController extends ControllerBase
{
	
	public function indexAction()
	{

	}

    public function listAction($solicitud_id='')
    {
        $model = new Solicitudesproductos();
        $resul = $model->lista($solicitud_id);
        $this->view->disable();
        $customers = array();
        foreach ($resul as $v) {
            $customers[] = array(
                'id' => $v->id,
                'solicitud_id' => $v->solicitud_id,
                'producto_id' => $v->producto_id,
                'grupo' => $v->grupo,
                'linea' => $v->linea,
                'estacion' => $v->estacion,
                'codigo' => $v->codigo,
                'producto' => $v->producto,
                'precio_tiempo' => $v->precio_unitario.' Bs. x '.$v->tiempo,
                'precio_unitario' => $v->precio_unitario,
                'tiempo' =>$v->tiempo,
                'cantidad' => $v->cantidad,
                );
        }
        echo json_encode($customers);
    }

    public function crearAction($solicitud_id='')
    {

        $tiempo = $this->tag->selectStatic(
            array(
                "tiempo",
                array(
                    "Hora" => "Hora",
                    "Dia"   => "Dia",
                    "Mensual" => "Mensual",
                    ),
                'useEmpty' => true,
                'emptyText' => '(Selecionar)',
                'emptyValue' => '',
                'class' => 'form-control',
                'required' => 'required',
                'title' => 'Campo requerido'
                )
            );
        $this->view->setVar('tiempo', $tiempo);
        
        $model = new Solicitudes();
        $resul = $model->listSolicitudes($solicitud_id);
        $solicitud=array();
        foreach ($resul as $v) {
            $solicitud = $v;  
        }
        $this->view->setVar('solicitud',$solicitud);
        
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
                // ->addJs('/js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')
                // ->addJs('/media/plugins/form-validation/jquery.validate.min.js')
                // ->addJs('/assets/js/plugins.js')
                // ->addJs('/assets/js/pages/formsValidation.js')

        ->addJs('/scripts/solicitudesproductos/crear.js');
    }

    public function saveAction()
    {
        if (isset($_POST['id'])) {
            if ($_POST['id']>0) {
            }
            else{
                $solicitud_id = $this->request->getPost('solicitud_id');
                $producto_id = $this->request->getPost('producto_id');
                $precio_unitario = $this->request->getPost('precio_unitario');
                $cantidad = $this->request->getPost('cantidad');

                $resul = new Solicitudesproductos();
                $resul->solicitud_id= $solicitud_id;
                $resul->producto_id = $producto_id;
                $resul->precio_unitario = $precio_unitario;
                $resul->tiempo = $this->request->getPost('tiempo');
                $resul->cantidad = $cantidad;
                $resul->baja_logica = 1;
                $resul->estado = 1;
                if ($resul->save()) {
                    $resul2 = Productos::findFirstById($this->request->getPost('producto_id'));
                    $resul2->cant_solicitud = $resul2->cant_solicitud + $this->request->getPost('cantidad');
                    $resul2->save();
                    $msm ='Exito: Se guardo correctamente';    
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
            }   
        }
        $this->view->disable();
        echo $msm;
    }

    public function quitarAction()
    {
        $resul = Solicitudesproductos::findFirstById($this->request->getPost('id'));
        $resul->baja_logica = 0;
        if ($resul->save()) {
            $resul2 = Productos::findFirstById($resul->producto_id); 
            $resul2->cant_solicitud = $resul2->cant_solicitud - $resul->cantidad;
            $resul2->save();
            $msm ='Exito: Se retiro el producto correctamente';
        }else{
            $msm = 'Error: No se retiro el producto';
        }
        $this->view->disable();
        echo $msm;
    }

    public function clientesolicitudAction()
    {
        $producto_id = $this->request->getPost('producto_id');
        $model = new Solicitudesproductos();
        $resul = $model->clientessolicitudes($producto_id);
        $html = '';
        if (count($resul)>0) {
            $html = '<table class="table table-vcenter table-striped">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Cant. Solicitada</th>
                    <th>Fecha Solicitud</th>
                </tr>
            </thead>
            <tbody>';
                foreach ($resul as $v) {
                    $html.='<tr>
                    <td>'.$v->razon_social.'</td>
                    <td>'.$v->cantidad.'</td>
                    <td>'.date("d-m-Y",strtotime($v->fecha_recepcion_solicitud)).'</td>
                </tr>';
            }
            $html.='</tbody>
        </table>
        <hr>';            
    }
        $this->view->disable();
        echo $html;
    }

}
