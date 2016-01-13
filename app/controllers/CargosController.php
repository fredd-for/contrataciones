<?php

/**
 * 
 */
class CargosController extends ControllerRrhh {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {
        $this->assets
                ->addCss('/jqwidgets/styles/jqx.base.css')
                ->addCss('/jqwidgets/styles/jqx.custom.css')
                ->addCss('/media/plugins/pines-notify/jquery.pnotify.default.css');
        $this->assets
             ->addJs('/js/jqwidgets/simulator.js')
                    ->addJs('/js/jqwidgets/jqxcore.js')
                    ->addJs('/js/jqwidgets/jqxdata.js')
                    ->addJs('/js/jqwidgets/jqxbuttons.js')
                    ->addJs('/js/jqwidgets/jqxscrollbar.js')
                    ->addJs('/js/jqwidgets/jqxdatatable.js')
                    ->addJs('/js/jqwidgets/jqxlistbox.js')
                    ->addJs('/js/jqwidgets/jqxdropdownlist.js')
                    ->addJs('/js/jqwidgets/jqxpanel.js')
                    ->addJs('/js/jqwidgets/jqxradiobutton.js')
                    ->addJs('/js/jqwidgets/jqxinput.js')
                    // ->addJs('/js/datepicker/bootstrap-datepicker.js')
                    // ->addJs('/js/datatables/dataTables.bootstrap.js')

                    ->addJs('/js/jqwidgets/jqxmenu.js')
                    ->addJs('/js/jqwidgets/jqxgrid.js')
                    ->addJs('/js/jqwidgets/jqxgrid.filter.js')
                    ->addJs('/js/jqwidgets/jqxgrid.sort.js')
                    // ->addJs('/js/jqwidgets/jqxtabs.js')
                    ->addJs('/js/jqwidgets/jqxgrid.selection.js')
                    ->addJs('/js/jqwidgets/jqxcalendar.js')
                    ->addJs('/js/jqwidgets/jqxdatetimeinput.js')
                    ->addJs('/js/jqwidgets/jqxcheckbox.js')
                    ->addJs('/js/jqwidgets/jqxgrid.grouping.js')
                    ->addJs('/js/jqwidgets/jqxgrid.pager.js')
                    ->addJs('/js/jqwidgets/jqxnumberinput.js')
                    // ->addJs('/js/jqwidgets/jqxwindow.js')
                    // ->addJs('/js/jqwidgets/jqxcombobox.js')
                    ->addJs('/js/jqwidgets/jqxexpander.js')
                    // ->addJs('/js/jqwidgets/globalization/globalize.js')
                    // ->addJs('/js/jqwidgets/jqxvalidator.js')
                    // ->addJs('/js/jqwidgets/jqxmaskedinput.js')
                    // ->addJs('/js/jqwidgets/jqxchart.js')
                    ->addJs('/js/jqwidgets/jqxgrid.columnsresize.js')
                    ->addJs('/js/jqwidgets/jqxsplitter.js')
                    // ->addJs('/js/jqwidgets/jqxtree.js')
                    // ->addJs('/js/jqwidgets/jqxdata.export.js')
                    // ->addJs('/js/jqwidgets/jqxgrid.export.js')
                    // ->addJs('/js/jqwidgets/jqxgrid.edit.js')
                    ->addJs('/js/jqwidgets/jqxnotification.js')
                    // ->addJs('/js/jqwidgets/jqxbuttongroup.js')
                    
                ->addJs('/media/plugins/bootbox/bootbox.min.js')
                ->addJs('/media/plugins/form-validation/jquery.validate.min.js')
                ->addJs('/scripts/cargos/index.js');

        // $this->tag->setDefault("organigrama_id", 3);
        $organigrama = $this->tag->select(
                array(
                    'organigrama_id',
                    Organigramas::find(array('baja_logica=1', 'order' => 'unidad_administrativa ASC')),
                    'using' => array('id', "unidad_administrativa"),
                    'useEmpty' => true,
                    'emptyText' => '(Selecionar)',
                    'emptyValue' => '',
                    'class' => 'form-control',
                )
        );

        $this->view->setVar('organigrama', $organigrama);

        $organigrama_rep_pac = $this->tag->select(
                array(
                    'organigrama_id_rep_pac',
                    Organigramas::find(array('baja_logica=1', 'order' => 'unidad_administrativa ASC')),
                    'using' => array('id', "unidad_administrativa"),
                    'useEmpty' => true,
                    'emptyText' => '(Selecionar)',
                    'emptyValue' => '',
                    'class' => 'form-control',
                )
        );

        $this->view->setVar('organigrama_rep_pac', $organigrama_rep_pac);

        $finpartida = $this->tag->select(
                array(
                    'fin_partida_id',
                    Finpartidas::find(array('baja_logica=1', 'order' => 'id ASC')),
                    'using' => array('id', "denominacion"),
                    'useEmpty' => true,
                    'emptyText' => '(Selecionar)',
                    'emptyValue' => '',
                    'class' => 'form-control'
                )
        );
        $this->view->setVar('finpartida', $finpartida);

        $nivelsalarial = $this->tag->select(
                array(
                    'codigo_nivel',
                    Nivelsalariales::find(array('baja_logica=1', 'order' => 'id ASC')),
                    'using' => array('id', "denominacion"),
                    'useEmpty' => tue,
                    'emptyText' => '(Selecionar)',
                    'emptyValue' => '',
                    'class' => 'form-control'
                )
        );
// $nivelsalarial = Nivelsalariales::find(array('baja_logica=1','order' => 'id ASC'));
        $this->view->setVar('nivelsalarial', $nivelsalarial);

// $cargoestado=Cargosestados::find(array('baja_logica=1','order' => 'id ASC'));
// $this->view->setVar('cargoestado',$cargoestado);

        $condicion = $this->tag->select(
                array(
                    'condicion_id',
                    Condiciones::find(array('baja_logica=1', 'order' => 'id ASC')),
                    'using' => array('id', "condicion"),
                    'useEmpty' => true,
                    'emptyText' => '(Selecionar)',
                    'emptyValue' => '',
                    'class' => 'form-control',
                )
        );
        $this->view->setVar('condicion', $condicion);
    }

    public function listAction() {
        //$resul = Cargos::find(array('baja_logica=:activo1:','bind'=>array('activo1'=>'1'),'order' => 'id ASC'));
        $model = new Cargos();
        $resul = $model->lista();
        $this->view->disable();
        foreach ($resul as $v) {
            $customers[] = array(
                'id' => $v->id,
                'unidad_administrativa' => $v->unidad_administrativa,
                'organigrama_id' => $v->organigrama_id,
                'codigo_nivel' => $v->codigo_nivel,
                'codigo' => $v->codigo,
                'cargo' => $v->cargo,
                'denominacion' => $v->denominacion,
                'sueldo' => intval($v->sueldo),
                'depende_id' => $v->depende_id,
                'estado' => $v->estado1,
                'condicion' => $v->condicion,
                'fin_partida_id' => $v->fin_partida_id,
                'partida' => $v->partida,
                'fuente_codigo' => $v->fuente_codigo,
                'fuente' => $v->fuente,
                'organismo_codigo' => $v->organismo_codigo,
                'organismo' => $v->organismo
            );
        }
        echo json_encode($customers);
    }

    public function listorganigramaAction() {
        $resul = Organigramas::find(array('baja_logica=1', 'order' => 'id ASC'));
        foreach ($resul as $v) {
            $customers[] = array(
                'id' => $v->id,
                'unidad_administrativa' => $v->unidad_administrativa,
                'sigla' => $v->sigla
            );
        }
        $this->view->disable();
        echo json_encode($customers);
    }

    public function listnivelsalarialAction() {
        $resul = Nivelsalariales::find(array('baja_logica=1 and activo=1', 'order' => 'id ASC'));
        foreach ($resul as $v) {
            $customers[] = array(
                'id' => $v->id,
                'denominacion' => $v->denominacion,
                'sueldo' => $v->sueldo
            );
        }
        $this->view->disable();
        echo json_encode($customers);
    }

    public function listfinpartidaAction() {
        $resul = Finpartidas::find(array('baja_logica=1', 'order' => 'id ASC'));
        foreach ($resul as $v) {
            $customers[] = array(
                'id' => $v->id,
                'denominacion' => $v->denominacion,
                'partida' => $v->partida
            );
        }
        $this->view->disable();
        echo json_encode($customers);
    }

    public function getSueldoAction() {
        $resul = Nivelsalariales::findFirstById($_POST['id']);

        $this->view->disable();
        echo json_encode(floatval($resul->sueldo));
    }

    public function saveAction() {
        if (isset($_POST['id'])) {

            if ($_POST['id'] > 0) {
                $resul = Cargos::findFirstById($_POST['id']);
                $resul->organigrama_id = $_POST['organigrama_id'];
                if ($_POST['depende_id'] != "") {
                    $resul->depende_id = $_POST['depende_id'];
                } else {
                    $resul->depende_id = 0;
                }

                $resul->codigo = $_POST['codigo'];
                $resul->cargo = $_POST['cargo'];
                $resul->codigo_nivel = $_POST['codigo_nivel'];
                $resul->fin_partida_id = $_POST['fin_partida_id'];
                $resul->user_mod_id = $user->id;
                $resul->fecha_mod = date("Y-m-d H:i:s");
                $resul->formacion_requerida = $_POST['formacion_requerida'];
                $resul->save();
            } else {
                /* 	//$this->_registerSession($user);
                  $finpartida=Finpartidas::findFirstById($_POST['fin_partida_id']);
                  if ($finpartida != false)
                  {

                  $finpartida->contador=$finpartida->contador+1;
                  $finpartida->save();
                  $codigo = $finpartida->codigo.'.'.substr('0000'.$finpartida->contador,-5);
                  }
                  else{
                  $msm = array('msm' => 'Error: Generacion de codigo' );
                  }
                 */
                $resul = new Cargos();
                $resul->organigrama_id = $_POST['organigrama_id'];
                if ($_POST['depende_id'] != "") {
                    $resul->depende_id = $_POST['depende_id'];
                } else {
                    $resul->depende_id = 0;
                }

                $resul->ejecutora_id = 1;
                $resul->codigo = $_POST['codigo']; //generar
                $resul->cargo = $_POST['cargo'];
                $resul->codigo_nivel = $_POST['codigo_nivel'];
                $resul->cargo_estado_id = 1;
                $resul->estado = 0;
                $resul->baja_logica = 1;
                $resul->user_reg_id = $user->id;
                $resul->fecha_reg = date("Y-m-d H:i:s");
                $resul->fin_partida_id = $_POST['fin_partida_id'];
                $resul->poa_id = 1;
                $resul->formacion_requerida = $_POST['formacion_requerida'];
                //$resul->save();
                if ($resul->save()) {
                    $msm = array('msm' => 'Exito: Se guardo correctamente');
                } else {
                    $msm = array('msm' => 'Error: No se guardo el registro');
                }
            }
        }
        $this->view->disable();
        echo json_encode();
    }

    public function save_pacAction() {
        if (isset($_POST['cargo_id_pac'])) {
            // $date = new DateTime($_POST['fecha_ini']);
            // $fecha_ini = $date->format('Y-m-d');
            // $date = new DateTime($_POST['fecha_fin']);
            // $fecha_fin = $date->format('Y-m-d');

            $fecha_ini = date("Y-m-d", strtotime($_POST['fecha_ini']));
            $fecha_fin = date("Y-m-d", strtotime($_POST['fecha_fin']));

            if ($_POST['cargo_id_pac'] > 0) {
                $resul = new Pacs();
                $resul->cargo_id = $_POST['cargo_id_pac'];
                $resul->gestion = $_POST['gestion'];
                $resul->fecha_ini = $fecha_ini;
                $resul->fecha_fin = $fecha_fin; //generar
                $resul->unidad_sol_id = 1;
                $resul->usuario_sol_id = 1;
                //$resul->fecha_apr=date('Y-m-d');
                //$resul->usuario_apr_id=1;

                $resul->estado = 1;
                $resul->baja_logica = 1;
                if ($resul->save()) {
                    $msm = 'Exito: Se guardo correctamente';
                } else {
                    $msm = 'Error: No se guardo el registro';
                }
            }
        }
        $this->view->disable();
        echo json_encode($msm);
    }

    public function deleteAction() {
        $resul = Cargos::findFirstById($_POST['id']);
        $resul->baja_logica = 0;
        $resul->save();
        $this->view->disable();
        echo json_encode();
    }

    public function listpacAction() {
        //$resul = Cargos::find(array('baja_logica=:activo1:','bind'=>array('activo1'=>'1'),'order' => 'id ASC'));
        $model = new Cargos();
        $resul = $model->listapac();
        $this->view->disable();
        foreach ($resul as $v) {
            $customers[] = array(
                'nro' => $v->nro,
                'id' => $v->id,
                'unidad_administrativa' => $v->unidad_administrativa,
                'cargo' => $v->cargo,
                'gestion' => $v->gestion,
                'estado' => $v->estado1,
                'fecha_ini' => date("d-m-Y", strtotime($v->fecha_ini)),
                'fecha_fin' => date("d-m-Y", strtotime($v->fecha_fin))
            );
        }
        echo json_encode($customers);
    }

    public function listdependeAction() {
        if (isset($_GET['organigrama_id'])) {
            $resul = Cargos::find(array('baja_logica=1 and organigrama_id=' . $_GET['organigrama_id'], 'order' => 'id ASC'));
            $this->view->disable();
            foreach ($resul as $v) {
                $customers[] = array(
                    'id' => $v->id,
                    'organigrama' => $v->organigrama_id,
                    'codigo' => $v->codigo,
                    'cargo' => $v->cargo
                );
            }
        }

        echo json_encode($customers);
    }

    public function listPersonalAction() {
        if (isset($_GET['organigrama_id'])) {
            $model = new Cargos();
            $resul = $model->getPersonalOrganigrama($_GET['organigrama_id']);
            $this->view->disable();
            foreach ($resul as $v) {
                $customers[] = array(
                    'id' => $v->id,
                    'nombre' => $v->nombre,
                    'cargo' => $v->cargo
                );
            }
        }

        echo json_encode($customers);
    }

    public function delete_pacAction() {
        $resul = Pacs::findFirstById($_POST['id']);
        $resul->baja_logica = 0;
        $resul->save();
        $this->view->disable();
        echo json_encode();
    }

    public function getEstadoSeguimientoAction() {
        $model = new Cargos();
        $resul = $model->getEstadoSeguimiento($_POST['cargo_id']);
        $this->view->disable();
        $estado = null;
        foreach ($resul as $v) {
            $estado = $v->estado1;
        }
        echo json_encode($estado);
    }

    public function exportarPdfAction() {
        //$pdf = new fpdf();
        $pdf = new pdfoasis('L', 'mm', 'Letter');
        $pdf->pageWidth = 280;
        $pdf->AddPage();
        //$title = utf8_decode('Reporte de Cargos');
        $pdf->debug = 0;
        $pdf->title_rpt = utf8_decode('Reporte de Cargos');
        $pdf->header_title_empresa_rpt = utf8_decode('Empresa Estatal de Transporte por Cable "Mi Teleférico"');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetXY(110, 28);
        $pdf->Cell(0, 0, "REPORTE DE CARGOS");
        $miCabecera = array('Nro', 'Organigrama', 'Item', 'Cargo', 'Sueldo', 'Estado', 'Tipo Cargo');

        $pdf->SetXY(10, 35);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(52, 151, 219); //Fondo verde de celda
        $pdf->SetTextColor(240, 255, 240); //Letra color blanco
        $pdf->Cell(10, 7, 'Nro', 1, 0, 'L', true);
        $pdf->Cell(80, 7, 'Organigrama', 1, 0, 'L', true);
        $pdf->Cell(15, 7, 'Item', 1, 0, 'L', true);
        $pdf->Cell(80, 7, 'Cargo', 1, 0, 'L', true);
        $pdf->Cell(20, 7, 'Sueldo', 1, 0, 'L', true);
        $pdf->Cell(20, 7, 'Estado', 1, 0, 'L', true);
        $pdf->Cell(20, 7, 'Tipo Cargo', 1, 0, 'L', true);
        // foreach($miCabecera as $fila)
        // 	{
        // 	    //Atención!! el parámetro true rellena la celda con el color elegido
        // 		$pdf->Cell(24,7, utf8_decode($fila),1, 0 , 'L', true);
        // 	}
        $pdf->SetXY(10, 42);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
        $bandera = false; //Para alternar el relleno
        $model = new Cargos();
        $resul = $model->lista($_POST['organigrama_id'], $_POST['estado_rep'], $_POST['condicion_id']);
        foreach ($resul as $v) {
            $pdf->Cell(10, 7, utf8_decode($v->nro), 1, 0, 'L', $bandera);
            $pdf->Cell(80, 7, utf8_decode($v->unidad_administrativa), 1, 0, 'L', $bandera);
            $pdf->Cell(15, 7, utf8_decode($v->codigo), 1, 0, 'L', $bandera);
            $pdf->Cell(80, 7, utf8_decode($v->cargo), 1, 0, 'L', $bandera);
            $pdf->Cell(20, 7, utf8_decode($v->sueldo), 1, 0, 'L', $bandera);
            $pdf->Cell(20, 7, utf8_decode($v->estado1), 1, 0, 'L', $bandera);
            $pdf->Cell(20, 7, utf8_decode($v->condicion), 1, 0, 'L', $bandera);
            $pdf->Ln(); //Salto de línea para generar otra fila
            $bandera = !$bandera; //Alterna el valor de la bandera
        }
        $pdf->Output();
        $this->view->disable();
    }

    public function exportarExcelAction() {
        global $config;

        $loader = new \Phalcon\Loader();

        $loader->registerDirs(
                array(
                    $config->application->libraryDir . "PHPExcel/"
                )
        );

        $loader->register();

        $excel = new PHPExcel();
        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setTitle('test worksheet');

        $excel->getActiveSheet()->setCellValue('A1', 'Rezultati pretrage');
        $excel->getActiveSheet()->setCellValue('A2', "Ime");
        $excel->getActiveSheet()->setCellValue('C2', "Prezime");
        $excel->getActiveSheet()->setCellValue('F2', "Adresa stanovanja");

        $br = rand(0, 1000000);
        $naziv = $br . ".xls";
        $objWriter = new PHPExcel_Writer_Excel2007($excel);
        $objWriter->save('../tmp/' . $naziv);
    }

    public function exportarPacPdfAction() {
        //$pdf = new fpdf();
        $pdf = new pdfoasis('L', 'mm', 'Letter');
        $pdf->pageWidth = 280;
        $pdf->AddPage();
        //$title = utf8_decode('Reporte de Cargos');
        $pdf->debug = 0;
        $pdf->title_rpt = utf8_decode('Reporte de Plan Anual de Contratacion de Personal');
        $pdf->header_title_empresa_rpt = utf8_decode('Empresa Estatal de Transporte por Cable "Mi Teleférico"');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetXY(50, 28);
        $pdf->Cell(0, 0, "REPORTE DE PLAN ANUAL DE CONTRATACIONES DE PERSONAL");
        // $miCabecera = array('Nro', 'Organigrama', 'Item', 'Cargo','Sueldo','Estado','Tipo Cargo');

        $pdf->SetXY(10, 35);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(52, 151, 219); //Fondo verde de celda
        $pdf->SetTextColor(240, 255, 240); //Letra color blanco
        $pdf->Cell(10, 7, 'Nro', 1, 0, 'L', true);
        $pdf->Cell(80, 7, 'Organigrama', 1, 0, 'L', true);
        $pdf->Cell(80, 7, 'Cargo', 1, 0, 'L', true);
        $pdf->Cell(20, 7, 'Fecha Inicio', 1, 0, 'L', true);
        $pdf->Cell(20, 7, 'Fecha Finalizacion', 1, 0, 'L', true);
        $pdf->Cell(20, 7, 'Estado', 1, 0, 'L', true);
        // foreach($miCabecera as $fila)
        // 	{
        // 	    //Atención!! el parámetro true rellena la celda con el color elegido
        // 		$pdf->Cell(24,7, utf8_decode($fila),1, 0 , 'L', true);
        // 	}
        $pdf->SetXY(10, 42);
        $pdf->SetFont('Arial', '', 7);
        $pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
        $bandera = false; //Para alternar el relleno
        $model = new Cargos();
        $fecha_ini = date("Y-m-d", strtotime($_POST['fecha_ini_rep_pac']));
        $fecha_fin = date("Y-m-d", strtotime($_POST['fecha_fin_rep_pac']));
        $resul = $model->listapac('', $_POST['organigrama_id_rep_pac'], $fecha_ini, $fecha_fin);
        foreach ($resul as $v) {
            $pdf->Cell(10, 7, utf8_decode($v->nro), 1, 0, 'L', $bandera);
            $pdf->Cell(80, 7, utf8_decode($v->unidad_administrativa), 1, 0, 'L', $bandera);
            $pdf->Cell(80, 7, utf8_decode($v->cargo), 1, 0, 'L', $bandera);
            $pdf->Cell(20, 7, utf8_decode($v->fecha_ini), 1, 0, 'L', $bandera);
            $pdf->Cell(20, 7, utf8_decode($v->fecha_fin), 1, 0, 'L', $bandera);
            $pdf->Cell(20, 7, utf8_decode($v->estado1), 1, 0, 'L', $bandera);
            $pdf->Ln(); //Salto de línea para generar otra fila
            $bandera = !$bandera; //Alterna el valor de la bandera
        }
        $pdf->Output();
        $this->view->disable();
    }

    public function dependenciaAction($id = '') {

        $resul = Cargos::find(array('baja_logica=1 and organigrama_id=' . $id, 'order' => 'id ASC'));
        $this->view->disable();
        $options = '<option value="">(Seleccionar)</option>';

        foreach ($resul as $v) {
            $options.='<option value="' . $v->id . '">' . $v->cargo . '</option>';
        }


        echo $options;
    }

}

?>