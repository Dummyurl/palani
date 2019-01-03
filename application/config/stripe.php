<?php 


switch (ENVIRONMENT)
{

	case 'testing':
	$config['stripe_publishable_key']              = 'pk_test_qlzHuLtAkIm5AkM3XYXQ6JUp';
	$config['stripe_secret_key']          = 'sk_test_nKMiwRltszi5bNOIjTW3EoxV';
	break;

	case 'production':	
	$config['stripe_publishable_key']              = 'pk_live_0lMIU5kQMxbr5UWfK1HtlxvA';
	$config['stripe_secret_key']          = 'sk_live_IYQpKok7YUJwk36W7LJ7u28t';
	break;

	default:
	$config['stripe_publishable_key']              = 'pk_test_qlzHuLtAkIm5AkM3XYXQ6JUp';
	$config['stripe_secret_key']          = 'sk_test_nKMiwRltszi5bNOIjTW3EoxV';
}



?>
