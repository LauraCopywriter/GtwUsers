<?php
/*
	@author		:	Santosh Yadav
	@date 		:	12th July, 2013
	@oauth2		:	Support following oauth2 login
					Microsoft(MSN,Live,Hotmail)	
					Facebook
					Google
					Box
					WordPress
					Bitly
					MeetUp
					StockTwits
*/

class OauthConnect{
  	public $socialmedia_oauth_connect_version = '1.0';
	public $client_id;
	public $client_secret;
	public $scope;
	public $responseType;
	public $nonce;
	public $state;
	public $redirect_uri;
	public $code;
	public $oauth_version;
	public $provider;
	public $accessToken;  
	
	protected $requestUrl;
  	protected $accessTokenUrl;
  	protected $dialogUrl;
	protected $userProfileUrl;
	protected $header;
  	public function Initialize(){
  		$this->nonce = time() . rand();
  		switch($this->provider){
			case '';
				break;
			case 'Microsoft':
				$this->oauth_version="2.0";			
				$this->dialogUrl = 'https://login.live.com/oauth20_authorize.srf?';
				$this->accessTokenUrl = 'https://login.live.com/oauth20_token.srf';
				$this->responseType="code";
				$this->userProfileUrl = "https://apis.live.net/v5.0/me?access_token=";
				$this->header="";
				break;
			case 'Facebook':
				$this->oauth_version="2.0";			
				$this->dialogUrl = 'https://www.facebook.com/dialog/oauth?client_id='.$this->client_id.'&redirect_uri='.$this->redirect_uri.'&scope='.$this->scope.'&state='.$this->state;
				$this->accessTokenUrl = 'https://graph.facebook.com/oauth/access_token';
				$this->responseType="code";
				//$this->userProfileUrl = "https://graph.connect.facebook.com/me/?";
				$this->userProfileUrl = "https://graph.facebook.com/me/?";
				$this->header="";
				break;
			case 'Google':
				$this->oauth_version="2.0";			
				$this->dialogUrl = 'https://accounts.google.com/o/oauth2/auth?';
				$this->accessTokenUrl = 'https://accounts.google.com/o/oauth2/token';
				$this->responseType="code";
				$this->userProfileUrl = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=";
				$this->header="Authorization: Bearer ";	
				break;
			case 'Box':
				$this->oauth_version="2.0";			
				$this->dialogUrl = 'https://www.box.com/api/oauth2/authorize?';
				$this->accessTokenUrl = 'https://www.box.com/api/oauth2/token?';
				$this->responseType="code";
				$this->userProfileUrl = "https://api.box.com/2.0/users/me?oauth_token=";
				$this->header="Authorization: Bearer ";				
				break;
			case 'WordPress':
				$this->oauth_version="2.0";
				$this->dialogUrl = 'https://public-api.wordpress.com/oauth2/authorize?';
				$this->accessTokenUrl = 'https://public-api.wordpress.com/oauth2/token?';
				$this->responseType="code";
				$this->scope="";
				$this->state="";
				$this->userProfileUrl = "https://public-api.wordpress.com/rest/v1/me/?pretty=1";
				$this->header="Authorization: Bearer ";
				break;
			case 'Bitly':
				$this->oauth_version="2.0";
				$this->dialogUrl = 'https://bitly.com/oauth/authorize?';
				$this->accessTokenUrl = 'https://api-ssl.bitly.com/oauth/access_token?';
				$this->responseType="code";
				$this->scope="";
				$this->state="";
				$this->userProfileUrl = "https://api-ssl.bitly.com/v3/user/info?";
				$this->header="";
				break;
			case 'MeetUp':
				$this->oauth_version="2.0";			
				$this->dialogUrl = 'https://secure.meetup.com/oauth2/authorize?';
				$this->accessTokenUrl = 'https://secure.meetup.com/oauth2/access?';
				$this->responseType="code";
				$this->userProfileUrl = "https://api.meetup.com/2/member/self?access_token=";
				$this->scope="basic";
				break;
			case 'StockTwits':
				$this->oauth_version="2.0";			
				$this->dialogUrl = 'https://api.stocktwits.com/api/2/oauth/authorize?';
				$this->accessTokenUrl = 'https://api.stocktwits.com/api/2/oauth/token?';
				$this->responseType="code";
				$this->userProfileUrl = "https://api.stocktwits.com/api/2/account/verify.json?access_token=";
				$this->scope="read";
				break;
			default:
				return($this->provider.'is not yet a supported. We will release soon. Contact kayalshri@gmail.com!' );	
		}
  	} 
  	public function Authorize(){
  		if($this->oauth_version == "2.0"){
			$dialog_url = $this->dialogUrl
					."client_id=".$this->client_id
					."&response_type=".$this->responseType
					."&scope=".$this->scope
					/*."&nonce=".$this->nonce*/
					."&state=".$this->state
					."&redirect_uri=".urlencode($this->redirect_uri);
					echo("<script> top.location.href='" . $dialog_url . "'</script>");
		}else{
			$date = new DateTime();
			$request_url = $this->requestUrl;
			$postvals ="oauth_consumer_key=".$this->client_id
     					."&oauth_signature_method=HMAC-SHA1"
     					."&oauth_timestamp=".$date->getTimestamp()
     					."&oauth_nonce=".$this->nonce
     					."&oauth_callback=".$this->redirect_uri
     					."&oauth_signature=".$this->client_secret
     					."&oauth_version=1.0";
			$redirect_url = $request_url."".$postvals;
   			$oauth_redirect_value= $this->curl_request($redirect_url,'GET','');
  			$dialog_url = $this->dialogUrl.$oauth_redirect_value;
			echo("<script> top.location.href='" . $dialog_url . "'</script>");
		}
  	}
  	public function getAccessToken(){
		$postvals = "client_id=".$this->client_id
						."&client_secret=".$this->client_secret
						."&grant_type=authorization_code"
						."&redirect_uri=".urlencode($this->redirect_uri)
						."&code=".$this->code;
		return $this->curl_request($this->accessTokenUrl,'POST',$postvals);
  	}
  	public function getUserProfile(){
  		$getAccessToken_value = $this->getAccessToken();
  		$getatoken = json_decode( stripslashes($getAccessToken_value) );
		if( $getatoken === NULL ){
			$atoken=$getAccessToken_value;
   		}else{
	   		$atoken = $getatoken->access_token;
   		}   
   		if($this->provider=="Yammer"){
   			$atoken = $getatoken->access_token->token;
   		}
  		$profile_url = $this->userProfileUrl."".$atoken;
  		$userProfile = json_decode($this->curl_request($profile_url,"GET",$atoken));
  		parse_str($atoken);
  		$userProfile->access_token = isset($access_token)?$access_token:'';
		return $userProfile;
  	} 
  	public function APIcall($url){
	  	return $this->curl_request($url,"GET",$_SESSION['atoken']);
  	}
  	public function debugJson($data){
  		echo "<pre>";
  		print_r($data);
  		echo "</pre>";
  	}
	public function curl_request($url,$method,$postvals){	
		$ch = curl_init($url);
		if ($method == "POST"){
		   $options = array(
	                CURLOPT_POST => 1,
	                CURLOPT_POSTFIELDS => $postvals,
	                CURLOPT_RETURNTRANSFER => 1,
			);
		}else{
		   $options = array(
	                CURLOPT_RETURNTRANSFER => 1,
			);
		}
		curl_setopt_array( $ch, $options );
		if($this->header){
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( $this->header . $postvals) );
		}
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}
}
?>
