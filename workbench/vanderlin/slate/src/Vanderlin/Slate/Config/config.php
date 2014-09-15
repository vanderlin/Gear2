<?php return array (

	'app' => array(
		'debug' => true,
		),


	'site-name' 				=> 'StarterSite',
	'site-password' 			=> 'demo',
	'google_creds' 				=> 'local',
	'use_google_login' 			=> false,
	'use_site_login' 			=> false,
	'active-bootstrap-theme' 	=> '1',

	'google' => array(
		
				'remote' => array (
							    'api_key' 		=> 'API_KEY',
							    'client_id' 	=> 'CLIENT_ID',
							    'client_secret' => 'CLIENT_SECRET',
							    'redirect_uri'  => 'URI',
							    'scopes' 		=> 'SCOPES',
							    'app_name' 		=> 'APP_NAME'
						    ),
			 	'local' => array (
				    		'api_key' 		=> 'API_KEY',
				    		'client_id' 	=> 'CLIENT_ID',
				    		'client_secret' => 'CLIENT_SECRET',
				    		'redirect_uri'  => 'URI',
				    		'scopes' 		=> 'SCOPES',
				    		'app_name' 		=> 'APP_NAME'
				    	)
				 ),

	'database'=> array(	
				
				'connections' => array (

						'mysql' => array (
							'driver' 	=> 'mysql',
						    'host' 		=> 'localhost',
						    'database' 	=> 'dev',
						    'username' 	=> 'root',
						    'password' 	=> 'root',
						    'charset' 	=> 'utf8',
						    'collation' => 'utf8_unicode_ci',
						    'prefix' 	=> 'abc_'
						),
				)
	)

);





