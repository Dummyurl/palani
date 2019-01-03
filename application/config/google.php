<?php 
switch (ENVIRONMENT)
{

	case 'testing':
			$config['google_client_id']              = '1020045244965-b061b5b5mu2vqf7hdltkutsndgr5tjn2.apps.googleusercontent.com';
			$config['google_secrete_key']          = 'JUwDQUFuiA3EEgaWRJqGhlBk';
	break;

	case 'production':	
			$config['google_client_id']              = '850649979601-objc4en5i6stpqmu4u5hihe9k899g4pv.apps.googleusercontent.com';
			$config['google_secrete_key']          = 'cTIRnuPUIxvA1ZmGPWLJr9lU';
	break;


	default:
		$config['google_client_id']              = '1020045244965-b061b5b5mu2vqf7hdltkutsndgr5tjn2.apps.googleusercontent.com';
		$config['google_secrete_key']          = 'JUwDQUFuiA3EEgaWRJqGhlBk';
}
