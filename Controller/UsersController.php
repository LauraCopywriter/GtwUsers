<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */

class UsersController extends AppController {
    
    public $uses = array('GtwUsers.User');
    public $helpers = array(
        'Html' => array('className' => 'GtwUi.GtwHtml')
    );
    
    public $components = array('GtwUsers.GtwCookie');
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('signup', 'signin', 'signout', 'confirmation','forgot_password','reset_password');
        
        if( $this->Session->read('Auth.User') ){
            $this->Auth->allow('edit');
        }
        
        if( is_null( Configure::read('Gtw.admin_mail') ) ){
            echo 'Users plugin configuration error'; exit;
        }
    }
    
    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }
    
    public function edit() {
    
        $this->User->id = $this->Session->read('Auth.User')['id'];
        
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        } else {
            $this->request->data = $this->User->safeRead(null, $this->User->id);
        }
        if (CakePlugin::loaded('GtwFiles')){
            $this->render('/Users/edit_avatar');
        }
    }
    
    public function signin(){
        $this->layout = false;
        if ($this->request->is('post')) {
            
            // login
            if ($this->Auth->login()) {
                if (isset($this->request->data['User']['remember'])){
                    $this->GtwCookie->rememberMe(CakeSession::read("Auth"));
                }
                // User needs to be validated
                if (!$this->User->isValidated($this->request->data['User']['email'])){
                    $this->Session->setFlash(
                        'Please validate your email address.', 
                        'alert', array(
                            'plugin' => 'BoostCake',
                            'class' => 'alert-danger'
                    ));
                }
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash('Username or password is incorrect', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
                return $this->redirect($this->Auth->loginAction);
            }
        }
    }
    
    public function signout() {
        $this->GtwCookie->forgetMe();
        return $this->redirect($this->Auth->logout());
    }
    
    public function signup() {
        $this->layout = false;
        
        if ($this->request->is('post')) {
            $this->User->create();
            if($this->User->save($this->request->data)){
                $this->User->signupMail($this->request->data['User']['email']);
                $this->Session->setFlash('Please check your e-mail to validate your account', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
            }else{
                $this->Session->setFlash('Error creating your account, please contact an administrator', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            }
            
            return $this->redirect($this->Auth->redirectUrl());
        }
    }
    
    public function confirmation($userId = null, $token = null) {
        $this->layout = false;
        
        if($userId || $token){
            $user = $this->User->confirmation($userId, $token);
            if(!empty($user['User']['validated'])){
                   $this->Session->setFlash('Your email address is already validated, please use email and password to login', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
                return $this->redirect($this->Auth->redirectUrl());
            }elseif (isset($user) && $this->Auth->login($user['User'])) {
                $this->Session->setFlash('Email address successfuly validated', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash('The authorization link provided is erroneous, please contact an administrator', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
        
        $this->Session->setFlash('Please check your e-mail for validation link', 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-info'
        ));
        return $this->redirect($this->Auth->redirectUrl());
    }
    
    public function view($id = null) {
        $this->User->id = $id;
        
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->safeRead(null, $id));
        if (CakePlugin::loaded('GtwFiles')){
            $this->render('/Users/view_avatar');
        }
    }
    
    public function update_avatar($userId, $fileId){
        $user = $this->User->safeRead(null, $userId);
        $oldFile = $user['User']['file_id'];
        $user['User']['file_id'] = $fileId;
        if ($this->User->save($user)) {
            $this->User->File->delete($oldFile);
        }
    }
    public function forgot_password(){
        //Check For Already Logged In
        if ($this->Auth->login()){
             return $this->redirect($this->Auth->redirectUrl());           
        }    
        $this->layout = false;
        if ($this->request->is('post')){
            $arrResponse = $this->User->ForgotPasswordEmail($this->request->data['User']['email']);
            if(!empty($arrResponse)){
                   if($arrResponse['status']=='fail'){
                     $this->Session->setFlash($arrResponse['message'], 'alert', array(
                            'plugin' => 'BoostCake',
                            'class' => 'alert-danger'
                       ));        
                   }else{
                       $this->Session->setFlash($arrResponse['message'], 'alert', array(
                            'plugin' => 'BoostCake',
                            'class' => 'alert-success'
                       ));
                       return $this->redirect($this->Auth->redirectUrl());
                   }
            }
        }
    }
    
    public function reset_password($userId = null, $token = null){
        $this->layout = false;        
        if($userId && $token){
            $arrResponse = $this->User->checkForgotPassword($userId,$token);
            if($arrResponse['status']=='fail'){
                $this->Session->setFlash($arrResponse['message'], 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
                return $this->redirect($this->Auth->loginAction);
            }                        
        }else{
            $this->Session->setFlash('Invalid Token', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            return $this->redirect($this->Auth->loginAction);
        }
        $this->set(compact('userId','token'));
        if ($this->request->is('post')) {
            if($this->request->data['User']['new_password'] != $this->request->data['User']['new_password']){
                $this->Session->setFlash('New Password and Confirm Password must be same', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            }else{
                $this->request->data['User']['id'] = $userId; 
                $this->request->data['User']['password'] = $this->request->data['User']['new_password'];
                $this->request->data['User']['token'] = md5(uniqid(rand(),true));
                $this->request->data['User']['token_creation'] = date("Y-m-d H:i:s");
                $this->User->save($this->request->data);
                
                $this->Session->setFlash('Your password has been updated successfully', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect($this->Auth->loginAction);
            }
        }
    }
}