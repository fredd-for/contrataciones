<?php 
/**
* 
*/
class GruposController extends ControllerBase
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
        ->addJs('/media/plugins/form-validation/jquery.validate.min.js')
        ->addJs('/media/plugins/form-stepy/jquery.stepy.js')
        ->addJs('/media/demo/demo-formwizard.js')
        ->addJs('/scripts/grupos/index.js')
        ->addJs('/assets/js/plugins.js')
        ->addJs('/assets/js/pages/formsValidation.js')
        ;

    }

    public function listAction()
    {
      $resul = Grupos::find(array('baja_logica=1','order'=>'id ASC'));
      $this->view->disable();
      foreach ($resul as $v) {
        $customers[] = array(
            'id' => $v->id,
            'grupo' => $v->grupo,
            'sigla' => $v->sigla,
            'descripcion' => $v->descripcion,
            );
        }
        echo json_encode($customers);
    }


public function saveAction()
{
    if (isset($_POST['id'])) {
        if ($_POST['id']>0) {
            $resul = Grupos::findFirstById($this->request->getPost('id'));
            $resul->grupo= $this->request->getPost('grupo');
            $resul->sigla = $this->request->getPost('sigla');
            $resul->descripcion = $this->request->getPost('descripcion');
            if ($resul->save()) {
                $msm ='Exito: Se guardo correctamente';
            }else{
                $msm = 'Error: No se guardo el registro';
            }
        }
        else{
            $resul = new Grupos();
            $resul->grupo= $this->request->getPost('grupo');
            $resul->sigla = $this->request->getPost('sigla');
            $resul->descripcion = $this->request->getPost('descripcion');
            $resul->imagen = '';
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
    $resul = Grupos::findFirstById($this->request->getPost('id'));
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