<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */

App::uses('HtmlHelper', 'View/Helper');

class GtwUserHelper extends Helper {
    
    public $helpers = array('Session');
    
    public function getLink(){
        
        $name = 'sign in | sign up';
        $link = '/gtw_users/users/signin';
        
        if ($this->Session->read('Auth.User')){
            $name = $this->Session->read('Auth.User.email');
            $link = '/gtw_users/users/edit/' . $this->Session->read('Auth.User.id');
        }
        
        return "<a href='". $link ."'>". $name ."</a>";
    }
}