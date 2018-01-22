<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Googleplus {
	
	public function __construct($theme='') {	
              
                $theme = $theme['theme'];
                if($theme=="applicant")
                {
                    $theme="user";
                }
              
		$this->ci =& get_instance();
		//$this->ci->config->load('googleplus');
		require APPPATH .'third_party/google-login-api/apiClient.php';
		require APPPATH .'third_party/google-login-api/contrib/apiOauth2Service.php';
		if($this->ci->session->userdata('google_user_type') == 'guru'){
                    $theme="guru";
                 }
               // if($this->session->userdata('signup_type'))
                
		$this->client = new apiClient();
		$this->client->setApplicationName('schoolGuru');
		// $this->client->setClientId('839853077566-dolm4ae2pckc21icnqrm33u59hgu179d.apps.googleusercontent.com');
  //       $this->client->setClientSecret('j7NYIOWIfmCpGTc11Qzfnpd9');
        $this->client->setClientId('1020045244965-b061b5b5mu2vqf7hdltkutsndgr5tjn2.apps.googleusercontent.com');
		$this->client->setClientSecret('JUwDQUFuiA3EEgaWRJqGhlBk');
        $this->ci->session->set_userdata('google_user_type','user');
        $this->client->setRedirectUri(base_url().'user/get_google_details');
               
		$this->client->setDeveloperKey('googleplus');
		$this->client->setScopes($this->ci->config->item('scopes', 'https://www.googleapis.com'));
		$this->client->setAccessType('offline');
		$this->client->setApprovalPrompt('force');
		$this->oauth2 = new apiOauth2Service($this->client);

	}
    public function loginURL() {
        return $this->client->createAuthUrl();
    }
	
    public function signupURL() {
        return $this->client->createAuthUrl();
    }
    
    public function getAuthenticate() {
        return $this->client->authenticate();
    }
	
	public function getAccessToken() {
        return $this->client->getAccessToken();
    }
	
	public function setAccessToken() {
        return $this->client->setAccessToken();
    }
	
	public function revokeToken() {
        return $this->client->revokeToken();
    }
	
	public function getUserInfo() {
        return $this->oauth2->userinfo->get();
    }
	
}
?>