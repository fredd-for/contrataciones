<?php 
/**
* 
*/
class MorasController extends ControllerBase
{
    
    public function indexAction()
    {
        $this->assets
                ->addCss('/jqwidgets/styles/jqx.base.css')
                ->addCss('/jqwidgets/styles/jqx.custom.css')
                ;
        $this->assets
                ->addJs('/js/tinymce/tinymce.min.js')
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
                // ->addJs('/js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')
                // ->addJs('/media/plugins/form-validation/jquery.validate.min.js')
                // ->addJs('/assets/js/plugins.js')
                // ->addJs('/assets/js/pages/formsValidation.js')
                
                ->addJs('/scripts/moras/index.js')
        ;
    }

    public function listAction()
    {   $this->view->disable();
        $model = new Planpagos();
        $resul = $model->listamoraspendientes();
        $customers = array();
        foreach ($resul as $v) {
            $mora = $v->mora_total;
            $dias_atraso = $v->diferencia_dias;
            if ($v->mora>0) {
                $mora = $v->mora;
                $dias_atraso = $v->dias_atraso;
            }
            $customers[] = array(
                'id' => $v->id,
                'razon_social' => $v->razon_social,
                'correo' => $v->correo,
                'representante_legal' => $v->representante_legal,
                'correo_representante_legal' => $v->correo_representante_legal,
                'nombre_ref' => $v->nombre_ref,
                'correo_ref' => $v->correo_ref,
                'nit' => $v->nit,
                'grupo' => $v->grupo,
                'linea' => $v->linea,
                'estacion' => $v->estacion,
                'contrato' => $v->contrato,
                'producto' => $v->producto,
                'fecha_programado' => $v->fecha_programado.' 00:00:00',
                'monto_reprogramado' => $v->monto_reprogramado,
                'monto_depositado' => $v->monto_depositado,
                'diferencia_dias' => $v->diferencia_dias,
                'deposito_mora_total' => $v->deposito_mora_total,
                'mora' => $mora,
                'dias_atraso' => $dias_atraso,
                'accion'=>'<a href="/planpagos/controlpago/'.$v->contratoproducto_id.'" class="btn btn-xs btn-primary" title="Ver Plan Pago"><i class="fa fa-share-square-o"></i></a>'
            );
        }
        echo json_encode($customers);
        
    }

}
