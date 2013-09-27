<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */

class UsersController extends GtwUsersAppController {
    
    public $uses = array('GtwUsers.User');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('signup', 'signin');
    }

    public function index() {
        /*$this->User->recursive = 0;
        $this->set('users', $this->paginate());*/
    }

    public function delete($id = null) {
        /*if (!$this->request->is('post')) {
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
        return $this->redirect(array('action' => 'index'));*/
    }
    
    public function edit($id = null) {
        /*$this->User->id = $id;
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
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }*/
    }
    
    public function signin(){
        
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
        $this->Session->setFlash('Username or password is incorrect');
    }
    public function signinAjax(){
        
        if ($this->request->is('post')) {
        
            $this->request->data['User']['password'] = $this->request->data['password'];
            $this->request->data['User']['username'] = $this->request->data['email'];
            
            if ($this->Auth->login()) {
                return new CakeResponse(array('body'=> json_encode(array(
                        'message'=>'User has successfully signed in.'
                    )),
                        'status' => 200
                ));
                
            }
        }
        return new CakeResponse(array('body'=> json_encode(array(
                'message'=>'Wrong login or password'
            )),
                'status' => 401
        ));
    }

    public function signout() {
        return $this->redirect($this->Auth->logout());
    }
    
    public function signup() {
        
        $data['User']['username'] = $this->request->data['email'];
        $data['User']['password'] = $this->request->data['password'];
        $data['User']['role'] = 'default';
        $data['User']['created'] = null;
        $data['User']['modified'] = null;
        
        if ($this->request->is('post')) {
            
            $this->User->create();
            if ($this->User->save($data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return new CakeResponse(array('body'=> json_encode(array(
                        'message'=>'User has successfully signed in.'
                    )),
                        'status' => 200
                ));
            }
            
            return new CakeResponse(array('body'=> json_encode(array(
                    'message'=>'Wrong login or password'
                )), 
                    'status' => 401
            ));
        }
    }
    
    public function signupAjax() {
        
        $data['User']['username'] = $this->request->data['email'];
        $data['User']['password'] = $this->request->data['password'];
        $data['User']['role'] = 'default';
        $data['User']['created'] = null;
        $data['User']['modified'] = null;
        
        if ($this->request->is('post')) {
            
            $this->User->create();
            if ($this->User->save($data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return new CakeResponse(array('body'=> json_encode(array(
                        'message'=>'User has successfully signed in.'
                    )),
                        'status' => 200
                ));
            }
            
            return new CakeResponse(array('body'=> json_encode(array(
                    'message'=>'Wrong login or password'
                )), 
                    'status' => 401
            ));
        }
    }
    
    public function view($id = null) {
        /*$this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));*/
    }
    
}