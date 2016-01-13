<?php 
/**
* 
*/
class ClientesController extends ControllerBase
{
	
	public function indexAction()
	{
		$this->assets
        ->addCss('/jqwidgets/styles/jqx.base.css')
        ->addCss('/jqwidgets/styles/jqx.custom.css')
        ->addCss('/js/fileinput/css/fileinput.min.css')
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
                ->addJs('/scripts/clientes/index.js')
                ->addJs('/assets/js/plugins.js')
                ->addJs('/assets/js/pages/formsValidation.js')
                ->addJs('/js/fileinput/js/fileinput.min.js')
                // ->addJs('/scripts/productos/galeria.js')
                ;

                $empresa= Empresas::findFirst(array('baja_logica=1'));
                $this->view->setVar('empresa',$empresa);

        //$model = usuarios::find(array('habilitado=1 and nivel=3',"order"=>"paterno ASC"));
        $model = new Usuarios();
        $resul = $model->responsablecomercial();
        $responsable = $this->tag->select(
            array(
                'responsable_id',
                $resul,
                'using' => array('id', 'nombres'),
                'useEmpty' => true,
                'emptyText' => '(Selecionar)',
                'emptyValue' => '',
                'class' => 'form-control',
                'required' => 'required'
                )
            );
        $this->view->setVar('responsable',$responsable);

    }

    public function listAction()
    {
		//$resul = Clientes::find(array('baja_logica=1', 'order'=>'id ASC'));
        $model = new Clientes();
        $resul = $model->lista();
        $this->view->disable();
        foreach ($resul as $v) {
            if ($v->estado == 'Activo') {
                $estado = '<span class="label label-success">'.$v->estado.'</span>';
                }elseif ($v->estado =='Pasivo') {
                    $estado = '<span class="label label-danger">'.$v->estado.'</span>';
                    }else{
                        $estado = '<span class="label label-primary">'.$v->estado.'</span>';
                    }
                    $customers[] = array(
                        'id' => $v->id,
                        'razon_social_href' => '<a href="/clientes/view/'.$v->id.'">'.$v->razon_social.'</a>',
                        'razon_social' => $v->razon_social,
                        'nit' => $v->nit,
                        'telefono' => $v->telefono,
                        'celular' => $v->celular,
                        'correo' => $v->correo,
                        'direccion' => $v->direccion,
                        'representante_legal' => $v->representante_legal,
                        'ci_representante_legal' => $v->ci_representante_legal,
                        'celular_representante_legal' => $v->celular_representante_legal,
                        'correo_representante_legal' => $v->correo_representante_legal,
                        'nombre_ref' => $v->nombre_ref,
                        'ci_ref' => $v->ci_ref,
                        'celular_ref' => $v->celular_ref,
                        'correo_ref' => $v->correo_ref,
                        'estado' => $estado,
                        'foto' => $this->foto($v->carpeta,$v->nombre_archivo)
                        );
        }
echo json_encode($customers);
}



public function listcontratosclientesAction($cliente_id)
{
    $model = new Clientes();
    $resul = $model->listContratosCliente($cliente_id);
    $this->view->disable();
    $customers = array();
    foreach ($resul as $v) {
        if ($v->estado == 'Activo') {
            $estado = '<span class="label label-success">'.$v->estado.'</span>';
            }elseif ($v->estado =='Pasivo') {
                $estado = '<span class="label label-danger">'.$v->estado.'</span>';
                }else{
                    $estado = '<span class="label label-primary">'.$v->estado.'</span>';
                }
                $customers[] = array(
                    'id' => $v->id,
                    'contrato' => '<a href="/contratos/crear/'.$v->id.'">'.$v->contrato.'</a>',
                    'cliente_id' => $v->cliente_id,
                    'fecha_contrato' => $v->fecha_contrato,
                    'descripcion' => $v->descripcion,
                    'num_productos' => $v->num_productos,
                    'dias_tolerancia' => $v->dias_tolerancia,
                    'porcentaje_mora' => $v->porcentaje_mora*100,
                    'responsable' =>$v->responsable,
                    'responsable_id' => $v->responsable_id,
                    'estado' =>$estado,
                    );
            }
            echo json_encode($customers);
        }


        public function saveAction()
        {
            if (isset($_POST['id'])) {
                if ($_POST['id']>0) {
                    $resul = Clientes::findFirstById($this->request->getPost('id'));
                    $resul->razon_social= $this->request->getPost('razon_social');
                    $resul->nit = $this->request->getPost('nit');
                    $resul->telefono = $this->request->getPost('telefono');
                    $resul->celular = $this->request->getPost('celular');
                    $resul->correo = $this->request->getPost('correo');
                    $resul->direccion = $this->request->getPost('direccion');
                // $resul->imagen = $this->request->getPost('imagen');
                $resul->representante_legal = $this->request->getPost('representante_legal');
                $resul->ci_representante_legal = $this->request->getPost('ci_representante_legal');
                $resul->celular_representante_legal = $this->request->getPost('celular_representante_legal');
                $resul->correo_representante_legal = $this->request->getPost('correo_representante_legal');
                $resul->nombre_ref = $this->request->getPost('nombre_ref');
                $resul->ci_ref = $this->request->getPost('ci_ref');
                $resul->celular_ref = $this->request->getPost('celular_ref');
                $resul->correo_ref = $this->request->getPost('correo_ref');
                // $resul->usuario_reg = $this->_user->id;
                // $resul->fecha_reg = date("Y-m-d H:i:s");
                // $resul->baja_logica = 1;
                if ($resul->save()) {
                    $msm ='Exito: Se guardo correctamente';
                    }else{
                        $msm = 'Error: No se guardo el registro';
                    }
                }
                else{
                    $resul = new Clientes();
                    $resul->razon_social= $this->request->getPost('razon_social');
                    $resul->nit = $this->request->getPost('nit');
                    $resul->telefono = $this->request->getPost('telefono');
                    $resul->celular = $this->request->getPost('celular');
                    $resul->correo = $this->request->getPost('correo');
                    $resul->direccion = $this->request->getPost('direccion');
                // $resul->imagen = $this->request->getPost('imagen');
                $resul->representante_legal = $this->request->getPost('representante_legal');
                $resul->ci_representante_legal = $this->request->getPost('ci_representante_legal');
                $resul->celular_representante_legal = $this->request->getPost('celular_representante_legal');
                $resul->correo_representante_legal = $this->request->getPost('correo_representante_legal');
                $resul->nombre_ref = $this->request->getPost('nombre_ref');
                $resul->ci_ref = $this->request->getPost('ci_ref');
                $resul->celular_ref = $this->request->getPost('celular_ref');
                $resul->correo_ref = $this->request->getPost('correo_ref');
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
            $resul = Clientes::findFirstById($this->request->getPost('id'));
            $resul->baja_logica = 0;
            if ($resul->save()) {
                $msm ='Exito: Se elimino correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
                $this->view->disable();
                echo $msm;
            }

            public function addAction()
            {
                $this->assets
                // ->addCss('/js/datepicker/datepicker.css')
                ;

                $this->assets
                ->addJs('/assets/js/plugins.js')
        //->addJs('/assets/js/pages/formsValidation.js')
        // ->addJs('/js/datepicker/bootstrap-datepicker.js')
        ;
    }

    public function viewAction($cliente_id)
    {

        if ($this->request->isPost()) {
           $resul = Clientes::findFirstById($this->request->getPost('cliente_id'));
           $resul->razon_social= $this->request->getPost('razon_social');
           $resul->nit = $this->request->getPost('nit');
           $resul->telefono = $this->request->getPost('telefono');
           $resul->celular = $this->request->getPost('celular');
           $resul->correo = $this->request->getPost('correo');
           $resul->direccion = $this->request->getPost('direccion');
           $resul->representante_legal = $this->request->getPost('representante_legal');
           $resul->ci_representante_legal = $this->request->getPost('ci_representante_legal');
           $resul->celular_representante_legal = $this->request->getPost('celular_representante_legal');
           $resul->correo_representante_legal = $this->request->getPost('correo_representante_legal');
           $resul->nombre_ref = $this->request->getPost('nombre_ref');
           $resul->ci_ref = $this->request->getPost('ci_ref');
           $resul->celular_ref = $this->request->getPost('celular_ref');
           $resul->correo_ref = $this->request->getPost('correo_ref');
           if ($resul->save()) {
            $this->flashSession->success('<b>Exito!</b> Se guardo correctamente');
            }else{
                $this->flashSession->error('<b>Error!</b> No se a actualizado');    
            }   
        }

        $this->assets
        ->addCss('/jqwidgets/styles/jqx.base.css')
        ->addCss('/jqwidgets/styles/jqx.custom.css')
        ->addCss('/js/fileinput/css/fileinput.min.css')
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
        ->addJs('/scripts/clientes/view.js')
        ->addJs('/assets/js/plugins.js')
        ->addJs('/assets/js/pages/formsValidation.js')
        ->addJs('/js/fileinput/js/fileinput.min.js')
        ->addJs('/js/fileinput/js/fileinput_locale_es.js')
        ;

        $model = new Contratos();
        $activos = $model->activos($cliente_id);
        $proceso = $model->proceso($cliente_id);
        $concluido = $model->concluido($cliente_id);

        $this->view->setVar('contratos_activos',count($activos));
        $this->view->setVar('contratos_proceso',count($proceso));
        $this->view->setVar('contratos_concluido',count($concluido));

        $contrato_total = $model->totalContrato($cliente_id);
        $deposito_total = $model->depositoTotal($cliente_id);
        $mora_total = $model->moraTotal($cliente_id);

        $this->view->setVar('contratoTotal',$contrato_total[0]->total);
        $this->view->setVar('depositoTotal',$deposito_total[0]->deposito);
        $this->view->setVar('moraTotal',$mora_total[0]->mora);



        $resul = Clientes::findFirstById($cliente_id);
        $this->view->setVar('cliente',$resul);

        $imagen = Archivos::findFirst("baja_logica = 1 and tabla=2 and producto_id ='$cliente_id'");

        $logo['imagen'] = '/file/clientes/logo_comodin.png';
        $logo['archivo_id'] = 0;
        if ($imagen!=false) {
            $logo['imagen'] = $this->foto($imagen->carpeta,$imagen->nombre_archivo);    
            $logo['archivo_id'] = $imagen->id;    
        }
        $this->view->setVar('logo',$logo);        
    }





    public function logoaddAction()
    {
     if ($this->request->hasFiles() == true) {
        foreach ($this->request->getUploadedFiles() as $file) {
                //Move the file into the application
                $carpeta = "file/clientes/";
                $path = $carpeta.date("Ymd_his").$file->getName();
                if($file->moveTo($path)) {
                    $model = new Archivos();
                    $resul = $model->deleteImagenCliente($this->request->getPost('cliente_id'));

                    $resul3 = new Archivos();
                    $resul3->producto_id = $this->request->getPost('cliente_id');
                    $resul3->tipo_archivo = $file->getType();
                    $resul3->nombre_archivo = date("Ymd_his").$file->getName();
                    $resul3->carpeta = $carpeta;
                    $resul3->tamanio = $file->getSize();
                    $resul3->usuario_reg = $this->_user->id;
                    $resul3->fecha_reg = date("Y-m-d h:i:s");
                    $resul3->estado = 1;
                    $resul3->baja_logica = 1;
                    $resul3->tabla = 2;
                    if ($resul3->save()) {
                        $this->flashSession->success("Exito: Registro guardado correctamente...");    
                        }else{
                            $this->flashSession->error("Error: no se a guardado el registro...");    
                        }
                        } else {
                            die("Acurrio algun error.");    
                        } 
                    }
                }

                $this->response->redirect('/clientes/view/'.$this->request->getPost('cliente_id'));

            }

            public function logodeleteAction($archivo_id,$cliente_id){
                $resul = Archivos::findFirstById($archivo_id);
                $resul->baja_logica = 0;
                if ($resul->save()) {
                    $this->flashSession->success("Exito: Registro eliminado correctamente...");    
                    }else{
                        $this->flashSession->error("Error: no se a eliminado el registro...");    
                    }
                    $this->response->redirect('/clientes/view/'.$cliente_id);
                }

                public function foto($carpeta='', $archivo) {
                    $file = "/file/clientes/logo_comodin.png";
                    if (file_exists($carpeta . $archivo)) {
                        $file = "/".$carpeta . $archivo;
                    } 
                    return $file;
                }


                public function reporteAction()
                {
                    $this->view->disable();
                    $model = new Clientes();
                    $resul = $model->lista();
        include_once('tbs_us/tbs_class.php'); // Load the TinyButStrong template engine
        include_once ('tbs_us/tbs_plugin_opentbs/tbs_plugin_opentbs.php'); // Load the OpenTBS plugin

        $TBS = new clsTinyButStrong; // new instance of TBS
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

        $TBS->VarRef['usuario'] = $this->_user->nombre.' '.$this->_user->paterno;
        $data = array();
        $c=1;

        foreach ($resul as $v) {
            $data[] = array('rank'=> 'A', 'nro'=>$c ,'razon_social'=>$v->razon_social , 'nit'=>$v->nit, 'telefono'=>$v->telefono, 'celular'=>$v->celular, 'correo'=>$v->correo,'direccion'=>$v->direccion,'estado'=>$v->estado, 'representante_legal'=>$v->representante_legal,'celular_representante_legal'=>$v->celular_representante_legal,'correo_representante_legal'=>$v->correo_representante_legal,'nombre_ref'=>$v->nombre_ref,'celular_ref'=>$v->celular_ref,'correo_ref'=>$v->correo_ref);
            $c++;
        }
        $template = 'file/template/temp_reporte_cliente.xlsx';
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).
        // ----------------------
        // Debug mode of the demo
        // ----------------------
        // if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
        // if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
        // if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

        // Merge data in the first sheet
        $TBS->MergeBlock('a,b', $data);

        // -----------------
        // Output the result
        // -----------------
        // $output_file_name = str_replace('.', '_'.date('Y-m-d').'.', $template);
        $output_file_name = date('Y-m-d').' '.'reporte.xlsx';
        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
        exit();

    }

    public function getclienteAction()
    {

        $id = $_POST['id'];
        $resul = Clientes::findFirstById($id);
        $cliente = array();
        $cliente['nit'] = $resul->nit;
        $cliente['representante_legal'] = $resul->representante_legal;

        // $resul = Solicitudes::find(array('baja_logica=1 AND cliente_id = '.$id.' AND estado=2','order' => 'id ASC'));
        $model  = new Solicitudes();
        $resul = $model->solicitudespendientes($id);
        $options = '<option value="">(Seleccionar)</option>';
        foreach ($resul as $v) {
            $options.='<option value="'.$v->id.'" >'.$v->nro_solicitud.'</option>';
        }
        $cliente['opciones'] = $options;
        $this->view->disable();  
        echo json_encode($cliente);

    }    

}