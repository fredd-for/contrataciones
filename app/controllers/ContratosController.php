<?php 
/**
* 
*/
class ContratosController extends ControllerBase
{
	
	public function indexAction($opcion='')
	{
		$this->assets
                ->addCss('/jqwidgets/styles/jqx.base.css')
                ->addCss('/jqwidgets/styles/jqx.custom.css')
                ->addCss('/assets/css/plugins.css')
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
                ->addJs('/assets/js/plugins.js')
                ->addJs('/assets/js/app.js')
                ->addJs('/js/app.plugin.js')
                // ->addJs('/js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')
                // ->addJs('/media/plugins/form-validation/jquery.validate.min.js')
                // ->addJs('/assets/js/plugins.js')
                // ->addJs('/assets/js/pages/formsValidation.js')
                
                ->addJs('/scripts/contratos/index.js')
        ;

        $this->view->setVar('opcion', $opcion);
        
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

	}

     public function savecontratoAction()
    {
        if (isset($_POST['contrato_id'])) {
            if ($_POST['contrato_id']>0) {
                $resul = Contratos::findFirstById($this->request->getPost('contrato_id'));
                $resul->contrato = $this->request->getPost('contrato');
                $resul->fecha_contrato = date("Y-m-d",strtotime($this->request->getPost('fecha_contrato')));
                $resul->descripcion = $this->request->getPost('descripcion');
                $resul->dias_tolerancia = $this->request->getPost('dias_tolerancia');
                $resul->porcentaje_mora = $this->request->getPost('porcentaje_mora')/100;
                $resul->responsable_id = $this->request->getPost('responsable_id');
                $resul->tipo_pago = $this->request->getPost('tipo_pago');
                $resul->tipo_cobro_mora = $this->request->getPost('tipo_cobro_mora');
                if ($resul->save()) {
                    $msm ='Exito: Se guardo correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
            }
            else{
                $resul = new Contratos();
                $resul->contrato = $this->request->getPost('contrato');
                $resul->solicitud_id = $this->request->getPost('solicitud_id');
                $resul->cliente_id = $this->request->getPost('cliente_id');
                $resul->fecha_contrato = date("Y-m-d",strtotime($this->request->getPost('fecha_contrato')));
                $resul->usuario_reg = $this->_user->id;
                $resul->fecha_reg = date("Y-m-d H:i:s");
                $resul->baja_logica = 1;
                $resul->arrendador = $this->request->getPost('arrendador');
                $resul->arrendador_rep_legal = $this->request->getPost('arrendador_rep_legal');
                $resul->arrendador_cargo = $this->request->getPost('arrendador_cargo');
                $resul->descripcion = $this->request->getPost('descripcion');
                $resul->dias_tolerancia = $this->request->getPost('dias_tolerancia');
                $resul->porcentaje_mora = $this->request->getPost('porcentaje_mora')/100;
                $resul->responsable_id = $this->request->getPost('responsable_id');
                $resul->tipo_pago = $this->request->getPost('tipo_pago');
                $resul->tipo_cobro_mora = $this->request->getPost('tipo_cobro_mora');
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
    public function deletecontratoAction(){
        $resul = Contratos::findFirstById($this->request->getPost('id'));
        $resul->baja_logica = 0;
        if ($resul->save()) {
                    $msm ='Exito: Se elimino correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
        $this->view->disable();
        echo $msm;
    }
    public function listAction()
    {
        //$resul = Contratos::find(array('baja_logica=1', 'order'=>'fecha_contrato desc'));
        $model = new Contratos();
        $resul = $model->listadocontratos();

        $this->view->disable();
        $customers = array();
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
                'contrato' => $v->contrato,
                'cliente_id' => $v->cliente_id,
                'razon_social' => $v->razon_social,
                'fecha_contrato' => $v->fecha_contrato,
                'descripcion' => $v->descripcion,
                'num_productos' => $v->num_productos,
                'dias_tolerancia' => $v->dias_tolerancia,
                'porcentaje_mora' => $v->porcentaje_mora*100,
                'responsable' =>$v->responsable,
                'responsable_id' => $v->responsable_id,
                'estado_text' => $estado,
                'estado' => $v->estado,
                'tipo_pago' => $v->tipo_pago,
                'tipo_cobro_mora' => $v->tipo_cobro_mora,

            );
        }
        echo json_encode($customers);
    }

	public function crearAction($contrato_id='')
	{
		
		$tiempo = $this->tag->selectStatic(
        array(
            "tiempo",
            array(
                "Hora" => "Hora",
                "Dia"   => "Dia",
                //"Semanal" => "Semanal",
                "Mensual" => "Mensual",
                //"Anual" => "Anual",
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
		
		$model = new Contratos();
		$resul = $model->listContrato($contrato_id);
        $contrato=array();
        foreach ($resul as $v) {
            $contrato = $v;  
        }
        $this->view->setVar('contrato',$contrato);
        
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
                ->addJs('/media/plugins/form-validation/jquery.validate.min.js')
                ->addJs('/assets/js/plugins.js')
                ->addJs('/assets/js/pages/formsValidation.js')
                
                ->addJs('/scripts/contratos/crear.js')
        ;


	}

    public function listcpAction($contrato_id)
    {
        $model = new Contratos();
        $resul = $model->listcp($contrato_id);
        $this->view->disable();
        foreach ($resul as $v) {
            $customers[] = array(
                'id' => $v->id,
                'linea' => $v->linea,
                'estacion' => $v->estacion,
                'grupo' => $v->grupo,
                'producto' => $v->producto,
                'producto_id' => $v->producto_id,
                'precio_tiempo' => $v->precio_unitario.' Bs. x '.$v->tiempo,
                'precio_unitario' => $v->precio_unitario,
                'tiempo' => $v->tiempo,
                'cantidad' => $v->cantidad,
                'fecha_inicio' => $v->fecha_inicio,
                'fecha_fin' => $v->fecha_fin,
                'total' => $v->total,
            );
        }
        echo json_encode($customers);
    }

    public function savecontratosproductosAction()
    {
        
        if (isset($_POST['id'])) {
            if ($_POST['id']>0) {
                // $resul = Clientes::findFirstById($this->request->getPost('id'));
                // $resul->razon_social= $this->request->getPost('razon_social');
                // $resul->nit = $this->request->getPost('nit');
                // $resul->telefono = $this->request->getPost('telefono');
                // $resul->celular = $this->request->getPost('celular');
                // $resul->correo = $this->request->getPost('correo');
                // $resul->direccion = $this->request->getPost('direccion');
                // // $resul->imagen = $this->request->getPost('imagen');
                // $resul->representante_legal = $this->request->getPost('representante_legal');
                // $resul->ci_representante_legal = $this->request->getPost('ci_representante_legal');
                // $resul->celular_representante_legal = $this->request->getPost('celular_representante_legal');
                // $resul->correo_representante_legal = $this->request->getPost('correo_representante_legal');
                // $resul->nombre_ref = $this->request->getPost('nombre_ref');
                // $resul->ci_ref = $this->request->getPost('ci_ref');
                // $resul->celular_ref = $this->request->getPost('celular_ref');
                // $resul->correo_ref = $this->request->getPost('correo_ref');
                // // $resul->usuario_reg = $this->_user->id;
                // // $resul->fecha_reg = date("Y-m-d H:i:s");
                // // $resul->baja_logica = 1;
                // if ($resul->save()) {
                //     $msm ='Exito: Se guardo correctamente';
                // }else{
                //     $msm = 'Error: No se guardo el registro';
                // }
            }
            else{
                $fecha_inicio = date("Y-m-d",strtotime($this->request->getPost('fecha_inicio'))).' '.$this->request->getPost('hora_inicio');
                $fecha_fin = date("Y-m-d",strtotime($this->request->getPost('fecha_fin'))).' '.$this->request->getPost('hora_fin');
                $contrato_id = $this->request->getPost('contrato_id');
                $producto_id = $this->request->getPost('producto_id');
                $precio_unitario = $this->request->getPost('precio_unitario');
                $cantidad = $this->request->getPost('cantidad');
                $tipo_pago = $this->request->getPost('tipo_pago');

                $resul = new Contratosproductos();
                $resul->contrato_id= $contrato_id;
                $resul->producto_id = $producto_id;
                $resul->precio_unitario = $precio_unitario;
                $resul->tiempo = $this->request->getPost('tiempo');
                $resul->fecha_inicio = $fecha_inicio;
                $resul->fecha_fin = $fecha_fin;
                $resul->cantidad = $cantidad;
                $resul->total = $this->request->getPost('total');
                
                $datetime1 = new DateTime($fecha_inicio);
                $datetime2 = new DateTime($fecha_fin);
                $interval = $datetime1->diff($datetime2);
                $nro_dias = $interval->format('%a')+1;
                $resul->nro_dias = $nro_dias;
                
                $resul->baja_logica = 1;
                if ($resul->save()) {
                    //Crear Plan de Pagos
                    if ($this->request->getPost('tiempo') == 'Mensual') {
                        if ($tipo_pago=='2') {
                            $msm = $this->mensual_cumplido_planpagos($fecha_inicio,$fecha_fin,$precio_unitario,$cantidad,$contrato_id, $producto_id, $resul->id);    
                        }else{
                            $msm = $this->mensual_planpagos($fecha_inicio,$fecha_fin,$precio_unitario,$cantidad,$contrato_id, $producto_id, $resul->id);    
                        }
                    }elseif ($_POST['tiempo'] == 'Dia') {
                        $msm = $this->dias_planpagos($fecha_inicio,$fecha_fin,$precio_unitario,$cantidad,$contrato_id, $producto_id, $resul->id);
                    }elseif ($_POST['tiempo']=='Hora') {
                        $msm = $this->horas_planpagos($fecha_inicio.' '.$hora_inicio,$fecha_fin.' '.$hora_fin,$precio_unitario,$cantidad,$contrato_id, $producto_id, $resul->id);
                    }
                    if ($msm==0) {
                        $msm ='Exito: Se guardo correctamente';    
                    }else{
                        $msm ='Error: ocurrio un error al crear el plan de pagos. Revise plan de pagos';    
                    }

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
        $resul = Contratosproductos::findFirstById($this->request->getPost('id'));
        $resul->baja_logica = 0;
        if ($resul->save()) {
            // $resul2 = Productos::findFirstById($resul->producto_id); 
            // $resul2->cantidad = $resul2->cantidad + $resul->cantidad;
            // $resul2->save();
            $msm ='Exito: Se retiro el producto correctamente';
        }else{
            $msm = 'Error: No se retiro el producto';
        }
        $this->view->disable();
        echo $msm;
    }

    public function calculocostoAction()
    {
        
        $fecha_inicio = date("Y-m-d",strtotime($_POST['fecha_inicio']));
        $fecha_fin = date("Y-m-d",strtotime($_POST['fecha_fin']));
        $hora_inicio = $_POST['hora_inicio'];
        $hora_fin = $_POST['hora_fin'];
        $precio_unitario = $_POST['precio_unitario'];
        $tipo_pago = $_POST['tipo_pago'];

        if ($_POST['tiempo'] == 'Mensual') {
            if ($tipo_pago=='2') {
                $costo = $this->mensual_cumplido($fecha_inicio,$fecha_fin,$precio_unitario);    
            }else{
                $costo = $this->mensual($fecha_inicio,$fecha_fin,$precio_unitario);    
            }
        }elseif ($_POST['tiempo'] == 'Dia') {
            $costo = $this->dias($fecha_inicio,$fecha_fin,$precio_unitario);
        }elseif ($_POST['tiempo']=='Hora') {
            $costo = $this->horas($fecha_inicio.' '.$hora_inicio,$fecha_fin.' '.$hora_fin,$precio_unitario);
        }
        else{
            $costo = 0;
        }
        $costo = $costo * $_POST['cantidad'];
        $this->view->disable();
        echo number_format($costo,2,'.','');
    }

// Listado de plan de pagos
    public function listappAction()
    {
        $html='<div class="table-responsive">';
        $suma = 0;
        if ($_POST['contratoproducto_id']>0) {
            $resul=Planpagos::find(array('baja_logica=1 and contratoproducto_id='.$_POST['contratoproducto_id'],'order'=>'fecha_programado ASC'));
            if (count($resul)>0) {
                $html.='<table class="table table-vcenter table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha Programado</th>
                                        <th>Monto Programado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>';
                foreach ($resul as $v) {
                    $nombre = 'Fecha Programado: '.date("d-m-Y",strtotime($v->fecha_programado)).' Monto Programado: '.$v->monto_programado.' Bs.';
                    $fecha_programado = date("d-m-Y",strtotime($v->fecha_programado));
                    $monto_programado = $v->monto_programado;
                    $suma+=$v->monto_programado;
                    $html.='<tr>
                                <td>'.date("d-m-Y",strtotime($v->fecha_programado)).'</td>
                                <td class="text-right">'.$v->monto_programado.' Bs.</td>
                                <td class="text-center">
                            <div class="btn-group">
                                <a href="javascript:void(0)" data-toggle="tooltip" title="Editar" class="btn btn-xs btn-warning edit_pp" planpago_id="'.$v->id.'" fecha_programado="'.$fecha_programado.'" monto_programado="'.$monto_programado.'"><i class="fa fa-pencil"></i></a>
                                <a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar" class="btn btn-xs btn-danger delete_pp" planpagos_id="'.$v->id.'" nombre="'.$nombre.'"><i class="fa fa-times"></i></a>
                            </div>
                        </td>
                            </tr>';
                
                // $html.= '<li class="list-group-item "><button class="btn btn-warning btn-circle badge delete_pp" type="button" planpagos_id="'.$v->id.'" nombre="'.$nombre.'" ><i class="fa fa-times"></i></button>'.$nombre.'</li>';     
                }   
                $html.='<tr>
                                <td><strong>TOTAL</strong></td>
                                <td class="text-right">'.$suma.' Bs.</td>
                                <td class="text-right"></td>
                            </tr></tbody></table>'; 
            }else{
                $html.='<p>No se tiene plan de pagos</p>';
            }
               
        }
        $html.='</div>';
        $this->view->disable();
        echo $html;
    }

//Guardar plan de pagos
public function saveppAction()
    {
        if (isset($_POST['id'])) {
            if ($_POST['id']>0) {
                $resul = Planpagos::findFirstById($_POST['id']);
                $resul->fecha_programado = date("Y-m-d",strtotime($_POST['fecha_programado']));
                $resul->monto_programado = $_POST['monto_programado'];
                $resul->monto_reprogramado = $_POST['monto_programado'];
                if ($resul->save()) {
                    $msm = 'Exito: Se guardo correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
            }
            else{
                $resul = new Planpagos();
                $resul->contratoproducto_id = $_POST['contratoproducto_id'];
                $resul->contrato_id = $_POST['contrato_id'];
                $resul->producto_id = $_POST['producto_id'];
                $resul->fecha_programado = date("Y-m-d",strtotime($_POST['fecha_programado']));
                $resul->monto_programado = $_POST['monto_programado'];
                $resul->monto_reprogramado = $_POST['monto_programado'];
                $resul->baja_logica = 1;
                if ($resul->save()) {
                    $msm = 'Exito: Se guardo correctamente';
                }else{
                    $msm = 'Error: No se guardo el registro';
                }
            }
        }
        $this->view->disable();
        echo json_encode($msm);
    }

// Eliminar plan de pagos
    public function deleteppAction()
    {
        $resul = Planpagos::findFirstById($_POST['id']);
        $resul->baja_logica = 0;
        if ($resul->save()) {
            $msm = 'Exito: Se elimino correctamente';
        }else{
            $msm = 'Error: No se elimino el registro';
        }
        $this->view->disable();
        echo json_encode($msm);
    }

    public function finalizarAction($contrato_id)
    {
        $model = new Contratos();
        $resul = $model->listContrato($contrato_id);
        $this->view->setVar('contrato',$resul[0]);

        $resul = $model->listcp($contrato_id);
        $this->view->setVar('productos',$resul);

        $resul = Contratosproductos::find(array("baja_logica=1 AND estado=1 AND contrato_id='$contrato_id'"));
        $this->view->setVar('nroproductosactivos',count($resul));        

         $estado = $this->tag->select(
            array(
                'estado',
                Parametros::find(array("baja_logica=1 and parametro ='contratos_estados' and nivel>1","order"=>"nivel")),
                'using' => array('nivel', 'valor_1'),
                'useEmpty' => true,
                'emptyText' => '(Selecionar)',
                'emptyValue' => '',
                'class' => 'form-control',
                'required' => 'required'
                )
            );
        $this->view->setVar('estado',$estado);


        $this->assets
                ->addCss('/jqwidgets/styles/jqx.base.css')
                ->addCss('/jqwidgets/styles/jqx.custom.css')
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
                ->addJs('/scripts/contratos/finalizar.js')
        ;
    }

    public function savefinalizarAction()
    {
        
        if ($this->request->isPost()) {
            if($_POST['contratoproducto_id']>0){
                $resul = Contratosproductos::findFirstById($_POST['contratoproducto_id']);
                $resul->estado = $_POST['estado'];
                $resul->fecha_finalizacion = date("Y-m-d H:i:s");
                $resul->obs_finalizacion = $_POST['observacion'];
                $resul->usuario_finalizacion = $this->_user->id;
                if ($resul->save()) {
                    $this->flashSession->success("Exito: Producto finalizado correctamente...");
                }else{
                    $this->flashSession->error("Error: no se guardo el registro...");  
                }
                
            }else{
                $resul = Contratos::findFirstById($_POST['contrato_id']);
                $resul->estado = $_POST['estado'];
                $resul->fecha_finalizacion = date("Y-m-d H:i:s");
                $resul->obs_finalizacion = $_POST['observacion'];
                $resul->usuario_finalizacion = $this->_user->id;
                if ($resul->save()) {
                    $resul_cp=Contratosproductos::find(array("baja_logica=1 and estado =1 and contrato_id='$resul->id'"));
                    foreach ($resul_cp as $cp) {
                        $cp=Contratosproductos::findFirstById($cp->id);
                        $cp->estado = $_POST['estado'];
                        $cp->fecha_finalizacion = date("Y-m-d H:i:s");
                        $cp->obs_finalizacion = $_POST['observacion'];
                        $cp->usuario_finalizacion = $this->_user->id;
                        $cp->save();
                    }
                    // $contrato_id = $resul->id;
                    // $model = new Contratos();
                    // $cp = $model->finalizarProductos($resul->id,$resul->estado,$resul->obs_finalizacion,$resul->usuario_finalizacion);
                    $this->flashSession->success("Exito: Contrato finalizado correctamente...");
                }else{
                    $this->flashSession->error("Error: no se guardo el registro...");
                }
            }
        }
        // $this->view->disable();
        $this->response->redirect('/contratos/finalizar/'.$_POST['contrato_id']);
        // echo json_encode($msj);
    }

    public function listplanpagosAction()
    {
        $chtml = '<table border="1">
    <tr>
        <td>Fecha Programado</td>
        <td>Monto Programado Bs.</td>
    </tr>';
        $resul = Planpagos::find(array('baja_logica=1 and contratoproducto_id='.$_POST['id'],'order' => 'fecha_programado ASC'));
        foreach ($resul as $v) {
         $chtml .='<tr>
                <td>'.date("d-m-Y",strtotime($v->fecha_programado)).'</td>
                <td>'.$v->monto_programado.' Bs.</td>
                </tr>';
        }
        $chtml.= '</table>';
        $this->view->disable();
        echo $chtml;
    }

    public function listadoplanpagosAction($contrato_id)
    {
        $model = new Contratos();
        $resul = $model->listContrato($contrato_id);
        $contrato=array();
        foreach ($resul as $v) {
            $contrato = $v;  
        }
        $this->view->setVar('contrato',$contrato);

        $model = new Contratos();
        $contratoproducto = $model->listcp($contrato_id);
        $this->view->setVar('contratoproducto',$contratoproducto);
    }

/*
Funcionesa para plan de pagos
 */
public function mensual_cumplido_planpagos($fecha_inicio='2014-12-14',$fecha_fin='2015-02-15',$costo_mes='2000',$cantidad=1,$contrato_id='8', $producto_id = '1', $contratoproducto_id ='1')
    {
        $msm = 0;
        $dia_i = date('j',strtotime($fecha_inicio)); //dia inicial de la fecha de inicio
        $dia_f = date('j',strtotime($fecha_fin)); //dia final de la fecha final
        $fecha_inicio = strtotime ('-1 day',strtotime($fecha_inicio));
        $fecha_inicio = date('Y-m-d',$fecha_inicio);
        
        $fecha_aux =date("Y-m-d",strtotime('+1 month',strtotime($fecha_inicio)));
        while ( strtotime($fecha_aux)<=strtotime($fecha_fin) ) {
            // $costo_total=$costo_total+$costo_mes;
            $fecha_inicio = $fecha_aux;
            $fecha_aux =date("Y-m-d",strtotime('+1 month',strtotime($fecha_inicio)));

            $monto_programado=$costo_mes*$cantidad;
            $resul = new Planpagos();
            $resul->contratoproducto_id = $contratoproducto_id;
            $resul->contrato_id = $contrato_id;
            $resul->producto_id = $producto_id;
            $resul->fecha_programado = $fecha_inicio;
            $resul->monto_programado = $monto_programado;
            $resul->monto_reprogramado = $monto_programado;
            $resul->baja_logica = 1;
            if ($resul->save()==false) {
                $msm = 1;
            }
        }

        $datetime1 = new DateTime($fecha_inicio);
        $datetime2 = new DateTime($fecha_fin);
        $interval = $datetime1->diff($datetime2);
        $nro_dias = $interval->format('%a');
        if ($nro_dias>0) {
            $mes = date('n',strtotime($fecha_fin));
            $anio = date('Y',strtotime($fecha_fin));
            if( is_callable("cal_days_in_month")){
                $nro_dias_mes= cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
            }
            else{
                $nro_dias_mes = date("t",mktime(0,0,0,$mes,1,$anio));
            }    

            $monto_programado = $nro_dias*($costo_mes/$nro_dias_mes) * $cantidad;
            $dia_i = 1;
            $resul = new Planpagos();
            $resul->contratoproducto_id = $contratoproducto_id;
            $resul->contrato_id = $contrato_id;
            $resul->producto_id = $producto_id;
            $resul->fecha_programado = $fecha_fin;
            $resul->monto_programado = $monto_programado;
            $resul->monto_reprogramado = $monto_programado;
            $resul->baja_logica = 1;
            if ($resul->save()==false) {
                $msm = 1;
            }
        }
        
        return $msm;

    }


public function mensual_planpagos($fecha_inicio='2014-12-14',$fecha_fin='2015-02-15',$costo_mes='2000',$cantidad=1,$contrato_id='8', $producto_id = '1', $contratoproducto_id ='1')
    {
        $msm = 0;
        $dia_i = date('j',strtotime($fecha_inicio)); //dia inicial de la fecha de inicio
        $dia_f = date('j',strtotime($fecha_fin)); //dia final de la fecha final
        //$costo_total = 0;
        $mes = date('n',strtotime($fecha_inicio));
        $anio = date('Y',strtotime($fecha_inicio));
        if( is_callable("cal_days_in_month")){
            $nro_dias= cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        }
        else{
            $nro_dias = date("t",mktime(0,0,0,$mes,1,$anio));
        }
        $mes_anio_i = date("Y-m", strtotime($fecha_inicio));
        $mes_anio_f = date("Y-m", strtotime($fecha_fin));
        if ($mes_anio_i<$mes_anio_f) {
            //$costo_total +=($nro_dias-$dia_i+1)*($costo_mes/$nro_dias);
            $monto_programado = ($nro_dias-$dia_i+1)*($costo_mes/$nro_dias) * $cantidad;
            $dia_i = 1;
            $resul = new Planpagos();
            $resul->contratoproducto_id = $contratoproducto_id;
            $resul->contrato_id = $contrato_id;
            $resul->producto_id = $producto_id;
            $resul->fecha_programado = $mes_anio_i.'-'.$nro_dias;
            $resul->monto_programado = $monto_programado;
            $resul->monto_reprogramado = $monto_programado;
            $resul->baja_logica = 1;
            if ($resul->save()==false) {
                $msm = 1;
            }
            

        }
        
        //incrementar un mes a un fecha
        $mes_anio_i = date("Y-m",strtotime('+1 month',strtotime($mes_anio_i))); //incrementamos 1 mes
        while ( $mes_anio_i<$mes_anio_f ) {
            $mes = date('n',strtotime($mes_anio_i));
            $anio = date('Y',strtotime($mes_anio_i));
            if( is_callable("cal_days_in_month")){
                $nro_dias= cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
            }
            else{
                $nro_dias = date("t",mktime(0,0,0,$mes,1,$anio));
            }
            $monto_programado=$costo_mes*$cantidad;
            $resul = new Planpagos();
            $resul->contratoproducto_id = $contratoproducto_id;
            $resul->contrato_id = $contrato_id;
            $resul->producto_id = $producto_id;
            $resul->fecha_programado = $mes_anio_i.'-'.$nro_dias;
            $resul->monto_programado = $monto_programado;
            $resul->monto_reprogramado = $monto_programado;
            $resul->baja_logica = 1;
            if ($resul->save()==false) {
                $msm = 1;
            }           

            $mes_anio_i = date("Y-m",strtotime('+1 month',strtotime($mes_anio_i)));
        }
        // Calculamos mes final
        $mes = date('n',strtotime($fecha_fin));
        $anio = date('Y',strtotime($fecha_fin));
        if( is_callable("cal_days_in_month")){
            $nro_dias= cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        }
        else{
            $nro_dias = date("t",mktime(0,0,0,$mes,1,$anio));
            //$dias = date("d",mktime(0,0,0,$Month+1,0,$Year));
        }
        $monto_programado=($dia_f-$dia_i+1)*($costo_mes/$nro_dias)*$cantidad;
        $resul = new Planpagos();
        $resul->contratoproducto_id = $contratoproducto_id;
        $resul->contrato_id = $contrato_id;
        $resul->producto_id = $producto_id;
        $resul->fecha_programado = $fecha_fin;
        $resul->monto_programado = $monto_programado;
        $resul->monto_reprogramado = $monto_programado;
        $resul->baja_logica = 1;
       if ($resul->save()==false) {
                $msm = 1;
        }
        return $msm;
    }


    public function dias_planpagos($fecha_inicio='2015-02-14',$fecha_fin='2015-02-14',$costo_dia='20',$cantidad=1,$contrato_id='8', $producto_id = '1', $contratoproducto_id ='1')
    {
        $msm = 0;
        $datetime1 = new DateTime($fecha_inicio);
        $datetime2 = new DateTime($fecha_fin);
        $interval = $datetime1->diff($datetime2);
        $nro_dias = $interval->format('%a')+1;
        $monto_programado = $nro_dias*$costo_dia*$cantidad;
        $resul = new Planpagos();
        $resul->contratoproducto_id = $contratoproducto_id;
        $resul->contrato_id = $contrato_id;
        $resul->producto_id = $producto_id;
        $resul->fecha_programado = $fecha_fin;
        $resul->monto_programado = $monto_programado;
        $resul->monto_reprogramado = $monto_programado;
        $resul->baja_logica = 1;
        if ($resul->save()==false) {
                $msm = 1;
        }
        return $msm;   
    }

    public function horas_planpagos($fecha_inicio='2014-12-14 10:55',$fecha_fin='2014-12-15 11:55',$costo_hora='20',$cantidad=1,$contrato_id='8', $producto_id = '1', $contratoproducto_id ='1')
    {
        $msm = 0;
        $minutos = (strtotime($fecha_inicio)-strtotime($fecha_fin))/60;
        $minutos = abs($minutos); 
        $minutos = floor($minutos);
        $horas = ceil($minutos/60);
        $monto_programado = $horas*$costo_hora*$cantidad;
        $resul = new Planpagos();
        $resul->contratoproducto_id = $contratoproducto_id;
        $resul->contrato_id = $contrato_id;
        $resul->producto_id = $producto_id;
        $resul->fecha_programado = $fecha_fin;
        $resul->monto_programado = $monto_programado;
        $resul->monto_reprogramado = $monto_programado;
        $resul->baja_logica = 1;
        if ($resul->save()==false) {
                $msm = 1;
        }
        return $msm;      
    }

/*
Calculo de monto a pagar
 */
    public function mensual_cumplido($fecha_inicio='2014-12-14',$fecha_fin='2015-02-14',$costo_mes='2000')
    {
        $dia_i = date('j',strtotime($fecha_inicio)); //dia inicial de la fecha de inicio
        $dia_f = date('j',strtotime($fecha_fin)); //dia final de la fecha final
        $costo_total = 0;
        $fecha_inicio = strtotime ('-1 day',strtotime($fecha_inicio));
        $fecha_inicio = date('Y-m-d',$fecha_inicio);

        
                        $fecha_aux =date("Y-m-d",strtotime('+1 month',strtotime($fecha_inicio)));
                        while ( strtotime($fecha_aux)<=strtotime($fecha_fin) ) {
                            $costo_total=$costo_total+$costo_mes;
                            $fecha_inicio = $fecha_aux;
                            $fecha_aux =date("Y-m-d",strtotime('+1 month',strtotime($fecha_inicio)));
                        }

                        $datetime1 = new DateTime($fecha_inicio);
                        $datetime2 = new DateTime($fecha_fin);
                        $interval = $datetime1->diff($datetime2);
                        $nro_dias = $interval->format('%a');
                        if ($nro_dias>0) {
                            $mes = date('n',strtotime($fecha_fin));
                            $anio = date('Y',strtotime($fecha_fin));
                            if( is_callable("cal_days_in_month")){
                                $nro_dias_mes= cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
                            }
                            else{
                                $nro_dias_mes = date("t",mktime(0,0,0,$mes,1,$anio));
                            }    

                           $costo_total+=$nro_dias*($costo_mes/$nro_dias_mes); 
                        }
        
          return $costo_total;
        
    }

    public function mensual($fecha_inicio='2014-12-14',$fecha_fin='2015-02-15',$costo_mes='2000')
    {
        $dia_i = date('j',strtotime($fecha_inicio)); //dia inicial de la fecha de inicio
        $dia_f = date('j',strtotime($fecha_fin)); //dia final de la fecha final
        $costo_total = 0;
        $mes = date('n',strtotime($fecha_inicio));
        $anio = date('Y',strtotime($fecha_inicio));
        if( is_callable("cal_days_in_month")){
            $nro_dias= cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        }
        else{
            $nro_dias = date("t",mktime(0,0,0,$mes,1,$anio));
            //$dias = date("d",mktime(0,0,0,$Month+1,0,$Year));
        }
        $mes_anio_i = date("Y-m", strtotime($fecha_inicio));
        $mes_anio_f = date("Y-m", strtotime($fecha_fin));
        if ($mes_anio_i<$mes_anio_f) {
            $costo_total +=($nro_dias-$dia_i+1)*($costo_mes/$nro_dias);
            $dia_i = 1;
        }
        
        //incrementar un mes a un fecha
        $mes_anio_i = date("Y-m",strtotime('+1 month',strtotime($mes_anio_i))); //incrementamos 1 mes
        while ( $mes_anio_i<$mes_anio_f ) {
            $costo_total=$costo_total+$costo_mes;
            //echo $mes_anio_i.'<br>';
            $mes_anio_i = date("Y-m",strtotime('+1 month',strtotime($mes_anio_i)));
        }
        // Calculamos mes final
        $mes = date('n',strtotime($fecha_fin));
        $anio = date('Y',strtotime($fecha_fin));
        if( is_callable("cal_days_in_month")){
            $nro_dias= cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        }
        else{
            $nro_dias = date("t",mktime(0,0,0,$mes,1,$anio));
            //$dias = date("d",mktime(0,0,0,$Month+1,0,$Year));
        }
        $costo_total+=($dia_f-$dia_i+1)*($costo_mes/$nro_dias);
        return $costo_total;
        //echo 'Fecha Inicio: '.$fecha_inicio.' Fecha Final: '.$fecha_fin.' Costo total: '.$costo_total;
        
    }

    public function dias($fecha_inicio='2015-02-14',$fecha_fin='2015-02-14',$costo_dia='20')
    {
        $datetime1 = new DateTime($fecha_inicio);
        $datetime2 = new DateTime($fecha_fin);
        $interval = $datetime1->diff($datetime2);
        $nro_dias = $interval->format('%a')+1;
        $costo_total = $nro_dias*$costo_dia;
        return $costo_total;
    }

    public function horas($fecha_inicio='2014-12-14 10:55',$fecha_fin='2014-12-15 11:55',$costo_hora='20')
    {
        $minutos = (strtotime($fecha_inicio)-strtotime($fecha_fin))/60;
        $minutos = abs($minutos); 
        $minutos = floor($minutos);
        $horas = ceil($minutos/60);
        $costo_total = $horas*$costo_hora;
        return $costo_total;
    }



     public function reporteAction()
     {
        $this->view->disable();
        $model = new Planpagos();
        $resul = $model->lista();
        

include_once('tbs_us/tbs_class.php'); // Load the TinyButStrong template engine
include_once ('tbs_us/tbs_plugin_opentbs/tbs_plugin_opentbs.php'); // Load the OpenTBS plugin

$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

$TBS->VarRef['usuario'] = $this->_user->nombre.' '.$this->_user->paterno;

$data = array();
$c=1;
foreach ($resul as $v) {
    $data[] = array('rank'=> 'A', 'nro'=>$c ,'grupo'=>$v->grupo , 'linea'=>$v->linea, 'estacion'=>$v->estacion, 'razon_social'=>$v->razon_social, 'contrato'=>$v->contrato,'fecha_contrato'=>$v->fecha_contrato,'producto'=>$v->producto,'fecha_inicio'=>$v->fecha_inicio,'fecha_fin'=>$v->fecha_fin,'total'=>$v->total,'deposito'=>$v->deposito,'cobrar'=>$v->total-$v->deposito,'mora'=>number_format($v->mora,2,'.',','));
    $c++;
}

$template = 'file/template/temp_reporte_contratos.xlsx';
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


public function pruebaAction()
{

$clientes=array(1,2,3,4,5,6,7,8,9);
$fechas=array("2015-01-01","2015-02-01","2015-03-01","2015-04-01","2015-05-01","2015-06-01","2015-07-01","2015-08-01","2015-09-01");
$responsables=array(640,641,643,644,645,646,647);
// for ($i=0; $i <500 ; $i++) { 
//     echo $clientes[array_rand($clientes)]."<br>";
//    }   



    for ($i=1; $i < 500; $i++) { 
        $resul = new Contratos();
        $resul->contrato = $i.'/2015';
        $resul->solicitud_id = 10;
        $resul->cliente_id = $clientes[array_rand($clientes)];
        $resul->fecha_contrato = $fechas[array_rand($fechas)];
        $resul->usuario_reg = $this->_user->id;
        $resul->fecha_reg = date("Y-m-d H:i:s");
        $resul->baja_logica = 1;
        $resul->arrendador = "Juan Mamani";
        $resul->arrendador_rep_legal = "Lucas";
        $resul->arrendador_cargo = "cargo";
        $resul->descripcion = "Alquiler de cabinas";
        $resul->dias_tolerancia = 0;
        $resul->porcentaje_mora = 0;
        $resul->responsable_id = $responsables[array_rand($responsables)];
        $resul->save();
    }
    
}

}
