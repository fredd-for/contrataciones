<?php

class iframeController extends \Phalcon\Mvc\Controller {

    //login  
    public function PersonigramaAction($id) {

        $this->view->setMainView('iframe');
        $this->view->setLayout('iframe');

        $this->assets
                ->addCss('/media/plugins/org/css/primitives.latest.css')
        //->addCss('/js/jorgxchart/custom.css')
        ;
        $this->assets
                ->addJs('/js/jorgchart/jquery.jOrgChart.js')
                ->addJs('/media/plugins/org/js/jquery/jquery-ui-1.10.2.custom.min.js')
                ->addJs('/media/plugins/org/js/primitives.min.js')
                ->addJs('/scripts/personigrama.js')
        ;
        $this->view->setVar('id', $id);
    }

}
