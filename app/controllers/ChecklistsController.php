<?php 
/**
* 
*/
class ChecklistsController extends ControllerBase
{
	
	public function indexAction($contrato_id=0)
	{
	
       $this->assets
                ->addCss('/jqwidgets/styles/jqx.base.css')
                ->addCss('/jqwidgets/styles/jqx.custom.css')
                ->addCss('/assets/css/plugins.css')
                ->addCss('/js/fileinput/css/fileinput.min.css')
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
                ->addJs('/jqwidgets/jqxgrid.edit.js')
                ->addJs('/media/plugins/bootbox/bootbox.min.js')
                ->addJs('/jqwidgets/jqxtooltip.js')
                ->addJs('/assets//js/plugins.js')
                ->addJs('/assets/js/app.js')
                ->addJs('/js/fileinput/js/fileinput.min.js')
                ->addJs('/js/fileinput/js/fileinput_locale_es.js')
                // ->addJs('/js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')
                // ->addJs('/media/plugins/form-validation/jquery.validate.min.js')
                // ->addJs('/assets/js/pages/formsValidation.js')
                
                ->addJs('/scripts/checklists/index.js')
        ;


         $resul = Contratos::findFirstById($contrato_id);
         $this->view->setVar('contrato_id',$resul->id);
         $this->view->setVar('cliente_id',$resul->cliente_id);
         $this->view->setVar('contrato_nro',$resul->contrato);
         $this->view->setVar('descripcion',$resul->descripcion);

        $model = new Checklists();
        $listcontratos = $model->getContrato($resul->cliente_id,$resul->id);
        $this->view->setVar('listcontratos',$listcontratos);
   

    }

    public function listAction($contrato_id)
    {
      $model = new Checklists();
      $resul = $model->lista($contrato_id);
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
            'cumple' =>$v->cumple,
            'archivo' => $this->archivo($v->parametro_id,$v->contrato_id),
            'parametro_id' => $v->parametro_id,
            'accion' => '<a class="btn btn-xs btn-sucess" onclick="add_archivo()" title="Adicionar Archivo"><i class="gi gi-upload"></i></a>',
            );
        }
    echo json_encode($customers);
    }

public function editAction()
{
    $model = new Checklists();
    $resul = $model->obtenerarchivos($_POST['parametro_id'],$_POST['contrato_id']);


    $html='<div class="table-responsive">';
        
            if (count($resul)>0) {
                $html.='<table class="table table-vcenter table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre Archivo</th>
                                        <th>Fecha Registro</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>';
                foreach ($resul as $v) {
                    if(file_exists($v->carpeta . $v->nombre_archivo)){
                        $arc="/".$v->carpeta . $v->nombre_archivo;
                        $file = '<a href="'.$arc.'"  title="'.$v->nombre_archivo.'" target="_blank" class="pull-left">'.$v->nombre_archivo.'</a>';
                    }
                    $html.='<tr>
                                <td>'.$file.'</td>
                                <td class="text-right">'.date("d-m-Y H:i:s",strtotime($v->fecha_reg)).' </td>
                                <td class="text-center">
                            <div class="btn-group">
                                <a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar" class="btn btn-xs btn-danger delete_archivo" parametro="'.$v->parametro_id.'" archivo="'.$v->id.'"><i class="fa fa-times"></i></a>
                            </div>
                        </td>
                            </tr>';

                }   
            }else{
                $html.='<p>No se tiene archivos</p>';
            }
               
        
        $html.='</div>';
        $this->view->disable();
        echo $html;
}

public function deletearchivoAction()
{
    $resul = Checklistsarchivos::findFirst(array("parametro_id='".$_POST['parametro_id']."' and archivo_id='".$_POST['archivo_id']."' and contrato_id='".$_POST['contrato_id']."'"));
     if ($resul->delete()) {
                $msm ='Exito: Se elimino correctamente';
            }else{
                $msm = 'Error: No se elimino el registro';
            }
    $this->view->disable();
    echo $msm;
}

public function archivo($parametro_id,$contrato_id)
{
    // $file = "/file/productos/images.png";
    $file = "";
    if($parametro_id>0){
        $model=new Checklists();
        $resul = $model->obtenerarchivos($parametro_id,$contrato_id);
        foreach ($resul as $v) {
            if(file_exists($v->carpeta . $v->nombre_archivo)){
            $arc="/".$v->carpeta . $v->nombre_archivo;
            $file = '<a href="'.$arc.'"  title="'.$v->nombre_archivo.'" target="_blank" class="pull-left"><i class="fa-1x gi gi-file_export"></i></a><span class="pull-right"><strong>'.count($resul).'</strong></span>';
            }
            break;    
        }
        
    }
    return $file;
}


public function savecumpleAction()
{
    if (isset($_POST['parametro_id'])) {
        $contrato_id = $_POST['contrato_id'];
        $parametro_id = $_POST['parametro_id'];

        $model = Checklists::findFirst(array('contrato_id='.$contrato_id.' AND parametro_id='.$parametro_id.' and baja_logica=1'));
        // $cumple = 0;
        if ($this->request->getPost('cumple')=='true' ||$this->request->getPost('cumple')=='1') {
            $cumple = 1;
        }else{
            $cumple = 0;
        }
        if ($model!=false) {
            $model->tipo_empresa = $this->request->getPost('tipo_empresa');
            $model->parametro = $this->request->getPost('parametro');
            $model->cumple = $cumple;
            if ($model->save()) {
                $msm ='Exito: Se guardo correctamente';
            }else{
                $msm = 'Error: No se guardo el registro';
            }
        }else{
            $resul = new Checklists();
            $resul->contrato_id = $contrato_id;
            $resul->parametro_id = $parametro_id;
            $resul->tipo_empresa = $this->request->getPost('tipo_empresa');
            $resul->parametro = $this->request->getPost('parametro');
            $resul->cumple = $cumple;
            $resul->observacion = '';
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

public function savearchivoAction()
{
     if ($this->request->hasFiles() == true) {
                foreach ($this->request->getUploadedFiles() as $file) {
                //Move the file into the application
                $carpeta = "file/checklist/";
                    $path = $carpeta.date("Ymd_his").$file->getName();
                    if($file->moveTo($path)) {
                        $resul3 = new Archivoschecklists();
                        $resul3->cliente_id = $_POST['cliente_id'];
                        $resul3->tipo_archivo = $file->getType();
                        $resul3->nombre_archivo = date("Ymd_his").$file->getName();
                        $resul3->carpeta = $carpeta;
                        $resul3->tamanio = $file->getSize();
                        $resul3->usuario_reg = $this->_user->id;
                        $resul3->fecha_reg = date("Y-m-d h:i:s");
                        $resul3->baja_logica = 1;
                        if ($resul3->save()) {
                            $resul = new Checklistsarchivos();
                            $resul->parametro_id = $_POST['parametro_id'];
                            $resul->archivo_id = $resul3->id;
                            $resul->estado = 1;
                            $resul->contrato_id = $_POST['contrato_id'];
                            $resul->save();

                            $this->flashSession->success("Exito: Registro guardado correctamente...");    
                        }else{
                            $this->flashSession->error("Error: no se a guardado el registro...");    
                        }
                    } else {
                        die("Acurrio algun error.");    
                    } 
                }
            }

    $this->response->redirect('/checklists/index/'.$_POST['contrato_id']);            
}


public function savemigrarAction()
{
    $msm='';
    if (isset($_POST['contrato_id_migrar'])) {
        $contrato_id = $_POST['contrato_id'];
        $contrato_id_migrar = $_POST['contrato_id_migrar'];

        $model = new Checklists();
        $resul = $model->migrar($contrato_id,$contrato_id_migrar);
        $msm = 'Se migro correctamente';
    }
    $this->view->disable();
    echo $msm;
}
// public function deleteAction(){
//     $resul = Estaciones::findFirstById($this->request->getPost('id'));
//     $resul->baja_logica = 0;
//     if ($resul->save()) {
//         $msm ='Exito: Se elimino correctamente';
//     }else{
//         $msm = 'Error: No se guardo el registro';
//     }
//     $this->view->disable();
//     echo $msm;
// }


}