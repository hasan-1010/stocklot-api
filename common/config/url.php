<?php
return [
	'urlManagerFrontend' => [
		'class'           => 'yii\web\UrlManager',
		'baseUrl'         => 'frontend/web/',
		'enablePrettyUrl' => true,
		'showScriptName'  => false,
	],
	'urlManagerBackend'  => [
		'class'           => 'yii\web\UrlManager',
		'baseUrl'         => 'backend/web',
		'enablePrettyUrl' => true,
		'showScriptName'  => false,
	]
];