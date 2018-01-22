<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  Facebook API Configuration
| -------------------------------------------------------------------
|
| To get an facebook app details you have to create a Facebook app
| at Facebook developers panel (https://developers.facebook.com)
|
|  facebook_app_id               string   Your Facebook App ID.
|  facebook_app_secret           string   Your Facebook App Secret.
|  facebook_login_type           string   Set login type. (web, js, canvas)
|  facebook_login_redirect_url   string   URL to redirect back to after login. (do not include base URL)
|  facebook_logout_redirect_url  string   URL to redirect back to after logout. (do not include base URL)
|  facebook_permissions          array    Your required permissions.
|  facebook_graph_version        string   Specify Facebook Graph version. Eg v2.6
|  facebook_auth_on_load         boolean  Set to TRUE to check for valid access token on every page load.
*/



// $config['facebook_app_id']              = '701219256745807';
// $config['facebook_app_secret']          = '3970b8b13df3899f7aaf48744da71999';



$config['facebook_app_id']              = '1957170461173705';
$config['facebook_app_secret']          = 'a6949f81b398ff6b7c3ae03799ce0a11';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = 'user/login_confirmation';
$config['facebook_signup_applicant_redirect_url']  = 'user/login';
$config['facebook_signup_guru_redirect_url']  = 'user/login';
$config['facebook_logout_redirect_url'] = 'user_authentication/logout';
$config['facebook_permissions']         = array('email');
$config['facebook_graph_version']       = 'v2.6';
$config['facebook_auth_on_load']        = TRUE;