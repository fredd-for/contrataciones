<?php
/**
 * Description of ExcelController
 *
 * @author Ivan Marcelo
 */
use Phalcon\Mvc\Controller;
class ExcelController extends Controller {

//put your code here
    public function reporteAction() {
      /*  $proyectos_id = substr($_GET['datos'], 0, -1);  //quitamos la ultima (,)
        $columnas = substr($_GET['columnas'], 0, -1); //quitamos la ultima (,)
        // $columnas=  substr($columnas, 6);
        $columnas = explode(',', $columnas);
        $titulos = substr($_GET['titulos'], 0, -1); //quitamos la ultima (,)
        //$titulos=  substr($titulos, 3);
        $titulos = strtoupper($titulos); //titulos en mayuscula
        $titulos = explode(',', $titulos);
        $grupos = $_GET['grupo'];
        $grupos = explode(',', $grupos);
        $orden = $_GET['orden'];
        $dir = $_GET['dir'];

        $sql = "SELECT 1 as suma,mov.id,e.estacion,CONCAT(du.nombres,' ',du.apellidos) as de_user,
                CONCAT(au.nombres,' ',au.apellidos) as a_user, 
                v.valor,m.motivo,mov.inicio,mov.fin,mov.cantidad,mov.fecha,
                mov.resto_inicio,mov.resto_fin,
                mov.cantidad_vendida,mov.saldo,
                mov.costo_unitario,
                mov.cantidad_vendida*mov.costo_unitario as venta,mov.fecha_devolucion
                FROM mtmovimiento mov                 
                INNER JOIN mtestaciones e ON mov.estacion_id=e.id
                INNER JOIN operador du ON mov.d_user=du.codigo
                INNER JOIN operador au ON mov.a_user=au.codigo
                INNER JOIN mtvalores v ON mov.valor_id=v.id
                INNER JOIN mtmotivo m ON mov.motivo_id=m.id ";
        $sql.=" WHERE mov.id IN (";
        $sql.=$proyectos_id;
        $sql.=")";

        if ($orden != "") {
            $sql.=" ORDER BY " . $orden;
            if ($dir) {
                $sql.=" " . $dir;
            }
        }
        //  var_dump($sql);
        // var_dump($columnas);
        //echo $sql;
        /* $con = $this->getDI()->get('db');
          $proyectos = $con->query($sql);
          $proyectos->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
         */
     //   $proyectos = $this->modelsManager->executeQuery($sql);
        $celdas = array(
            0 => 'A',
            1 => 'B',
            2 => 'C',
            3 => 'D',
            4 => 'E',
            5 => 'F',
            6 => 'G',
            7 => 'H',
            8 => 'I',
            9 => 'J',
            10 => 'K',
            11 => 'L',
            12 => 'M',
            13 => 'N',
            14 => 'O',
            15 => 'P',
            16 => 'Q',
            17 => 'R',
            18 => 'S',
            19 => 'T',
            20 => 'U',
            21 => 'V',
            22 => 'W',
            23 => 'X',
            24 => 'Y',
            25 => 'Z',
        );
        
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Ivan Chacolla")
                ->setLastModifiedBy("Ivan Chacolla")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Ivan Chacolla");
//styles
//Titulos
        $styleTitle = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'argb' => PHPExcel_Style_Color::COLOR_WHITE,
                ),
                'name' => 'Arial',
                'size' => 8,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'argb' => 'FF135982',
                ),
            ),
        );
        $borders = array(
            'font' => array(
                'name' => 'Arial',
                'size' => 8,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $derecha = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );

        $totals = array();
        $results = array();
        $row = 2;
        //VEMOS SI el group tiene datos
        //$grupos = array_reverse($grupos);
        //var_dump($grupos);
       /* $count = count($titulos);
        $mGrupo = array();
        $aProyectos = array();
        foreach ($proyectos as $k => $v) {
            foreach ($columnas as $key => $col) {
                $aProyectos[$k][$col] = $v[$col];
                //array_push($colx, $v[$col]);
            }
        }
        $matriz = array();
        // var_dump($grupos);

        $contador = sizeof($grupos);
        if ($grupos[0] != '') {
            foreach ($grupos as $k => $g) {
                //   $nombre='grupo'.$g;
                $grupo = array();
                switch ($contador) {
                    case 1:
                        foreach ($proyectos as $key => $v) {
                            //$clave = $v[$g];
                            $clave1 = $v[$g];
                            if ($k == 0)
                                $grupo[$clave1][$key] = $aProyectos[$key];
                        }
                        break;
                    case 2:
                        foreach ($proyectos as $key => $v) {

                            $clave1 = $v[$grupos[0]];
                            $clave2 = $v[$grupos[1]];
                            if ($k == 1)
                                $grupo[$clave1][$clave2][$key] = $aProyectos[$key];
                            else
                                $grupo[$clave1][$clave2][$key] = $aProyectos[$key][$g];
                        }
                        break;
                    case 3:
                        foreach ($proyectos as $key => $v) {

                            $clave1 = $v[$grupos[0]];
                            $clave2 = $v[$grupos[1]];
                            $clave3 = $v[$grupos[2]];
                            if ($k == 2)
                                $grupo[$clave1][$clave2][$clave3][$key] = $aProyectos[$key];
                            else
                                $grupo[$clave1][$clave2][$clave3][$key] = $aProyectos[$key][$g];
                        }
                        break;
                    case 4:
                        foreach ($proyectos as $key => $v) {

                            $clave1 = $v[$grupos[0]];
                            $clave2 = $v[$grupos[1]];
                            $clave3 = $v[$grupos[2]];
                            $clave4 = $v[$grupos[3]];
                            if ($k == 3)
                                $grupo[$clave1][$clave2][$clave3][$clave4][$key] = $aProyectos[$key];
                            else
                                $grupo[$clave1][$clave2][$clave3][$clave4][$key] = $aProyectos[$key][$g];
                        }
                        break;

                    default:
                        $grupo = $aProyectos;
                        break;
                }
            }
        }
        else {
            $contador = 0;
            $grupo = $aProyectos;
            //  var_dump($grupo);
        }
        switch ($contador) {
            case 1:
                foreach ($grupo as $k1 => $v1) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $k1);
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':' . $celdas[$count + 0] . $row);
                    //$objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':' . $celdas[$count + 0] . $row)->applyFromArray($styleTitle);
                    $row++;
                    $objPHPExcel->getActiveSheet()->fromArray(array_values($titulos), NULL, 'B' . $row);
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $row . ':' . $celdas[$count + 0] . $row)->applyFromArray($styleTitle);
                    $row++;
                    foreach ($v1 as $k2 => $v2) {
                        $objPHPExcel->getActiveSheet()->fromArray(array_values($v2), NULL, 'B' . $row);
                        $objPHPExcel->getActiveSheet()->getStyle('B' . $row . ':' . $celdas[$count + 0] . $row)->applyFromArray($borders);
                        $row++;
                    }
                    $row++;
                }
                break;
            case 2:
                foreach ($grupo as $k1 => $v1) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $k1);
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':' . $celdas[$count + 2] . $row);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $row . ':' . $celdas[$count + 1] . $row)->applyFromArray($styleTitle);
                    $row++;
                    foreach ($v1 as $k2 => $v2) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, $k2);
                        $objPHPExcel->getActiveSheet()->mergeCells('B' . $row . ':' . $celdas[$count + 2] . $row);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $row . ':' . $celdas[$count + 1] . $row)->applyFromArray($styleTitle);
                        $row++;
                        $objPHPExcel->getActiveSheet()->fromArray(array_values($titulos), NULL, 'C' . $row);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $row . ':' . $celdas[$count + 2] . $row)->applyFromArray($styleTitle);
                        $row++;
                        foreach ($v2 as $k3 => $v3) {
                            $objPHPExcel->getActiveSheet()->fromArray(array_values($v3), NULL, 'C' . $row);
                            $objPHPExcel->getActiveSheet()->getStyle('C' . $row . ':' . $celdas[$count + 2] . $row)->applyFromArray($borders);
                            $row++;
                        }
                        //sumatorias
                        $row++;
                    }
                }

                break;
            case 3:
                foreach ($grupo as $k1 => $v1) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $k1);
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':' . $celdas[$count + 2] . $row);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $row . ':' . $celdas[$count + 1] . $row)->applyFromArray($styleTitle);
                    $row++;
                    foreach ($v1 as $k2 => $v2) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, $k2);
                        $objPHPExcel->getActiveSheet()->mergeCells('B' . $row . ':' . $celdas[$count + 2] . $row);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $row . ':' . $celdas[$count + 1] . $row)->applyFromArray($styleTitle);
                        $row++;
                        foreach ($v2 as $k3 => $v3) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $k3);
                            $objPHPExcel->getActiveSheet()->mergeCells('C' . $row . ':' . $celdas[$count + 2] . $row);
                            $objPHPExcel->getActiveSheet()->getStyle('C' . $row . ':' . $celdas[$count + 1] . $row)->applyFromArray($styleTitle);
                            $row++;
                            $objPHPExcel->getActiveSheet()->fromArray(array_values($titulos), NULL, 'D' . $row);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $row . ':' . $celdas[$count + 2] . $row)->applyFromArray($styleTitle);
                            $row++;
                            foreach ($v3 as $k4 => $v4) {
                                $objPHPExcel->getActiveSheet()->fromArray(array_values($v4), NULL, 'D' . $row);
                                $objPHPExcel->getActiveSheet()->getStyle('D' . $row . ':' . $celdas[$count + 2] . $row)->applyFromArray($borders);
                                $row++;
                            }
                        }
                    }
                }
                break;
            case 4:
                foreach ($grupo as $k1 => $v1) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $k1);
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':' . $celdas[$count + 2] . $row);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $row . ':' . $celdas[$count + 1] . $row)->applyFromArray($styleTitle);
                    $row++;
                    foreach ($v1 as $k2 => $v2) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, $k2);
                        $objPHPExcel->getActiveSheet()->mergeCells('B' . $row . ':' . $celdas[$count + 2] . $row);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . $row . ':' . $celdas[$count + 1] . $row)->applyFromArray($styleTitle);
                        $row++;
                        foreach ($v2 as $k3 => $v3) {
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $k3);
                            $objPHPExcel->getActiveSheet()->mergeCells('C' . $row . ':' . $celdas[$count + 2] . $row);
                            $objPHPExcel->getActiveSheet()->getStyle('C' . $row . ':' . $celdas[$count + 1] . $row)->applyFromArray($styleTitle);
                            $row++;
                            foreach ($v3 as $k4 => $v4) {
                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $k4);
                                $objPHPExcel->getActiveSheet()->mergeCells('D' . $row . ':' . $celdas[$count + 2] . $row);
                                $objPHPExcel->getActiveSheet()->getStyle('D' . $row . ':' . $celdas[$count + 1] . $row)->applyFromArray($styleTitle);
                                $row++;
                                $objPHPExcel->getActiveSheet()->fromArray(array_values($titulos), NULL, 'E' . $row);
                                $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':' . $celdas[$count + 2] . $row)->applyFromArray($styleTitle);
                                $row++;
                                foreach ($v4 as $k5 => $v5) {
                                    $objPHPExcel->getActiveSheet()->fromArray(array_values($v5), NULL, 'F' . $row);
                                    $objPHPExcel->getActiveSheet()->getStyle('F' . $row . ':' . $celdas[$count + 2] . $row)->applyFromArray($borders);
                                    $row++;
                                }
                            }
                        }
                    }
                }
                break;

            default:
                $objPHPExcel->getActiveSheet()->fromArray(array_values($titulos), NULL, 'A' . $row);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':' . $celdas[$count] . $row)->applyFromArray($styleTitle);
                $row++;
                foreach ($grupo as $k1 => $v1) {
                    $objPHPExcel->getActiveSheet()->fromArray(array_values($v1), NULL, 'A' . $row);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':' . $celdas[$count] . $row)->applyFromArray($borders);
                    $row++;
                }
                break;
        }*/
        /*
          //indices de celdas
          $uh = 0; //uh_aprobado
          $uh_monto = 0;
          $costo_proyecto = 0;
          foreach ($columnas as $k => $c) {
          switch ($c) {
          case 'uh_ejecucion':
          $uh = $k;
          break;
          case 'monto_con_aev':
          $uh_monto = $k;
          break;
          case 'costo_proyecto':
          $costo_proyecto = $k;
          break;
          }
          }
          $uh_total = '=SUM(';
          $costo_total = '=SUM(';
          foreach ($grupo as $key => $value) {
          //titulo
          $inicio = $row;
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $key);
          $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':' . $celdas[$count] . $row);
          $row++;
          $objPHPExcel->getActiveSheet()->fromArray(array_values($titulos), NULL, 'B' . $row);
          $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':' . $celdas[$count] . $row)->applyFromArray($styleTitle);
          $row++;

          //INDICES
          $linea = $row;
          for ($i = 1; $i <= count($value); $i++) {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A' . $linea, $i);
          $linea++;
          }
          $row1 = $row;
          $objPHPExcel->getActiveSheet()->fromArray(array_values($value), NULL, 'B' . $row);
          $row+=sizeof($value);

          $objPHPExcel->getActiveSheet()->getStyle('A' . $row1 . ':' . $celdas[$count] . $row)->applyFromArray($borders);
          //sumatorias
          if (in_array('uh_ejecucion', $columnas)) {
          $celda = $celdas[$uh + 1];
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue($celda . $row, '=SUM(' . $celda . $row1 . ':' . $celda . ($row - 1) . ')');
          //total
          $uh_total.=$celda . $row . '+';
          if (in_array('costo_proyecto', $columnas)) {
          $celda = $celdas[$costo_proyecto + 1];
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue($celda . $row, '=SUM(' . $celda . $row1 . ':' . $celda . ($row - 1) . ')');
          //costo total
          $costo_total.=$celda . $row . '+';
          }
          $row++;
          }
          //formato numero
          for ($i = $row1; $i <= $row; $i++) {
          $celda = $celdas[$costo_proyecto + 1];
          $objPHPExcel->getActiveSheet()->getStyle($celda . $i)->getNumberFormat()->setFormatCode('"Bs "#,##0.00_-');
          $objPHPExcel->getActiveSheet()->getStyle($celda . $i . ':' . $celdas[$count] . $row)->applyFromArray($derecha);
          }
          //formato numero
          for ($i = $row1; $i <= $row; $i++) {
          $celda = $celdas[$uh_monto + 1];
          $objPHPExcel->getActiveSheet()->getStyle($celda . $i)->getNumberFormat()->setFormatCode('"Bs "#,##0.00_-');
          $objPHPExcel->getActiveSheet()->getStyle($celda . $i . ':' . $celdas[$count] . $row)->applyFromArray($derecha);
          }

          $row++;
          }

          //TOTAL
          $celda = $celdas[$uh + 1];
          $uh_total = substr($uh_total, 0, -1) . ')';
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue($celda . $row, $uh_total);

          $celda = $celdas[$costo_proyecto + 1];
          $costo_total = substr($costo_total, 0, -1) . ')';
          $objPHPExcel->setActiveSheetIndex(0)->setCellValue($celda . $row, $costo_total);

          foreach ($columnas as $k => $c) {
          $objPHPExcel->getActiveSheet()->getColumnDimension($celdas[$k])->setAutoSize(true);
          }
         * 
         */
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('SISTEMA COMERCIALIZACION');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel2007)

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="VENTA_VALORES.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

}
