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
        $this->ci->load->config('google');      


        require APPPATH .'third_party/google-login-api/apiClient.php';
        require APPPATH .'third_party/google-login-api/contrib/apiOauth2Service.php';

        if($this->ci->session->userdata('google_user_type') == 'guru'){
            $theme="guru";
        }

        $this->client = new apiClient();
        $this->client->setApplicationName('Mentoring');	

        $this->client->setClientId($this->ci->config->item('google_client_id'));
        $this->client->setClientSecret($this->ci->config->item('google_secrete_key')); 

        $this->ci->session->set_userdata('google_user_type','user');
        $this->client->setRedirectUri(base_url().'user/get_google_details');               
        $this->client->setDeveloperKey('AIzaSyAVx0aFEaguM_ocw26GV0xqK0Od6JxnvQI');
        $this->client->setScopes($this->ci->config->item('scopes', 'https://www.googleapis.com'));
        $this->client->setAccessType('online');
        $this->client->setApprovalPrompt('auto');
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