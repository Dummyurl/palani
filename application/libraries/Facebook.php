<?php
if(!session_id()){
  session_start();
}

// Include the autoloader provided in the SDK
require_once(APPPATH . '../vendor/autoload.php');

// Include required libraries
use Facebook\Facebook as FB;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

Class Facebook{

  public function __construct(){

 

  if (!isset($this->fb)){
      $this->fb = new FB(array(
        'app_id' =>  $this->config->item('facebook_app_id'),
        'app_secret' => $this->config->item('facebook_app_secret'),
        'default_graph_version' => $this->config->item('facebook_graph_version')
      ));
    }  

      // Get redirect login helper
    $this->helper = $this->fb->getRedirectLoginHelper();

    

  }

  public function login_url(){       
        // Get login url
    return $this->helper->getLoginUrl(
      base_url() . $this->config->item('facebook_login_redirect_url'),
      $this->config->item('facebook_permissions')
    );
  }

/**
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * @param $var
     *
     * @return mixed
     */
public function __get($var){
  return get_instance()->$var;
}


}



?>