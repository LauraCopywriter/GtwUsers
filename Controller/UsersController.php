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
        $this->Auth->allow('signup', 'signin', 'signout', 'confirmation', 'forgot_password', 'reset_password', 'resend_verification', 'public_profile');

        if ($this->Session->read('Auth.User')) {
            $this->Auth->allow('edit');
        }

        if (is_null(Configure::read('Gtw.admin_mail'))) {
            echo 'Users plugin configuration error';
            exit;
        }
    }

    public function index() {
        $this->layout = 'GtwUsers.users';
        $this->User->recursive = 0;
        $arrConditions = array();
        if ($this->Session->read('Auth.User.role') != 'admin') {
            //$arrConditions = array('company_id'=>$this->Session->read('Auth.User.company_id'));
        }
        $this->paginate = array(
            'User' => array(
                'order' => array('id' => 'desc'),
            //'conditions' => $arrConditions
            )
        );
        $this->set('users', $this->paginate('User'));
    }

    public function delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash(__('Invalid user'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-success'
            ));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'), 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-danger'
        ));
        return $this->redirect(array('action' => 'index'));
    }

    public function edit($userId = 0) {
        $this->User->id = $userId;

        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        } else {
            $this->request->data = $this->User->safeRead(null, $this->User->id);
            if (!empty($this->request->data['File']['filename'])) {
                $this->set('avatar', $this->User->File->getUrl($this->request->data['File']['filename']));
            }
        }
        $this->set('users', $this->User->find('list'));
        if (CakePlugin::loaded('GtwFiles')) {
            $this->render('/Users/edit_avatar');
        }
    }

    public function signin() {
        $this->layout = 'GtwUsers.users';

        if ($this->request->is('post')) {

            // login
            if ($this->Auth->login()) {
                if (isset($this->request->data['User']['remember'])) {
                    $this->GtwCookie->rememberMe(CakeSession::read("Auth"));
                }
                // User needs to be validated
                if (!$this->User->isValidated($this->request->data['User']['email'])) {
                    $this->Session->setFlash(
                            'Please validate your email address.', 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger'
                    ));
                }

                if ($this->Session->read('Auth.User.role') == 'admin') {
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $loginRedirect = Configure::read('GtwUser.userLoginRedirect');
                    if(!empty($loginRedirect)){
                        return $this->redirect($loginRedirect);
                    }
                    return $this->redirect(array('action'=>'profile'));
                }
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
        $this->layout = 'GtwUsers.users';

        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->User->signupMail($this->request->data['User']['email']);
                $this->Session->setFlash('Please check your e-mail to validate your account', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash('Error creating your account, please contact an administrator', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            }
        }
    }

    public function confirmation($userId = null, $token = null) {
        $this->layout = 'GtwUsers.users';

        if ($userId || $token) {
            $user = $this->User->confirmation($userId, $token);
            if (!empty($user['User']['validated'])) {
                $this->Session->setFlash('Your email address is already validated, please use email and password to login', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
                return $this->redirect($this->Auth->redirectUrl());
            } elseif (isset($user) && $this->Auth->login($user['User'])) {
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
        if (CakePlugin::loaded('GtwFiles')) {
            $this->render('/Users/view_avatar');
        }
    }

    public function update_avatar($userId = 0, $fileId = 0) {
        if (!empty($this->request->data['id'])) {
            $userId = $this->request->data['id'];
        }
        if (!empty($this->request->data['file_id'])) {
            $fileId = $this->request->data['file_id'];
        }
        $user = $this->User->safeRead(null, $userId);
        $oldFile = $user['User']['file_id'];
        $user['User']['file_id'] = $fileId;

        if ($this->User->save($user)) {
            $this->User->File->deleteFile($oldFile);
            $this->User->File->id = $fileId;
            return new CakeResponse(array(
                'body' => json_encode(array(
                    'message' => __('Profile photo has been change successfully.'),
                    'success' => True,
                    'file' => '/' . $this->User->File->getUrl($this->User->File->field('filename')),
                )),
                'status' => 200
            ));
        } else {
            return new CakeResponse(array(
                'body' => json_encode(array(
                    'message' => __('Unable to change profile photo, Try again.'),
                    'success' => false
                )),
                'status' => 200
            ));
        }
    }

    public function forgot_password() {
        //Check For Already Logged In
        if ($this->Auth->login()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->layout = 'GtwUsers.users';
        if ($this->request->is('post')) {
            $arrResponse = $this->User->ForgotPasswordEmail($this->request->data['User']['email']);
            if (!empty($arrResponse)) {
                if ($arrResponse['status'] == 'fail') {
                    $this->Session->setFlash($arrResponse['message'], 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger'
                    ));
                } else {
                    $this->Session->setFlash($arrResponse['message'], 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success'
                    ));
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
        }
    }

    public function reset_password($userId = null, $token = null) {
        $this->layout = 'GtwUsers.users';
        if ($userId && $token) {
            $arrResponse = $this->User->checkForgotPassword($userId, $token);
            if ($arrResponse['status'] == 'fail') {
                $this->Session->setFlash($arrResponse['message'], 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
                return $this->redirect($this->Auth->loginAction);
            }
        } else {
            $this->Session->setFlash('Invalid Token', 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
            return $this->redirect($this->Auth->loginAction);
        }
        $this->set(compact('userId', 'token'));
        if ($this->request->is('post')) {
            if ($this->request->data['User']['new_password'] != $this->request->data['User']['new_password']) {
                $this->Session->setFlash('New Password and Confirm Password must be same', 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            } else {
                $this->request->data['User']['id'] = $userId;
                $this->request->data['User']['password'] = $this->request->data['User']['new_password'];
                $this->request->data['User']['token'] = md5(uniqid(rand(), true));
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

    public function add() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data["User"]["validated"] = 1;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been created successfully'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add user. Please, try again.'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));
        }
        $this->set('users', $this->User->find('list'));
    }

    public function public_profile($userId) {
        if (!empty($userId)) {
            $files = $this->User->File->find('all',array('conditions'=>array('File.user_id'=>$userId),'recursive'=>-1));
            $userDetails = $this->User->safeRead(null, $userId);
            if (!empty($userDetails['File']['filename'])) {
                $this->set('avatar', $this->User->File->getUrl($userDetails['File']['filename']));
            }
            $this->set(compact('userDetails'));
            $this->set(compact('files'));
        }
    }

    function profile() {
        
    }

    public function change_password() {
        if (!empty($this->request->data)) {
            $password = $this->User->find('first', array(
                'fields' => array('password'),
                'conditions' => array(
                    'id' => $this->Session->read('Auth.User.id')
                ),
                'recursive' => "-1")
            );

            if (AuthComponent::password($this->request->data ['User']['current_password']) != $password ['User'] ['password']) {
                $this->Session->setFlash(__('Old Password does not match.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            } elseif ($this->request->data ['User'] ['new_password'] != $this->request->data ['User'] ['confirm_password']) {
                $this->Session->setFlash(__('Confirm Password entered does not match.'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            } elseif ($this->request->data ['User'] ['new_password'] == "") {
                $this->Session->setFlash(__('New Password Must Not Blank'), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-danger'
                ));
            } else {
                $this->request->data['User']['id'] = $this->Session->read('Auth.User.id');
                $this->request->data['User']['password'] = $this->request->data['User']['new_password'];
                $this->request->data['User']['confirm_password'] = AuthComponent::password($this->request->data ['User']['confirm_password']);
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('Password has been updated Successfully.'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success'
                    ));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('Unable to Change Password, Please try again.'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger'
                    ));
                }
            }
        }
    }

    /**
     * Checks if an email is already verified and if not renews the expiration time
     *
     * @return void
     */
    public function resend_verification() {
        if ($this->request->is('post')) {
            $arrResponse = $this->User->ResendVerification($this->request->data['User']['email']);
            if (!empty($arrResponse)) {
                if ($arrResponse['status'] == 'fail') {
                    $this->Session->setFlash($arrResponse['message'], 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger'
                    ));
                } else {
                    $this->Session->setFlash($arrResponse['message'], 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success'
                    ));
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
        }
    }

}
