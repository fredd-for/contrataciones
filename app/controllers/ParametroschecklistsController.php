<?php 
/**
* 
*/
class ParametroschecklistsController extends ControllerBase
{
	
	public function indexAction()
	{
		$this->assets
        ->addCss('/jqwidgets/styles/jqx.base.css')
        ->addCss('/jqwidgets/styles/jqx.custom.css')
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
        // ->addJs('/media/plugins/form-validation/jquery.validate.min.js')
        // ->addJs('/media/plugins/form-stepy/jquery.stepy.js')
        // ->addJs('/media/demo/demo-formwizard.js')
        ->addJs('/scripts/parametroschecklists/index.js')
        // ->addJs('/assets/js/plugins.js')
        // ->addJs('/assets/js/pages/formsValidation.js')
        ;

        $tipo_empresa = $this->tag->select(
            array(
                'tipo_empresa',
                Parametros::find(array('baja_logica=1 and parametro="checklist_tipoempresas" ','order'=>'nivel ASC')),
                'using' => array('nivel', 'valor_1'),
                'useEmpty' => true,
                'emptyText' => '(Selecionar)',
                'emptyValue' => '',
                'required' => 'required',
                'class' => 'form-control'
                )
            );
        $this->view->setVar('tipo_empresa',$tipo_empresa);

         $si_no_array = array(
                "1" => "SI",
                "0"   => "NO"
                );
        
        $obligatorio = $this->tag->selectStatic(
        array(
            "obligatorio",
            $si_no_array,
            'useEmpty' => false,
            'emptyText' => '(Selecionar)',
            'emptyValue' => '',
            'class' => 'form-control',
            )
        );
        $this->view->setVar('obligatorio',$obligatorio);

        $escaner = $this->tag->selectStatic(
        array(
            "escaner",
            $si_no_array,
            'useEmpty' => false,
            'emptyText' => '(Selecionar)',
            'emptyValue' => '',
            'class' => 'form-control',
            )
        );
        $this->view->setVar('escaner',$escaner);

    }

    public function listAction()
    {
      // $resul = Parametroschecklists::find(array('baja_logica=1','order'=>'id ASC'));
      $model = new Parametroschecklists();
      $resul = $model->lista();

      $this->view->disable();
      foreach ($resul as $v) {
        $customers[] = array(
            'id' => $v->id,
            'parametro' => $v->parametro,
            'abreviado' => $v->abreviado,
            'tipo_empresa' =>$v->tipo_empresa,
            'tipo_empresa_text' =>$v->tipo_empresa_text,
            'obligatorio' =>$v->obligatorio,
            'obligatorio_text' =>$v->obligatorio_text,
            'escaner' =>$v->escaner,
            'escaner_text' =>$v->escaner_text,
            'clase' =>$v->clase,
            );
    }
    echo json_encode($customers);
}


    public function saveAction()
    {
        if (isset($_POST['id'])) {
            if ($_POST['id']>0) {
                $resul = Parametroschecklists::findFirstById($this->request->getPost('id'));
                $resul->parametro= $this->request->getPost('parametro');
                $resul->tipo_empresa= $this->request->getPost('tipo_empresa');
                $resul->obligatorio= $this->request->getPost('obligatorio');
                $resul->escaner= $this->request->getPost('escaner');
                if ($resul->save()) {
                    $msm ='Exito: Se guardo correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
            }
            else{
                $resul = new Parametroschecklists();
                $resul->parametro= $this->request->getPost('parametro');
                $resul->abreviado = "";
                $resul->tipo_empresa= $this->request->getPost('tipo_empresa');
                $resul->obligatorio= $this->request->getPost('obligatorio');
                $resul->escaner= $this->request->getPost('escaner');
                $resul->clase= "";
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
        $resul = Parametroschecklists::findFirstById($this->request->getPost('id'));
        $resul->baja_logica = 0;
        if ($resul->save()) {
            $msm ='Exito: Se elimino correctamente';
        }else{
            $msm = 'Error: No se guardo el registro';
        }
        $this->view->disable();
        echo $msm;
    }




}