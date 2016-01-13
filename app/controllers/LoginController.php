<?php

require_once('../app/libs/nusoap/nusoap.php');

class LoginController extends \Phalcon\Mvc\Controller {

    //login  
    public function indexAction() {
        $auth = $this->session->get('auth');
        if ($auth) {
            $this->response->redirect('/');
        }
        $this->view->setMainView('login');
        $this->view->setLayout('login');

        if ($this->request->isPost()) {
            $usuario = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $password = hash_hmac('sha256', $password, '2, 4, 6, 7, 9, 15, 20, 23, 25, 30');
            $user = usuarios::findFirst(
                            array(
                                "username = :usuario: AND password = :password: AND habilitado= :estado:",
                                "bind" => array('usuario' => $usuario, 'password' => $password, 'estado' => 1)
            ));
            if ($user != false) {         
                $user->logins = $user->logins + 1;
                $user->lastlogin = time();
                $user->save();
                $this->_registerSession($user);
                //$this->flashSession->success('Bienvenido <i>' . $user->nombre . '</i>');
                $this->response->redirect('/');
            }else{
                $this->flashSession->error('<b>Acceso denegado!</b> Usuario/contraseña incorrectos');    
            }
            
        }     
    }

    public function passwordAction() {
         $this->view->setMainView('login');
        $this->view->setLayout('login');
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email');                        
            //buscamos el mail
            $user = usuarios::findFirst(
                            array(
                                "email = :email: AND habilitado= :estado:",
                                "bind" => array('email' => $email, 'estado' => 1)
            ));
            if ($user != false) {
                //acutalizamos la cantidad de ingresos
                $user->logins = $user->logins + 1;
                $user->lastlogin = time();
                $user->save();
                $this->_registerSession($user);
                $this->flashSession->success('Bienvenido <i>' . $user->nombre . '</i>');
                $this->response->redirect('/dashboard');
            }
            $this->flashSession->error('Email inexsitente en el sistema, o usuario No habilitado');
        }
    }
//registro de la session
    private function _registerSession($user) {
        $this->session->set('auth', array(
            'id' => $user->id,
            'name' => $user->username,
            'nombre' => $user->nombre,
            'cargo' => $user->cargo,
            'nivel' => $user->nivel,
        ));
    }    
    public function exitAction() {
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');
        $this->response->redirect('/login');
    }

    
}
