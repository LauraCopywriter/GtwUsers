<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */

App::uses('HtmlHelper', 'View/Helper');

class GtwUserHelper extends Helper {
    
    public $helpers = array('Session', 'Html');
    
    public function getLink(){
        
        $name = 'sign in | sign up';
        $route = array('plugin' => 'gtw_users', 'controller' => 'users', 'action' => 'signin');
        
        if ($this->Session->read('Auth.User')){
            $name = $this->Session->read('Auth.User.email');
            $route = array(
                'plugin' => 'gtw_users',
                'controller' => 'users', 
                'action' => 'edit',
                $this->Session->read('Auth.User.id')
            );
        }
        
        return $this->Html->link($name, $route);
    }
    
    public function editLnk($userId){
        return $this->Html->link(
            '<i class="icon-edit"> </i>',
            array(
                'plugin' => 'gtw_users', 
                'controller' => 'users', 
                'action' => 'edit',
                $userId
            ),
            array('escape' => FALSE)
        );
    }

    public function messageLnk($userId){
        return $this->Html->link(
            '<i class="icon-envelope-alt"> </i>',
            array(
                'plugin' => 'gtw_users', 
                'controller' => 'users', 
                'action' => 'message',
                $userId
            ),
            array('escape' => FALSE)
        );
    }
    
    public function deleteLnk($userId){
        return $this->Html->link(
            '<i class="icon-remove"> </i>',
            array(
                'plugin' => 'gtw_users', 
                'controller' => 'users', 
                'action' => 'delete',
                $userId
            ),
            array('escape' => FALSE)
        );
    }
    
    public function viewLnk($userId, $text){
        return $this->Html->link(
            $text,
            array(
                'plugin' => 'gtw_users', 
                'controller' => 'users', 
                'action' => 'view',
                $userId
            ),
            array('escape' => FALSE)
        );
    }
}