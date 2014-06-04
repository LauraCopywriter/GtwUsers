<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */

App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {

    public $validate = array(
        'first' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'First name is required'
            )           
        ),
        'last' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Last name is required'
            )           
        ),
        'email' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'An email address is required'
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => 'Please enter valid Email Address'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'required' => 'create',
                'message' => 'Email address already exists'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        )
    );
    
    public function beforeSave($options = array()) {
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }
    
    public function resetToken(){
        if (!$this->safeRead(null, CakeSession::read("Auth.User.id"))){
            return false;
        }
        
        $this->data['User']['token'] = md5(uniqid(rand(),true));
        $this->data['User']['token_creation'] = date("Y-m-d H:i:s");
        
        return $this->save();
    }
    
    public function safeRead($fields = null, $id = null) {
        parent::read($fields, $id);
        if (isset($this->data['User']['password'])){
            unset($this->data['User']['password']);
        }
        return $this->data;
    }
    
    public function updateToken(){
        
        if (!$this->safeRead(null, CakeSession::read("Auth.User.id"))){
            return false;
        }
        
        App::uses('CakeTime', 'Utility');
        
        $emptyToken = !$this->data['User']['token'];
        $expiredToken = CakeTime::wasWithinLast(
            Configure::read('GtwCookies.loginDuration'), 
            $this->data['User']['token_creation']
        );

        if ( $emptyToken || $expiredToken ){
            $this->data['User']['token'] = md5(uniqid(rand(),true));
            $this->data['User']['token_creation'] = date("Y-m-d H:i:s");
        }
        
        return $this->save();
    }
    
    public function isValidated($email){
        $user = $this->findByEmail($email);
        if (!isset($user)){
            return false;
        }
        return $user['User']['validated'];
    }
    
    public function signupMail($email){
        $user = $this->findByEmail($email);
        unset($user['User']['password']);
        
        $user['User']['token'] = md5(uniqid(rand(),true));
        $user['User']['token_creation'] = date("Y-m-d H:i:s");
        
        $this->save($user);
        $this->sendSignupMail($user);
        
        return true;
    }
    
    public function sendSignupMail($user){
        App::uses('CakeEmail', 'Network/Email');
        
        $email = new CakeEmail();
        
        $email->template('GtwUsers.signup');
        $email->emailFormat('html');
        $email->viewVars(array('userId' => $user['User']['id'], 'token' => $user['User']['token']));
        
        $email->from(Configure::read('Gtw.admin_mail'));
        $email->to($user['User']['email']);
        $email->subject('Account validation');
        $response = $email->send();
    }
    
    public function confirmation($userId, $token) {
        $user = $this->safeRead(null, $userId);
        if (!$user){
            return false;
        }
        if ($user['User']['token'] != $token){
            return false;
        }
        $user['User']['validated'] = true;
        if (!$this->save($user)){
            return false;
        }
        
        return $user;
    }
	public function ForgotPasswordEmail($email){
        $user = $this->findByEmail($email);
        $arrResponse = array('status'=>'fail','message'=>'Unable to send forgot password email, Please try again');
        if(empty($user)){
        	return array('status'=>'fail','message'=>'No matching email found');	
        }elseif (empty($user['User']['validated'])){
        	return array('status'=>'fail','message'=>'Your email is not validated yet');
        }
        unset($user['User']['password']);
        
        $user['User']['token'] = md5(uniqid(rand(),true));
        $user['User']['token_creation'] = date("Y-m-d H:i:s");
        
        $this->save($user);
        if($this->sendForgotPasswordEmail($user)){
        	$arrResponse = array('status'=>'success','message'=>'Please check your e-mail for forgot password');	
        }
        return $arrResponse ;
    }
	public function sendForgotPasswordEmail($user){
        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail();
        $email->template('GtwUsers.forgot_password');
        $email->emailFormat('html');
        $email->viewVars(array('userId' => $user['User']['id'], 'token' => $user['User']['token']));
        
        $email->from(Configure::read('Gtw.admin_mail'));
        $email->to($user['User']['email']);
        $email->subject('Forgot Password');
        return $email->send();
    }
    public function checkForgotPassword($userId, $token) {
    	App::uses('CakeTime', 'Utility');
    	$arrResponse = array('status'=>'fail','message'=>'Invalid forgot password token');
        $user = $this->safeRead(null, $userId);
        if(!empty($user) && $user['User']['token'] == $token){
        	if(!CakeTime::wasWithinLast('+1 day',$this->data['User']['token_creation'])){
        		$arrResponse = array('status'=>'fail','message'=>'Forgot Password token is expired');		
        	}else{
        		$arrResponse = array('status'=>'success','message'=>'Valid Token');
        	}
        }
        return $arrResponse;        
    }    
}
