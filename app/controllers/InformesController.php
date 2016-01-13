<?php 
/**
* 
*/
class InformesController extends ControllerBase
{
	
	public function indexAction()
	{
		$this->assets
        ->addCss('/jqwidgets/styles/jqx.base.css')
        ->addCss('/jqwidgets/styles/jqx.custom.css')
        ->addCss('/assets/css/plugins.css')
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
        
        ->addJs('/assets/js/app.js')
        ->addJs('/assets/js/plugins.js')
        ->addJs('/scripts/informes/index.js')
        ;


// $nivelsalarial = $this->tag->select(
//             array(
//                 'codigo_nivel',
//                 Nivelsalariales::find(array('baja_logica=1',"order"=>"id ASC","columns" => "id,CONCAT(denominacion, ' (', sueldo, ' Bs.)') as fullname")),
//                 //Nivelsalariales::find(array('baja_logica=1','order' => 'id ASC')),
//                 'using' => array('id', "fullname"),
//                 'useEmpty' => true,
//                 'emptyText' => '(Selecionar)',
//                 'emptyValue' => '',
//                 'class' => 'form-control'
//                 )
//             );

        // $model = new Solicitudes();
        // $resul = $model->solicitudesaprobadas();
        // $solicitud = $this->tag->select(
        //     array(
        //         'solicitud_id',
        //         $resul,
        //         'using' => array('id', 'solicitud'),
        //         'useEmpty' => true,
        //         'emptyText' => '(Selecionar)',
        //         'emptyValue' => '',
        //         'class' => 'form-control select-chosen',
        //         'required' => 'required'
        //         )
        //     );
        // $this->view->setVar('solicitud',$solicitud);

    }

    public function listAction()
    {
        $model = new Informes();
        $resul = $model->lista();
        $customers = array();
        foreach ($resul as $v) {
            $customers[] = array(
                'id' => $v->id,
                'razon_social' => $v->razon_social,
                'nro_solicitud' => $v->nro_solicitud,
                'solicitud_id' => $v->solicitud_id,
                'nur' => $v->nur,
                'accion' => '<a href="/informes/seguimiento/?nur='.$v->nur.'" class="btn btn-xs btn-success" title="Seguimiento hoja de ruta"><i class="fa fa-arrow-circle-up"></i></a>',                );
        }
        $this->view->disable();
        echo json_encode($customers);
    }

    public function seguimientoAction()
    {
        $nur = $_GET['nur'];
        //$nur = 'I/2013-06508';
        $model = new Seguimientos();
        $documento = $model->documento($nur);
        $seguimiento = $model->seguimiento($nur);
        
        $this->view->setVar('seguimiento',$seguimiento);
        $this->view->setVar('documento',$documento[0]);



    }

    public function saveAction()
    {
        if (isset($_POST['id'])) {
            if ($_POST['id']>0) {
                $resul = Informes::findFirstById($this->request->getPost('id'));
                $resul->solicitud_id = $this->request->getPost('solicitud_id');
                // $resul->cite = $this->request->getPost('cite');
                $resul->nur = $this->request->getPost('nur');
                if ($resul->save()) {
                    $msm ='Exito: Se guardo correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
            }
            else{
                $resul = new Informes();
                $resul->solicitud_id = $this->request->getPost('solicitud_id');
                $resul->cite ='test' ;//$this->request->getPost('cite');
                $resul->nur =$this->request->getPost('nur');
                $resul->usuario_reg = $this->_user->id;
                $resul->fecha_reg = date("Y-m-d H:i:s");
                $resul->baja_logica = 1;
                if ($resul->save()) {
                    $msm ='Exito: Se guardo correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }    
            }   
        }
        $this->view->disable();
        echo $msm;
    }
    
    public function deleteAction(){
        $resul = Informes::findFirstById($this->request->getPost('id'));
        $resul->baja_logica = 0;
        if ($resul->save()) {
            $msm ='Exito: Se elimino correctamente';
        }else{
            $msm = 'Error: No se guardo el registro';
        }
        $this->view->disable();
        echo $msm;
    }

    public function selectsolicitudesAction()
    {
        $model = new Solicitudes();
        $resul = $model->solicitudesaprobadas();
        $solicitud = $this->tag->select(
            array(
                'solicitud_id',
                $resul,
                'using' => array('id', 'solicitud'),
                'useEmpty' => true,
                'emptyText' => '(Selecionar)',
                'emptyValue' => '',
                'class' => 'form-control select-chosen',
                'required' => 'required'
                )
            );
         $this->view->disable();
        echo $solicitud;
        
    }

}
