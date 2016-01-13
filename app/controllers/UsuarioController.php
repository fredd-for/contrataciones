<?php

class UsuarioController extends ControllerBase {

    // public function initialize() {
    //     parent::initialize();
    // }

    public function profileAction() {
        $id=$this->_user->id;
        $mUsuario=new usuarios();
        $user=$mUsuario->profileUsuario($id);        
        $this->view->setVar('user', $user[0]);
        if ($this->request->isPost()) {
            $password = $this->request->getPost('password_actual');
            $password_nuevo = $this->request->getPost('password_nuevo');
            $password_repetir = $this->request->getPost('password_repetir');
            $password = hash_hmac('sha256', $password, '2, 4, 6, 7, 9, 15, 20, 23, 25, 30');
            if($user[0]->password == $password){
                if($password_nuevo == $password_repetir){
                    $p =hash_hmac('sha256', $password_nuevo, '2, 4, 6, 7, 9, 15, 20, 23, 25, 30');
                    $resul = usuarios::findFirstById($id);
                    $resul->password = $p;
                    if ($resul->save()) {
                        $this->flashSession->success('<b>Exito!</b> Contraseña actualizada correctamente');    
                    }else{
                        $this->flashSession->success('<b>Error!</b> realice la operación de nuevo');            
                    }

                }else{
                    $this->flashSession->success('<b>Error!</b> Nueva Contraseña no coincide con la contraseña repetida');        
                }
                
            }else{
                $this->flashSession->error('<b>Error!</b> Contraseña Actual no es correcto');    
            }

        }

    }

    public function logoutAction() {
        $this->session->remove('auth');
        $this->flash->success('Goodbye!');
        $this->response->redirect('/login');
    }

}
