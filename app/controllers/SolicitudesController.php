<?php 
/**
* 
*/
class SolicitudesController extends ControllerBase
{
	public function indexAction()
	{
		$this->assets
                ->addCss('/jqwidgets/styles/jqx.base.css')
                ->addCss('/jqwidgets/styles/jqx.custom.css')
                ->addCss('/assets/css/plugins.css')
                // ->addCss('/js/autocomplete/fcbk.css')
                ;
        $this->assets
                // ->addJs('/js/autocomplete/jquery.fcbkcomplete.min.js')
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
                ->addJs('/scripts/solicitudes/index.js')
        ;

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

        $resul = Clientes::find(array('baja_logica=1','order' => 'razon_social ASC'));
        $clientes = $this->tag->select(
            array(
                'cliente_id',
                $resul,
                'using' => array('id', 'razon_social'),
                'useEmpty' => true,
                'emptyText' => '(Selecionar)',
                'emptyValue' => '',
                'class' => 'form-control select-chosen',
                'required' => 'required'
                )
            );
        $this->view->setVar('clientes',$clientes);

        $resul = Parametros::find(array('parametro="solicitudes_estados" AND baja_logica=1 AND nivel>1','order' => 'nivel ASC'));
        $estado = $this->tag->select(
            array(
                'estado',
                $resul,
                'using' => array('nivel', 'valor_1'),
                'useEmpty' => true,
                'emptyText' => '(Selecionar)',
                'emptyValue' => '',
                'class' => 'form-control',
                'required' => 'required'
                )
            );
        $this->view->setVar('estado',$estado);

	}

	public function listAction()
	{
		$this->view->disable();
		$model = new Solicitudes();
		$resul = $model->lista();
		foreach ($resul as $v) {
			$accion = '';
			$estado = '';
			if ($v->estado==1) {
				$accion='<a class="btn btn-xs btn-warning" onclick="respuesta()" title="Respuesta a la Solicitud"><i class="fa fa-share-square-o"></i></a>';
				$estado = '<span class="label label-warning">'.$v->valor_1.'</span>';
			}elseif ($v->estado==2) {
				$accion='<a class="btn btn-xs btn-success" onclick="informe()" title="Realizar Informe"><i class="fa fa-file-text"></i></a>';
					if ($v->nur!='') {
						$accion='<a href="/informes/seguimiento/?nur='.$v->nur.'" class="btn btn-xs btn-success" title="Informe Realizado">'.$v->nur.'</a>';
					}				
				$estado = '<span class="label label-success">'.$v->valor_1.'</span>';
			}else{
				$estado = '<span class="label label-danger">'.$v->valor_1.'</span>';
			}
			$customers[] = array(
				'id' => $v->id,
				'nro_solicitud' => $v->nro_solicitud,
				'fecha_envio_solicitud' => $v->fecha_envio_solicitud.' 00:00:00',
				'fecha_recepcion_solicitud' => $v->fecha_recepcion_solicitud.' 00:00:00',
				'productos_solicitud' => $v->productos_solicitud,
				'respuesta' => $v->respuesta,
				'fecha_envio_resp' => $v->fecha_envio_resp,
				'fecha_recepcion_resp' => $v->fecha_recepcion_resp,
				'descripcion_resp' => $v->descripcion_resp,
				'cliente_id' => $v->cliente_id,
				'razon_social' => $v->razon_social,
				'nit' => $v->nit,
				'responsable_id' => $v->responsable_id,
				'responsable' => $v->responsable,
				'representante' => $v->representante,
				'cargo_representante' => $v->cargo_representante,
				'descripcion_solicitud' => $v->descripcion_solicitud,
				'num_productos' => $v->num_productos,
				'estado' => $estado,
				'accion' => $accion,
				'nur' => $v->nur,
				);
		}
		echo json_encode($customers);

	}

	public function saveAction()
	{
		if ($this->request->isPost()) {
			$fecha_envio_solicitud = date("Y-m-d",strtotime($this->request->getPost('fecha_envio_solicitud')));
			$fecha_recepcion_solicitud = date("Y-m-d",strtotime($this->request->getPost('fecha_recepcion_solicitud')));
			if ($_POST['id']>0) {
				$resul = Solicitudes::findFirstById($_POST['id']);
				$resul->nro_solicitud = $this->request->getPost('nro_solicitud');
				$resul->fecha_envio_solicitud = $fecha_envio_solicitud;
				$resul->fecha_recepcion_solicitud = $fecha_recepcion_solicitud;
				$resul->responsable_id = $this->request->getPost('responsable_id');
				$resul->representante = $this->request->getPost('representante');
				$resul->cargo_representante = $this->request->getPost('cargo_representante');
				$resul->descripcion_solicitud = $this->request->getPost('descripcion_solicitud');
				$resul->cliente_id = $this->request->getPost('cliente_id');
				if ($resul->save()) {
					$msm = 'Exito: Se guardo correctamente';
				}else{
					$msm = 'Error: No se guardo el registro';
				}
			}
			else{
				$resul = new Solicitudes();
				$resul->nro_solicitud = $this->request->getPost('nro_solicitud');
				$resul->fecha_envio_solicitud = $fecha_envio_solicitud;
				$resul->fecha_recepcion_solicitud = $fecha_recepcion_solicitud;
				$resul->responsable_id = $this->request->getPost('responsable_id');
				$resul->representante = $this->request->getPost('representante');
				$resul->cargo_representante = $this->request->getPost('cargo_representante');
				$resul->descripcion_solicitud = $this->request->getPost('descripcion_solicitud');
				$resul->cliente_id = $this->request->getPost('cliente_id');
				$resul->usuario_reg = $this->_user->id;
				$resul->fecha_reg = date("Y-m-d H:i:s");
				$resul->baja_logica = 1;
				$resul->estado = 1;
				if ($resul->save()) {
					$msm = 'Exito: Se guardo correctamente';
				}else{
					$msm = 'Error: No se guardo el registro';
				}
			}   
		}
		$this->view->disable();
		echo $msm;
	}


	public function saverespuestaAction()
	{
		if ($this->request->isPost()) {
			$fecha_envio_resp = date("Y-m-d",strtotime($this->request->getPost('fecha_envio_resp')));
			$fecha_recepcion_resp = date("Y-m-d",strtotime($this->request->getPost('fecha_recepcion_resp')));
			$resul = Solicitudes::findFirstById($_POST['id']);
			$resul->respuesta = $this->request->getPost('respuesta');
			$resul->fecha_envio_resp = $fecha_envio_resp;
			$resul->fecha_recepcion_resp = $fecha_recepcion_resp;
			$resul->descripcion_resp = $this->request->getPost('descripcion_resp');
			$resul->estado = $this->request->getPost('estado');
			if ($resul->save()) {
				if ($this->request->getPost('estado')=='3') {
					$model = new Solicitudesproductos();
					$resul = $model->updateCantSolicitud($_POST['id']);
				}
				$msm = 'Exito: Se guardo correctamente';
			}else{
				$msm = 'Error: No se guardo el registro';
			}
		}
		$this->view->disable();
		echo $msm;
	}


	public function deleteAction(){
        $resul = Solicitudes::findFirstById($this->request->getPost('id'));
        $resul->baja_logica = 0;
        if ($resul->save()) {
                    $msm ='Exito: Se elimino correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
        $this->view->disable();
        echo $msm;
    }

    public function documentosAction()
    {
    	$model = new Seguimientos();
    	$resul = $model->documentos($_POST['autocomplete']);
    	$doc = array();
    	$html = '<div class="list-group">';
    	foreach ($resul as $v) {
    		$html.='<a href="#" onclick="info(\''.$v->id.'\',\''.$v->nur.'\')" class="list-group-item">';
    		$html.='<b> NUR:</b> '.$v->nur;
    		$html.=' --- <b>CITE:</b>'.utf8_encode($v->cite_original);
    		$html.='</a>';
    	}
    	$html .= '</div>';
    	$this->view->disable();
    	echo $html;
    }


    //  public function documentosAction() {
    //     $auth = Auth::instance();
    //     if ($auth->logged_in()) {
    //         $documentos = ORM::factory('documentos')
    //                 ->where('id_user', '=', $auth->get_user())
    //                 ->find_all();
    //         $doc = array();
    //         foreach ($documentos as $d) {
    //             $doc[] = array('key' => $d->codigo, 'value' => $d->codigo);
    //         }
    //         echo json_encode($doc);
    //     }
    // }
}
