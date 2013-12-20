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
        $this->Auth->allow('signup', 'signin', 'confirmation');
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
    
    public function edit($id = null) {
        $this->User->id = $id;
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
            $this->request->data = $this->User->safeRead(null, $id);
        }
        if (CakePlugin::loaded('GtwFiles')){
            $this->render('/Users/edit_avatar');
        }
    }
    
    public function signin(){
        $this->layout = false;
        if ($this->request->is('post')) {
            
            // User needs to be validated
            if (!$this->User->isValidated($this->request->data['User']['email'])){
                $this->Session->setFlash(
                    'Please validate your email address.', 
                    'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger'
                ));
                return $this->redirect($this->Auth->redirectUrl());
            }
            
            // login
            if ($this->Auth->login()) {
                if (isset($this->request->data['User']['remember'])){
                    $this->GtwCookie->rememberMe(CakeSession::read("Auth"));
                }
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash('Username or password is incorrect', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
                return $this->redirect($this->Auth->redirectUrl());
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
            if (isset($user) && $this->Auth->login($user['User'])) {
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
    
}