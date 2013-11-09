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
        $this->Auth->allow('signup', 'signin');
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
    }
    
    public function signin(){
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                if (isset($this->request->data['User']['remember'])){
                    $this->GtwCookie->rememberMe(CakeSession::read("Auth"));
                }
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Session->setFlash('Username or password is incorrect');
        }
    }
    
    public function signout() {
        $this->GtwCookie->forgetMe();
        return $this->redirect($this->Auth->logout());
    }
    
    public function signup() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                if ($this->Auth->login()) {
                    if (isset($this->request->data['User']['remember'])){
                        $this->User->updateToken();
                        $this->GtwCookie->rememberMe(CakeSession::read("Auth"));
                    }
                    //return $this->redirect($this->Auth->redirectUrl());
                }
            }
            $this->Session->setFlash('Account can not be created');
        }
        return $this->redirect(array('action' => 'signin'));
    }
    
    public function view($id = null) {
        $this->User->id = $id;
        
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->safeRead(null, $id));
    }
    
}