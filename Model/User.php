<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */

App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {

    public $validate = array(
        'email' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'An email address is required'
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
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
    
    public function safeRead($fields = null, $id = null) {
        parent::read($fields, $id);
        if (isset($this->data[$this->alias]['password'])){
            unset($this->data[$this->alias]['password']);
        }
        return $this->data;
    }
    
    public function resetToken(){
        if (!$this->safeRead(null, CakeSession::read("Auth.User.id"))){
            return false;
        }
        
        $this->data[$this->alias]['token'] = md5(uniqid(rand(),true));
        $this->data[$this->alias]['token_creation'] = date("Y-m-d H:i:s");
        
        return $this->save();
    }
    
    public function updateToken(){
        
        if (!$this->safeRead(null, CakeSession::read("Auth.User.id"))){
            return false;
        }
        
        App::uses('CakeTime', 'Utility');
        
        $emptyToken = $this->data[$this->alias]['token'] == 0;
        $expiredToken = CakeTime::wasWithinLast(
            Configure::read('GtwCookies.loginDuration'), 
            $this->data[$this->alias]['token_creation']
        );

        if ( $emptyToken || $expiredToken ){
            $this->data[$this->alias]['token'] = md5(uniqid(rand(),true));
        }
        
        return $this->save();
    }
    
}