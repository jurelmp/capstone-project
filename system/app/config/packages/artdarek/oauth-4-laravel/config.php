<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '817250551667564',
            'client_secret' => '7f0392f400cf359fe3174e5aea8d4bf4',
            'scope'         => array('email','read_friendlists','user_online_presence'),
        ),		

	)

);