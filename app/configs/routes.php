<?php
/**
 * Created by PhpStorm.
 * User: madesst
 * Date: 28.09.13
 * Time: 16:51
 */

$app = EA\Application::getInstance();

$routes = array(
	array(
		'name' => 'bootstrap',
		'method' => 'get',
		'path' => '/',
		'controller' => 'iframe.controller:bootstrapAction'
	),
	array(
		'name' => 'report',
		'method' => 'get',
		'path' => '/report',
		'controller' => 'iframe.controller:reportAction'
	),
	array(
		'name' => 'homepage',
		'method' => 'get',
		'path' => '/{source_id}',
		'controller' => 'iframe.controller:indexAction'
	),
	array(
		'name' => 'register',
		'method' => 'post',
		'path' => '/{source_id}',
		'controller' => 'iframe.controller:indexAction'
	),
	array(
		'name' => 'confirm',
		'method' => 'get',
		'path' => '/confirm/{token_string}',
		'controller' => 'iframe.controller:confirmAction'
	),
);

foreach($routes as $route){
	$method = $route['method'] ? $route['method'] : 'get';
	$app->$method($route['path'], $route['controller'])->bind($route['name']);
}