<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			// uncomment the following to provide test database connection
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=pikitestdb',
                                'emulatePrepare' => true,
                                'username' => 'kengarybizweb',
                                'password' => 'j4Wrr^39',
                                'charset' => 'utf8',
			),
			
		),
	)
);
