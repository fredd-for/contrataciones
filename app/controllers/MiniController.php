<?php

class MiniController extends \Phalcon\Mvc\Controller {

    protected $_user;
    protected $_con;

    public function beforeExecuteRoute() {
        //Check whether the "auth" variable exists in session to define the active role
        $auth = $this->session->get('auth');
        if (!$auth) {
            header('Location: /login');
        }
        return true;
    }

    protected function initialize() {
        $auth = $this->session->get('auth');
        if (!isset($auth['id'])) {
            $this->response->redirect('/login');
            //parent::initialize();
        } else {

            //obtenemos la instancia del usuario
            $user_id = $auth['id'];
            $this->_user = usuarios::findFirst("id = '$user_id'");
            //Prepend the application name to the title
            $this->tag->setTitle('Sistema de Recurso Humanos');
            
            ;
            //menu
            $this->menu($this->_user->nivel);
            $this->view->setVar('user', $this->_user);
        }
    }

    protected function usuario() {
        $auth = $this->session->get('cite');
        if ($auth) {
            $user_id = $auth['id'];
            $this->_user = usuarios::findFirst("id = '$user_id'");
            return $this->_user;
        } else {
            return false;
        }
    }

    protected function forward($uri) {
        $uriParts = explode('/', $uri);
        return $this->dispatcher->forward(
                        array(
                            'controller' => $uriParts[0],
                            'action' => $uriParts[1]
                        )
        );
    }

    //menu de acuerdo al nivel
    protected function menu($nivel) {
        $mMenu = new menus();
        $menus = $mMenu->listaNivel($nivel);
        $this->view->setVar('menus', $menus);
    }

}
