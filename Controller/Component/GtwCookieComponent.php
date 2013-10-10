<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */

App::uses('Component', 'Controller');


class GtwCookieComponent extends Component {
    
    public $components = array('Cookie','Auth');
    
    public function init(){
        $this->Cookie->key = Configure::read('GtwCookie.key');
        $this->Cookie->httpOnly = true;
    }
    
    public function autolog(){
        if(!$this->Cookie->read('remember_me') || $this->Auth->loggedIn()){
            return;
        }
        
        $cookie = $this->Cookie->read('remember_me');

        $this->request->data = $this->User->find('first', array(
            'conditions' => array(
                'User.username' => $cookie['username'],
                'User.token' => $cookie['token'],
                'User.token_creation >=' => date('Y-m-d H:i:s', strtotime(Configure::read('GtwCookie.loginDuration'))),
            )
        ));
        
        if(!$this->Auth->login())
            $this->redirect(array('plugin' => 'GtwUsers', 'controller' => 'users', 'action' => 'signout' ));
        };
    }
    
    public function rememberMe($userInfo){
        $this->Cookie->write('remember_me', $userInfo, true, strtotime(Configure::read('GtwCookie.loginDuration')));
    }
    public function forgetMe($userInfo){
        $this->Cookie->delete('remember_me');
    }
    
}