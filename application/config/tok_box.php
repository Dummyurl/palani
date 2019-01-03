<?php 

switch (ENVIRONMENT)
{

	case 'testing':
			$config['apiKey']              = '46148072';
			$config['apiSecret']          = '3b85429caab05729ad0476754be53f49de087f88';
	break;

	case 'production':	
			// $config['apiKey']              = '46219002';
			// $config['apiSecret']          = 'f310fc4f351d8360cc982b00742e7736215abaa2';

			$config['apiKey']              = '46148072';
			$config['apiSecret']          = '3b85429caab05729ad0476754be53f49de087f88';
	break;

	default:
			$config['apiKey']              = '46148072';
			$config['apiSecret']          = '3b85429caab05729ad0476754be53f49de087f88';
}

 ?>
