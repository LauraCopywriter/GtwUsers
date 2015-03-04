<?php

App::uses('AppController', 'Controller');

class SocialSignupController extends AppController {

    var $name = 'Users';
    var $uses = array("User", "SocialConnect");
    var $components = array('Auth');
    var $objCommon = null;

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'facebook', 'google');
    }

    function index() {
        $this->redirect('/');
    }

    function facebook() {

        App::import('Vendor', 'GtwUsers.Social/OauthConnect');
        $oauth = new OauthConnect();
        $oauth->provider = "Facebook";
        $oauth->client_id = Configure::read('Social.Facebook.consumer_key');
        $oauth->client_secret = Configure::read('Social.Facebook.consumer_secret');
        $oauth->redirect_uri = Router::url(array('controller' => 'social_signup', 'action' => 'facebook'), true);
        $oauth->scope = 'email,user_photos,user_mobile_phone';
        $oauth->Initialize();
        if ($this->request->query('code') == '') {
            $oauth->Authorize();
        } else {
            $oauth->code = $this->request->query('code');
            $getData = $oauth->getUserProfile();
            if (isset($getData->id)) {
                $arrUser = array();
                $arrUser['social_connect_type'] = 'facebook';
                $arrUser['first'] = $getData->first_name;
                $arrUser['last'] = $getData->last_name;
                $arrUser['email'] = $getData->email;
                $arrUser['valid_email'] = $getData->verified;
                $arrUser['social_profile_id'] = $getData->id;
                $arrUser['social_access_token'] = $getData->access_token;
                $arrUser['phone'] = isset($getData->mobile_phone) ? $getData->mobile_phone : '';
                $arrUser['address'] = isset($getData->location->name) ? $getData->location->name : '';
                $arrUser['social_profile_image'] = 'https://graph.facebook.com/' . $getData->id . '/picture?type=large';

                $this->__socialSignup($arrUser);
            }
            
            $this->Session->setFlash(__d('gtw_users','Facebook connect failed. Please try again!'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));

            $this->redirect(array("plugin"=>"gtw_users", "controller"=>"users", "action"=>"signin"));
            
        }
    }

    function google() {
        App::import('Vendor', 'GtwUsers.Social/OauthConnect');
        $oauth = new OauthConnect();
        $oauth->provider = "Google";
        $oauth->client_id = Configure::read('Social.Google.consumer_key');
        $oauth->client_secret = Configure::read('Social.Google.consumer_secret');
        $oauth->redirect_uri = Router::url(array('controller' => 'social_signup', 'action' => 'google'), true);
        $oauth->scope = 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile';
        $oauth->Initialize();
        if ($this->request->query('code') == '') {
            $oauth->Authorize();
        } else {
            $oauth->code = $this->request->query('code');
            $getData = $oauth->getUserProfile();
            if (isset($getData->id)) {
                $arrUser = array();
                
                $arrUser['social_connect_type'] = 'google';
                $arrUser['first'] = $getData->given_name;
                $arrUser['last'] = $getData->family_name;
                $arrUser['email'] = $getData->email;
                $arrUser['valid_email'] = $getData->verified_email;
                $arrUser['social_profile_id'] = $getData->id;
                $arrUser['social_access_token'] = $getData->access_token;
                $arrUser['social_profile_image'] = isset($getData->picture) ? $getData->picture : '';
                $this->__socialSignup($arrUser);
            }
            
            $this->Session->setFlash(__d('gtw_users','Google connect failed. Please try again!'), 'alert', array(
                'plugin' => 'BoostCake',
                'class' => 'alert-danger'
            ));

            $this->redirect(array("plugin"=>"gtw_users", "controller"=>"users", "action"=>"signin"));            
        }
    }

    function __socialSignup($arrUser = array()) {

        if (!empty($arrUser['email'])) {
            $user = $this->User->find('first', array('conditions' => array('email' => $arrUser['email'])));
            if(!empty($user)) {
                $arrUser["id"] = $user["User"]["id"];
            }
            else{
                $this->User->create();
            }
            
            $arrUser["validated"] = "1";
            $this->User->saveAll(array("User"=>$arrUser), array('validate' => false));
            $this->Auth->login($arrUser);
            $arrUser['user_id'] = $this->User->id;
            $arrConditions = array(
                            'user_id' => $arrUser['user_id'],
                            'social_connect_type' => $arrUser['social_connect_type'],
                            'social_profile_id' => $arrUser['social_profile_id']
                        );
            $arrSocialConnect = $this->SocialConnect->find('first', array('conditions' =>$arrConditions));
            //Unset User Id            
            if(!empty($arrSocialConnect)){ // Set Id for Update Value of Social Connect
                $arrUser['id'] = $arrSocialConnect['SocialConnect']['id'];
            }elseif(!empty($arrUser['id'])){ //Unset UserId from array if exist
                unset($arrUser['id']);
            }else{
                $this->SocialConnect->create();
            }
            
            
            $this->SocialConnect->save(array("SocialConnect"=>$arrUser));                
            
            if($this->Auth->login()){
                $this->Session->setFlash(__d('gtw_users','You have successfully connected using %s', ucfirst($arrUser['social_connect_type'])), 'alert', array(
                    'plugin' => 'BoostCake',
                    'class' => 'alert-success'
                ));

                $this->redirect(array("plugin"=>"gtw_users", "controller"=>"Users", "action"=>"profile"));
            }            
        }
        
        $this->Session->setFlash(__d('gtw_users','connect failed. Please try again!'), 'alert', array(
            'plugin' => 'BoostCake',
            'class' => 'alert-danger'
        ));

        $this->redirect(array("plugin"=>"gtw_users", "controller"=>"users", "action"=>"signin"));
    }

}

?>
