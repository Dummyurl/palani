<?php 
switch (ENVIRONMENT)
{

	case 'testing':
			$config['facebook_app_id']              = '767763670273360';
			$config['facebook_app_secret']          = '477d518f64ad530bfd13df661cc09481';
	break;

	case 'production':	
			$config['facebook_app_id']              = '268186057168377';
			$config['facebook_app_secret']          = '2772594b6840a8faf354fa9b17326b80';
	break;

	default:
		$config['facebook_app_id']              = '767763670273360';
		$config['facebook_app_secret']          = '477d518f64ad530bfd13df661cc09481';
}

$config['facebook_login_redirect_url']  = 'applicant_fb_login/user_authentication/';
$config['facebook_logout_redirect_url'] = 'user/logout';
$config['facebook_permissions']         = array('email');
$config['facebook_graph_version']       = 'v3.1';
